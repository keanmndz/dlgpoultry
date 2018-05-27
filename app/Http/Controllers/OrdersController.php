<?php

namespace DLG\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use DLG\Orders;
use DLG\OrderDetails;
use DLG\Products;
use DLG\Cull;
use DLG\order_list;
use DLG\User;
use DLG\Customers;

class OrdersController extends Controller
{
    public function __construct()
    {
      $this->middleware('admin');
    }

    public function show()
    {
      $orders = Orders::all();

      return view('admin.orders', ['user' => Auth::user(), 'orders' => $orders]);
    }

    public function confirmReserve($id)
    {
    	$order = Orders::find($id);

    	$get = OrderDetails::where('order_id', '=', $order->order_id)->get();

        $list = new order_list();

        $total = 0.00;

    	foreach ($get as $item)
		{
            $product = Products::where('name', '=', $item->product_name)->first();

            $list->product_name = $item->product_name;

            if ($item->quantity >= 30)
                $mode = 'Wholesale';

            else
                $mode = 'Retail';

            if ($mode == 'Wholesale')
            {
                $price = $product->wholesale_price;
                $list->unit_price = $price;
            }

            else
            {
                $price = $product->retail_price;
                $list->unit_price = $price;                
            }

            $list->quantity = $item->quantity;
            $list->unit_price = $price;
            $qty = $item->quantity;
            $list->order_price = $price*$qty;
            $total += $list->order_price;
            $list->total = $total;
            $list->stocks = $product->stocks;

            $list->save();
		}

		return redirect('/pos')->with(['reserve' => $order, 'orderdetails' => $get]);
    }

    public function cancelReserve($id)
    {
    	$order = Orders::find($id);

    	$order->status = 'Cancelled';

    	$order->update();

    	return redirect('/orders')->with('success', 'You have cancelled this order!');
    }

    public function orderDetails($id)
    {
        $order = OrderDetails::where('order_id', '=', $id)->get();
        $total = 0.00;
        $sub = 0.00;

        foreach ($order as $item)
        {
            $sub = $item->quantity * $item->unit_price;
            $total += $sub;
        }

        return view('admin.orderdetails')->with(['user' => Auth::user(), 'order' => $order, 'total' => $total]);
    }
}
