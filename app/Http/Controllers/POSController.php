<?php

namespace DLG\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use DLG\Mail\OrderReceipt;
use Carbon\Carbon;
use DLG\order_list;
use DLG\Orders;
use DLG\Products;
use DLG\Customers;
use DLG\OrderDetails;
use DLG\Cull;
use DLG\Activity;
use DLG\Eggs;
use DLG\BrokenEggs;
use DLG\Sales;
use DLG\SoldEggs;
use Validator;
use Response;
use Mail;

class POSController extends Controller
{

   public function __construct()
   {
      $this->middleware('admin');
   }

   public function index()
   {

   	$update = Cull::orderBy('id', 'desc')->first();
    $inv = Products::where('name', '=', 'Cull')->first();

    $inv->stocks = $update->total;
	$inv->update();

	$get = Eggs::orderBy('id', 'desc')->first();
	$broken = BrokenEggs::orderBy('id', 'desc')->first();
	$update = Products::where('name', 'like', '%Eggs%')->get();

	foreach ($update as $item)
	{
		if ($item->name == 'Jumbo Eggs')
		{	
			$item->stocks = $get->total_jumbo;
			$item->update();
		}

		if ($item->name == 'Extra Large Eggs')
		{	
			$item->stocks = $get->total_xlarge;
			$item->update();
		}

		if ($item->name == 'Large Eggs')
		{	
			$item->stocks = $get->total_large;
			$item->update();
		}

		if ($item->name == 'Medium Eggs')
		{	
			$item->stocks = $get->total_medium;
			$item->update();
		}

		if ($item->name == 'Small Eggs')
		{	
			$item->stocks = $get->total_small;
			$item->update();
		}

		if ($item->name == 'Peewee Eggs')
		{	
			$item->stocks = $get->total_peewee;
			$item->update();
		}

		if ($item->name == 'Broken Eggs')
		{	
			$item->stocks = $broken->total;
			$item->update();
		}
	}

    $all = Products::where('name', 'not like', '%Eggs%')->get();
    $eggs = Products::where('name', 'like', '%Eggs%')->get();
    $orders = order_list::all();
    $gettotal = order_list::orderBy('id', 'desc')->first();

    if (empty($gettotal))
    	$total_order = 0;

    else
	    $total_order = $gettotal->total;

	$cust = Customers::all();

     return view('admin.pos', ['user' => Auth::user(), 'inv' => $all, 'orders' => $orders, 'total_order' => $total_order, 'cust' => $cust, 'eggs' => $eggs]);
   }

   public function currentOrder(Request $request)
	{
		$getlast = order_list::orderBy('id', 'desc')->first();

		if (empty($getlast))
			$gettotal = 0;

		else
			$gettotal = $getlast->total;

		$validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1|max:' . $request->stocks]);
	    if ($validator->fails()) {
	        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
	    } else {
			
			$current = order_list::where('product_name', '=', $request->name)->first();

			if (empty($current))
			{
				$quantity = $request->quantity;

				if ($quantity > $request->stocks)
					return Response::json(array('error' => 'Exceeds stock level!'));

				if ($quantity >= 30)
				{
					$mode = 'Wholesale';
					$price = $request->wholesale;
				}

				else
				{
					$mode = 'Retail';
					$price = $request->retail;
				}

				$current = new order_list();

				$current->product_name = $request->name;
				$current->mode = $mode;
				$current->stocks = $request->stocks;
				$current->unit_price = $price;
				$current->quantity = $quantity;
				$current->order_price = $price*$quantity;
				$current->total = $gettotal + ($price*$quantity);

				$current->save();

				return response()->json($current);
			
			}

			else
			{

				$check = $current->quantity + $request->quantity;
				
				if ($check > $request->stocks)
				{
					return Response::json(array('error' => 'Exceeds stock level!'));
				}

				else
				{	
					if ($check >= 30)
						$price = $request->wholesale;

					else
						$price = $request->retail;

					$current->quantity += $request->quantity;
					$current->order_price = $price*$check;
					$current->total += $price*$check;

					$current->update();

					return response()->json($current);
				}
			}

		}
		
	}

	public function cancelItem($id)
	{
		$item = order_list::find($id);

		$item->delete();

		return redirect('/pos')->with('user', Auth::user());
	}

	public function cancelOrder()
	{
		order_list::truncate();

		return redirect('/pos')->with(['user' => Auth::user(), 'success' => 'You have cancelled the current order.']);
	}

	public function confirmOrder(Request $request)
	{

		$total = order_list::orderBy('id', 'desc')->first();
		$getid = Sales::count();
	
		if ($getid == null || $getid == '' || $getid == '0')
            $getid = '1';
        else
            $getid++;

		$orderid = Carbon::now()->format('Ymd') . '-' . $getid;

		if (!empty($request->reserve))
		{
			$order = Orders::where('order_id', '=', $request->reserve)->first();

			$order->status = 'Successful';

			$order->update();

			$order = Orders::where('order_id', '=', $request->reserve)->get();

			foreach ($order as $item)
			{
				$custemail = $item->cust_email;
				$orderplaced = $item->order_placed;
				$reference = 'Order ID #' . $orderid;
			}
		}

		else
		{	
			$cust = Customers::find($request->id);
	
			if (empty($cust))
				$custemail = $request->cust;	
	
			else
				$custemail = $cust->email;

			$orderplaced = 'On-site';
			$reference = 'Sales ID #' . $orderid;
		}

		$trans = new Sales();
	
		$trans->trans_id = $orderid;
		$trans->total_cost = $total->total;
		$trans->cust_email = $custemail;
		$trans->user_id = Auth::user()->id;
		$trans->handled_by = Auth::user()->email;
		$trans->order_placed = $orderplaced;
		$trans->reference = $reference;
		$trans->trans_date = Carbon::now()->toDateString();

		$trans->save();

		$order = order_list::all();
		$total = 0.00;

		$batch = Eggs::orderBy('id', 'asc')->first();

		foreach ($order as $item)
		{
			$confirm = new OrderDetails();

			$confirm->order_id = $orderid;
			$confirm->product_name = $item->product_name;
			$confirm->quantity = $item->quantity;
			$confirm->unit_price = $item->unit_price;

			$confirm->save();

			$total += $item->unit_price * $item->quantity;

			if ($item->product_name == 'Cull')
			{
				$cull = Cull::orderBy('id', 'desc')->first();
				$cull->total -= $item->quantity;

				$cull->update();
			}

			if ($item->product_name == 'Jumbo Eggs')
			{
				$eggs = Eggs::orderBy('id', 'desc')->first();
				$eggs->total_jumbo -= $item->quantity;

				$eggs->update();

				$sold = new SoldEggs();

				$sold->trans_id = $orderid;
				$sold->size = 'Jumbo';
				$sold->quantity = $item->quantity;
				$sold->batch_no = substr($batch->batch_id, -1);
				$sold->batch_id = $batch->batch_id;
				$sold->trans_date = Carbon::now()->toDateString();
				$sold->trans_time = Carbon::now()->toTimeString();

				$sold->save();
			}

			if ($item->product_name == 'Extra Large Eggs')
			{
				$eggs = Eggs::orderBy('id', 'desc')->first();
				$eggs->total_xlarge -= $item->quantity;

				$eggs->update();

				$sold = new SoldEggs();

				$sold->trans_id = $orderid;
				$sold->size = 'Extra Large';
				$sold->quantity = $item->quantity;
				$sold->batch_no = substr($batch->batch_id, -1);
				$sold->batch_id = $batch->batch_id;
				$sold->trans_date = Carbon::now()->toDateString();
				$sold->trans_time = Carbon::now()->toTimeString();

				$sold->save();
			}

			if ($item->product_name == 'Large Eggs')
			{
				$eggs = Eggs::orderBy('id', 'desc')->first();
				$eggs->total_large -= $item->quantity;

				$eggs->update();

				$sold = new SoldEggs();

				$sold->trans_id = $orderid;
				$sold->size = 'Large';
				$sold->quantity = $item->quantity;
				$sold->batch_no = substr($batch->batch_id, -1);
				$sold->batch_id = $batch->batch_id;
				$sold->trans_date = Carbon::now()->toDateString();
				$sold->trans_time = Carbon::now()->toTimeString();

				$sold->save();
			}

			if ($item->product_name == 'Medium Eggs')
			{
				$eggs = Eggs::orderBy('id', 'desc')->first();
				$eggs->total_medium -= $item->quantity;

				$eggs->update();

				$sold = new SoldEggs();

				$sold->trans_id = $orderid;
				$sold->size = 'Medium';
				$sold->quantity = $item->quantity;
				$sold->batch_no = substr($batch->batch_id, -1);
				$sold->batch_id = $batch->batch_id;
				$sold->trans_date = Carbon::now()->toDateString();
				$sold->trans_time = Carbon::now()->toTimeString();

				$sold->save();
			}

			if ($item->product_name == 'Small Eggs')
			{
				$eggs = Eggs::orderBy('id', 'desc')->first();
				$eggs->total_small -= $item->quantity;

				$eggs->update();

				$sold = new SoldEggs();

				$sold->trans_id = $orderid;
				$sold->size = 'Small';
				$sold->quantity = $item->quantity;
				$sold->batch_no = substr($batch->batch_id, -1);
				$sold->batch_id = $batch->batch_id;
				$sold->trans_date = Carbon::now()->toDateString();
				$sold->trans_time = Carbon::now()->toTimeString();

				$sold->save();
			}

			if ($item->product_name == 'Peewee Eggs')
			{
				$eggs = Eggs::orderBy('id', 'desc')->first();
				$eggs->total_peewee -= $item->quantity;

				$eggs->update();

				$sold = new SoldEggs();

				$sold->trans_id = $orderid;
				$sold->size = 'Peewee';
				$sold->quantity = $item->quantity;
				$sold->batch_no = substr($batch->batch_id, -1);
				$sold->batch_id = $batch->batch_id;
				$sold->trans_date = Carbon::now()->toDateString();
				$sold->trans_time = Carbon::now()->toTimeString();

				$sold->save();
			}

			if ($item->product_name == 'Broken Eggs')
			{
				$eggs = BrokenEggs::orderBy('id', 'desc')->first();
				$eggs->total -= $item->quantity;

				$eggs->update();

				$sold = new SoldEggs();

				$sold->trans_id = $orderid;
				$sold->size = 'Broken';
				$sold->quantity = $item->quantity;
				$sold->batch_no = substr($batch->batch_id, -1);
				$sold->batch_id = $batch->batch_id;
				$sold->trans_date = Carbon::now()->toDateString();
				$sold->trans_time = Carbon::now()->toTimeString();

				$sold->save();
			}

			$prods = Products::where('name', '=', $item->product_name)->first();
			$prods->stocks -= $item->quantity;

			$prods->update();
		}

		$data = Sales::orderBy('id', 'desc')->first();
		$details = OrderDetails::where('order_id', '=', $data->trans_id)->get();

		if ($data->cust_email != 'One-time')
			Mail::to($data->cust_email)->send(new OrderReceipt($data, $details));

		$act = new Activity();

        $act->user_id = Auth::user()->id;
        $act->email = Auth::user()->email;
        $act->module = 'Point-of-Sale';
        $act->activity = 'Handled an order';
        $act->ref_id = $data->trans_id;
        $act->date_time = Carbon::now();

        $act->save();

		order_list::truncate();

	}
}
