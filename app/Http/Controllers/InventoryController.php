<?php

namespace DLG\Http\Controllers;

use DLG\Notifications\ActionApprovals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DLG\Eggs;
use DLG\Feeds;
use DLG\User;
use DLG\Supplies;
use DLG\Products;
use DLG\Medicines;
use DLG\Chickens;
use DLG\Pullets;
use DLG\Activity;
use DLG\BrokenEggs;
use DLG\RejectEggs;
use DLG\DeadChickens;
use DLG\TotalChickens;
use DLG\Cull;
use DLG\DeadPullets;
use DLG\TotalPullets;
use DLG\InventoryChanges;
use DLG\Approvals;
use Validator;
use Response;
use Rule;

class InventoryController extends Controller
{

    protected $feedsrules = [

      'name' => 'required|string|min:3|unique:feeds',
      'price' => 'required|integer|min:1',
      'quantity' => 'required|integer|min:1',
      'unit' => 'required',
      'remarks' => 'required|string|min:4',
      'reorder_level' => 'required|integer|min:1'

    ];

    protected $medsrules = [

      'name' => 'required|string|min:3|unique:medicines',
      'price' => 'required|integer|min:1',
      'quantity' => 'required|integer|min:1',
      'remarks' => 'required|string|min:4',
      'reorder_level' => 'required|integer|min:1'

    ];

    protected $suppliesrules = [

      'name' => 'required|string|min:3|unique:supplies',
      'price' => 'required|integer|min:1',
      'quantity' => 'required|integer|min:1',
      'remarks' => 'required|string|min:4',
      'reorder_level' => 'required|integer|min:1'

    ];

    protected $prodsrules = [

      'name' => 'required|string|min:3|unique:products',
      'retail' => 'required|integer|min:1',
      'wholesale' => 'required|integer|min:1',
      'remarks' => 'required|string|min:4',
      'stocks' => 'required|integer|min:1'

    ];

    protected $eggrules = [

      'batch_id' => 'required|integer',
      'jumbo' => 'required_without_all:xlarge,large,medium,small,peewee,softshell,reject',
      'xlarge' => 'required_without_all:jumbo,large,medium,small,peewee,softshell,reject',
      'large' => 'required_without_all:jumbo,xlarge,medium,small,peewee,softshell,reject',
      'medium' => 'required_without_all:jumbo,xlarge,large,small,peewee,softshell,reject',
      'small' => 'required_without_all:jumbo,xlarge,large,medium,peewee,softshell,reject',
      'peewee' => 'required_without_all:jumbo,xlarge,large,medium,small,softshell,reject',
      'softshell' => 'required_without_all:jumbo,xlarge,large,medium,small,peewee,reject',
      'reject' => 'required_without_all:jumbo,xlarge,large,medium,small,peewee,softshell',
      'remarks' => 'string|min:4'

    ];

    protected $eggrules1 = [

      'jumbo' => 'required_without_all:xlarge,large,medium,small,peewee,softshell',
      'xlarge' => 'required_without_all:jumbo,large,medium,small,peewee,softshell',
      'large' => 'required_without_all:jumbo,xlarge,medium,small,peewee,softshell',
      'medium' => 'required_without_all:xlarge,large,jumbo,small,peewee,softshell',
      'small' => 'required_without_all:xlarge,large,medium,jumbo,peewee,softshell',
      'peewee' => 'required_without_all:xlarge,large,medium,small,jumbo,softshell',
      'softshell' => 'required_without_all:xlarge,large,medium,small,peewee,jumbo',
      'remarks' => 'required|string|min:4'

    ];

    // Show

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function show()
    {
    	$feeds = Feeds::all();
      $meds = Medicines::all();
      $supp = Supplies::all();
      $changes = InventoryChanges::all();
      
      $update = Cull::orderBy('id', 'desc')->first();
      $inv = Products::where('name', '=', 'Cull')->first();

      $inv->stocks = $update->total;
      $inv->update();

      $update = Eggs::orderBy('id', 'desc')->first();
      $broken = BrokenEggs::orderBy('id', 'desc')->first();
      $inv = Products::where('name', 'like', '%Eggs%')->get();

      foreach ($inv as $item)
      {
        $update = Eggs::orderBy('id', 'desc')->first();

        if ($item->name == 'Jumbo Eggs')
          $item->stocks = $update->total_jumbo;

        if ($item->name == 'Extra Large Eggs')
          $item->stocks = $update->total_xlarge;

        if ($item->name == 'Large Eggs')
          $item->stocks = $update->total_large;

        if ($item->name == 'Medium Eggs')
          $item->stocks = $update->total_medium;

        if ($item->name == 'Small Eggs')
          $item->stocks = $update->total_small;

        if ($item->name == 'Peewee Eggs')
          $item->stocks = $update->total_peewee;

        if ($item->name == 'Broken Eggs')
          $item->stocks = $broken->total;

        $item->update();
      }

      $prods = Products::all();


    	return view('admin.inventory', ['user' => Auth::user(), 'feeds' => $feeds, 'meds' => $meds, 'supp' => $supp, 'prods' => $prods, 'changes' => $changes]);
    }

    public function add(Request $request)
    {

      if ($request->type == 'feeds')
      {

      $validator = Validator::make(Input::all(), $this->feedsrules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            

            if (Auth::user()->access == 'Farm Hand')
            {

                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Add New';
                $add->module = 'Inventory - Feeds';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->item_name = $request->name;
                $add->price = $request->price;
                $add->quantity = $request->quantity;
                $add->unit = $request->unit;
                $add->reorder_level = $request->reorder_level;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
            }

            else
            {
              $inv = new Feeds();

              $inv->name = $request->name;
              $inv->price = $request->price;
              $inv->quantity = $request->quantity;
              $inv->unit = $request->unit;
              $inv->reorder_level = $request->reorder_level;
              $inv->added_by = Auth::user()->email;

              $inv->save();

              $changes = new InventoryChanges;

              $changes->name = $request->name;
              $changes->type = 'Feeds';
              $changes->activity = 'Added new feed';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Feeds';
              $act->activity = 'Added a new item: ' . $request->name;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();

              return response()->json($inv);
            }
        }
      }

      if ($request->type == 'meds')
      {

      $validator = Validator::make(Input::all(), $this->medsrules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {

                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Add New';
                $add->module = 'Inventory - Medicines';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->item_name = $request->name;
                $add->price = $request->price;
                $add->quantity = $request->quantity;
                $add->unit = $request->unit;
                $add->reorder_level = $request->reorder_level;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
            }
            

            else
            {
              $inv = new Medicines();

              $inv->name = $request->name;
              $inv->price = $request->price;
              $inv->quantity = $request->quantity;
              $inv->unit = $request->unit;
              $inv->reorder_level = $request->reorder_level;
              $inv->expiry = Carbon::now()->addYears(3)->toDateString();
              $inv->added_by = Auth::user()->email;

              $inv->save();

              $changes = new InventoryChanges;

              $changes->name = $request->name;
              $changes->type = 'Medicines';
              $changes->activity = 'Added new medicine';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Medicines';
              $act->activity = 'Added a new item: ' . $request->name;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();

              return response()->json($inv);
            }
        }
      }

      if ($request->type == 'supplies')
      {

      $validator = Validator::make(Input::all(), $this->suppliesrules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {

                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Add New';
                $add->module = 'Inventory - Supplies';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->item_name = $request->name;
                $add->price = $request->price;
                $add->quantity = $request->quantity;
                $add->reorder_level = $request->reorder_level;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
            }

            else
            {
              $inv = new Supplies();

              $inv->name = $request->name;
              $inv->price = $request->price;
              $inv->quantity = $request->quantity;
              $inv->reorder_level = $request->reorder_level;
              $inv->added_by = Auth::user()->email;

              $inv->save();

              $changes = new InventoryChanges;

              $changes->name = $request->name;
              $changes->type = 'Supplies';
              $changes->activity = 'Added new supply item';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Supplies';
              $act->activity = 'Added a new item: ' . $request->name;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();

              return response()->json($inv);
            }
        }
      }

      if ($request->type == 'products')
      {

      $validator = Validator::make(Input::all(), $this->prodsrules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {

                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Add New';
                $add->module = 'Inventory - Products';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->item_name = $request->name;
                $add->price = $request->retail;
                $add->reorder_level = $request->wholesale;
                $add->quantity = $request->stocks;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
            }

            else
            {
              $inv = new Products();

              $inv->name = $request->name;
              $inv->retail_price = $request->retail;
              $inv->wholesale_price = $request->wholesale;
              $inv->stocks = $request->stocks;
              $inv->added_by = Auth::user()->email;

              $inv->save();

              $changes = new InventoryChanges;

              $changes->name = $request->name;
              $changes->type = 'Products';
              $changes->activity = 'Added new product';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Products';
              $act->activity = 'Added a new item: ' . $request->name;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();

              return response()->json($inv);
            }
        }
      }
    }

    // Add quantities
    public function addQuantity(Request $request)
    {

      if ($request->type == 'feeds')
      {

      $validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1', 'remarks' => 'required|string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {

                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Add Quantity';
                $add->module = 'Inventory - Feeds';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->quantity = $request->quantity;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
            }

            else
            {
              $inv = Feeds::find($request->id);

              $sum = $inv->quantity;
              $add = $request->quantity;

              $inv->quantity = $sum + $add;
              $inv->updated_at = Carbon::now();

              $inv->update();

              $changes = new InventoryChanges;

              $changes->name = $request->name;
              $changes->type = 'Feeds';
              $changes->activity = 'Added quantity';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Feeds';
              $act->activity = 'Added quantity for: ' . $request->name;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();

              return response()->json($inv);
            }
        }
      }

      if ($request->type == 'meds')
      {

      $validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1', 'remarks' => 'required|string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {

              $add = new Approvals();

              $add->email = Auth::user()->email;
              $add->action = 'Add Quantity';
              $add->module = 'Inventory - Medicines';
              $add->remarks = $request->remarks;
              $add->status = 'Pending';
              $add->request_id = $request->id;
              $add->quantity = $request->quantity;
              $add->item_name = $request->name;

              $add->save();

              $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

              return response()->json($add);
            }
            
            else
            {
              $inv = Medicines::find($request->id);

              $sum = $inv->quantity;
              $add = $request->quantity;

              $inv->quantity = $sum + $add;
              $inv->updated_at = Carbon::now();

              $inv->update();

              $changes = new InventoryChanges;

              $changes->name = $request->name;
              $changes->type = 'Medicines';
              $changes->activity = 'Added quantity';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Medicines';
              $act->activity = 'Added quantity for: ' . $request->name;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();

              return response()->json($inv);
            }
        }
      }

      if ($request->type == 'supplies')
      {

      $validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1', 'remarks' => 'required|string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {

              $add = new Approvals();

              $add->email = Auth::user()->email;
              $add->action = 'Add Quantity';
              $add->module = 'Inventory - Supplies';
              $add->remarks = $request->remarks;
              $add->status = 'Pending';
              $add->request_id = $request->id;
              $add->quantity = $request->quantity;
              $add->item_name = $request->name;

              $add->save();

              $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

              return response()->json($add);
            }

            else
            {
              $inv = Supplies::find($request->id);

              $sum = $inv->quantity;
              $add = $request->quantity;

              $inv->quantity = $sum + $add;
              $inv->updated_at = Carbon::now();

              $inv->update();

              $changes = new InventoryChanges;

              $changes->name = $request->name;
              $changes->type = 'Supplies';
              $changes->activity = 'Added quantity';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Supplies';
              $act->activity = 'Added quantity for: ' . $request->name;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();

              return response()->json($inv);
            }
        }
      }

      if ($request->type == 'products')
      {

      $validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1', 'remarks' => 'required|string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {

              $add = new Approvals();

              $add->email = Auth::user()->email;
              $add->action = 'Add Quantity';
              $add->module = 'Inventory - Products';
              $add->remarks = $request->remarks;
              $add->status = 'Pending';
              $add->request_id = $request->id;
              $add->quantity = $request->quantity;
              $add->item_name = $request->name;

              $add->save();

              $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

              return response()->json($add);
            }
            
            else
            {
              $inv = Products::find($request->id);

              $sum = $inv->stocks;
              $add = $request->quantity;

              $inv->stocks = $sum + $add;
              $inv->updated_at = Carbon::now();

              $inv->update();

              $changes = new InventoryChanges;

              $changes->name = $request->name;
              $changes->type = 'Products';
              $changes->activity = 'Added stocks';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Products';
              $act->activity = 'Added stocks for: ' . $request->name;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();

              return response()->json($inv);
            }
        }
      }

    }

    // use quantities
    public function useQuantity(Request $request)
    {
      if ($request->type == 'feeds')
      {
        $rules = Feeds::find($request->id);

      $validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1', 'remarks' => 'string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            
            $inv = Feeds::find($request->id);
            $check = $inv->quantity - $request->quantity;
            
            if ($check < 0)
            {
              return response()->json(array('error' => 'Check your count!'));
            }

            else
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Use Quantity';
                $add->module = 'Inventory - Feeds';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->quantity = $request->quantity;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $sum = $inv->quantity;
                $use = $request->quantity;
    
                $inv->quantity = $sum - $use;
                $inv->updated_at = Carbon::now();
    
                $inv->update();
    
                $changes = new InventoryChanges;
    
                $changes->name = $request->name;
                $changes->type = 'Feeds';
                $changes->activity = 'Used quantity';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();
    
                $changes->save();
    
                $act = new Activity();
    
                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Feeds';
                $act->activity = 'Used quantity of: ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();
    
                $act->save();
    
                return response()->json($inv);
              }
            }
        }
      }

      if ($request->type == 'meds')
      {

      $validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1', 'remarks' => 'string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            
            $inv = Medicines::find($request->id);
            $check = $inv->quantity - $request->quantity;
            
            if ($check < 0)
            {
              return response()->json(array('error' => 'Check your count!'));
            }

            else
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Use Quantity';
                $add->module = 'Inventory - Medicines';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->quantity = $request->quantity;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $sum = $inv->quantity;
                $use = $request->quantity;
    
                $inv->quantity = $sum - $use;
                $inv->updated_at = Carbon::now();
    
                $inv->update();
    
                $changes = new InventoryChanges;
    
                $changes->name = $request->name;
                $changes->type = 'Medicines';
                $changes->activity = 'Used quantity';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();
    
                $changes->save();
    
                $act = new Activity();
    
                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Medicines';
                $act->activity = 'Used quantity of: ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();
    
                $act->save();
    
                return response()->json($inv);
              }
            }
        }
      }

      if ($request->type == 'supplies')
      {

      $validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1', 'remarks' => 'string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            
            $inv = Supplies::find($request->id);

            if ($check < 0)
            {
              return response()->json(array('error' => 'Check your count!'));
            }

            else
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Use Quantity';
                $add->module = 'Inventory - Supplies';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->quantity = $request->quantity;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $sum = $inv->quantity;
                $use = $request->quantity;

                $inv->quantity = $sum - $use;
                $inv->updated_at = Carbon::now();

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Supplies';
                $changes->activity = 'Used quantity';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Supplies';
                $act->activity = 'Used quantity of: ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                return response()->json($inv);
              }
            }
        }
      }

      if ($request->type == 'products')
      {

      $validator = Validator::make(Input::all(), ['quantity' => 'required|integer|min:1', 'remarks' => 'string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            
            $inv = Products::find($request->id);
            $check = $inv->stocks - $request->quantity;

            if ($check < 0)
            {
              return response()->json(array('error' => 'Check your count!'));
            }

            else
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Use Quantity';
                $add->module = 'Inventory - Products';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->quantity = $request->stocks;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $sum = $inv->stocks;
                $use = $request->quantity;

                if ($inv->product_name == 'Cull')
                {
                  $cull = Cull::orderBy('id', 'desc')->first();
                  $cull->total -= $use;

                  $cull->update();
                }

                if ($inv->product_name == 'Jumbo Eggs')
                {
                  $eggs = Eggs::orderBy('id', 'desc')->first();
                  $eggs->total_jumbo -= $use;

                  $eggs->update();
                }

                if ($inv->product_name == 'Extra Large Eggs')
                {
                  $eggs = Eggs::orderBy('id', 'desc')->first();
                  $eggs->total_xlarge -= $use;

                  $eggs->update();
                }

                if ($inv->product_name == 'Large Eggs')
                {
                  $eggs = Eggs::orderBy('id', 'desc')->first();
                  $eggs->total_large -= $use;

                  $eggs->update();
                }

                if ($inv->product_name == 'Medium Eggs')
                {
                  $eggs = Eggs::orderBy('id', 'desc')->first();
                  $eggs->total_medium -= $use;

                  $eggs->update();
                }

                if ($inv->product_name == 'Small Eggs')
                {
                  $eggs = Eggs::orderBy('id', 'desc')->first();
                  $eggs->total_small -= $use;

                  $eggs->update();
                }

                if ($inv->product_name == 'Peewee Eggs')
                {
                  $eggs = Eggs::orderBy('id', 'desc')->first();
                  $eggs->total_peewee -= $use;

                  $eggs->update();
                }

                if ($inv->product_name == 'Broken Eggs')
                {
                  $eggs = BrokenEggs::orderBy('id', 'desc')->first();
                  $eggs->total -= $use;

                  $eggs->update();
                }

                $inv->stocks = $sum - $use;
                $inv->updated_at = Carbon::now();

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Products';
                $changes->activity = 'Used stocks';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Products';
                $act->activity = 'Used stocks for: ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                return response()->json($inv);
              }
            }
        }
      }
    }

    public function updatePrice(Request $request)
    {
      $validator = Validator::make(Input::all(), ['id' => 'required|integer', 'remarks' => 'required|string', 'price' => 'required|integer|min:1']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if ($request->type == 'feeds')
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Price Update';
                $add->module = 'Inventory - Feeds';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->price = $request->price;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $total = Feeds::find($request->id);
                $total->price = $request->price;

                $total->update();

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Feeds';
                $changes->activity = 'Updated price of ' . $request->name;
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Feeds';
                $act->activity = 'Updated price of ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();
              }
            }

            if ($request->type == 'meds')
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Price Update';
                $add->module = 'Inventory - Medicines';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->price = $request->price;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $total = Medicines::find($request->id);
                $total->price = $request->price;
                
                $total->update();

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Medicines';
                $changes->activity = 'Updated price of ' . $request->name;
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Medicines';
                $act->activity = 'Updated price of ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();
              }
            }

            if ($request->type == 'supplies')
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Price Update';
                $add->module = 'Inventory - Supplies';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->price = $request->price;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $total = Supplies::find($request->id);
                $total->price = $request->price;
                
                $total->update();

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Supplies';
                $changes->activity = 'Updated price of ' . $request->name;
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Supplies';
                $act->activity = 'Updated price of ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();
              }
            }

            if ($request->type == 'prods')
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Price Update';
                $add->module = 'Inventory - Products';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->price = $request->price;
                $add->item_name = $request->name;
                $add->unit = $request->mode;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $total = Products::find($request->id);

                if ($request->mode == 'Retail')
                {
                  $total->retail_price = $request->price;
                  $total->update();
                }

                else
                {
                  $total->wholesale_price = $request->price;
                  $total->update();
                }

                return response()->json($total);

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Products';
                $changes->activity = 'Updated price of ' . $request->name;
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Products';
                $act->activity = 'Updated price of ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

              }
            }
        }
    }

    public function updateReorder(Request $request)
    {
      {
      $validator = Validator::make(Input::all(), ['id' => 'required|integer', 'reorder' => 'required|integer|min:1']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if ($request->type == 'feeds')
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Reorder Update';
                $add->module = 'Inventory - Feeds';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->reorder_level = $request->reorder;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $total = Feeds::find($request->id);
                $total->reorder_level = $request->reorder;

                $total->update();

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Feeds';
                $changes->activity = 'Updated reorder level of ' . $request->name;
                $changes->remarks = 'Reorder Level updated';
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Feeds';
                $act->activity = 'Updated reorder level of ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();
              }
            }

            if ($request->type == 'meds')
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Reorder Update';
                $add->module = 'Inventory - Medicines';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->reorder_level = $request->reorder;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $total = Medicines::find($request->id);
                $total->reorder_level = $request->reorder;
                
                $total->update();

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Medicines';
                $changes->activity = 'Updated reorder level of ' . $request->name;
                $changes->remarks = 'Reorder Level updated';
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Medicines';
                $act->activity = 'Updated reorder level of ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();
              }
            }

            if ($request->type == 'supplies')
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Reorder Update';
                $add->module = 'Inventory - Supplies';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->request_id = $request->id;
                $add->reorder_level = $request->reorder;
                $add->item_name = $request->name;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $total = Supplies::find($request->id);
                $total->reorder_level = $request->reorder;
                
                $total->update();

                $changes = new InventoryChanges;

                $changes->name = $request->name;
                $changes->type = 'Supplies';
                $changes->activity = 'Updated reorder level of ' . $request->name;
                $changes->remarks = 'Reorder Level updated';
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Supplies';
                $act->activity = 'Updated reorder level of ' . $request->name;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();
              }
            }

            return response()->json($total);
        }
    }
    }

    // Eggs

    public function showEggs()
    {

      $inv = Eggs::all();
      $broken = BrokenEggs::all();
      $reject = RejectEggs::all();
      $changes = InventoryChanges::where('type', '=', 'Eggs')->get();
      $total = Eggs::orderBy('id', 'desc')->first();
      $batches = TotalChickens::select('batch')->get();

      return view('admin.inveggs', ['inv' => $inv, 'broken' => $broken, 'reject' => $reject, 'changes' => $changes, 'total' => $total, 'batches' => $batches, 'user' => Auth::user()]);
    }

    public function addEggs(Request $request)
    {
      $life = Carbon::now();
      $life->addDays(7);
      $getcount = Eggs::orderBy('id', 'desc')->first();
      $total_jumbo = $getcount->total_jumbo;
      $total_xlarge = $getcount->total_xlarge;
      $total_large = $getcount->total_large;
      $total_medium = $getcount->total_medium;
      $total_small = $getcount->total_small;
      $total_peewee = $getcount->total_peewee;
      $total_softshell = $getcount->total_softshell;

      $messages = [
        'integer' => 'This should be an integer! ',
        'required_without_all' => 'Input atleast one field! '
      ];

      $validator = Validator::make(Input::all(), $this->eggrules, $messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {
              $add = new Approvals();
              $add->email = Auth::user()->email;
              $add->action = 'Add New';
              $add->module = 'Inventory - Eggs';
              $add->remarks = $request->remarks;
              $add->status = 'Pending';
              $add->request_id = Carbon::now()->format('YmdA') . '-' . $request->batch_id;
              
              if ($request->jumbo == null)
                $add->jumbo = 0;

              else
                $add->jumbo = $request->jumbo;

              if ($request->xlarge == null)
                $add->xlarge = 0;

              else
                $add->xlarge = $request->xlarge;

              if ($request->large == null)
                $add->large = 0;

              else
                $add->large = $request->large;

              if ($request->medium == null)
                $add->medium = 0;

              else
                $add->medium = $request->medium;

              if ($request->small == null)
                $add->small = 0;

              else
                $add->small = $request->small;

              if ($request->peewee == null)
                $add->peewee = 0;

              else
                $add->peewee = $request->peewee;

              if ($request->softshell == null)
                $add->softshell = 0;

              else
                $add->softshell = $request->softshell;

              if ($request->reject == null)
                $add->reject = 0;

              else
                $add->reject = $request->reject;

              $add->save();

              $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

              return response()->json($add);

            }

            else
            {
              $inv = new Eggs();

              $inv->batch_id = Carbon::now()->format('YmdA') . '-' . $request->batch_id;
              
              if ($request->jumbo == null)
                $inv->jumbo = 0;

              else
                $inv->jumbo = $request->jumbo;

              if ($request->xlarge == null)
                $inv->xlarge = 0;

              else
                $inv->xlarge = $request->xlarge;

              if ($request->large == null)
                $inv->large = 0;

              else
                $inv->large = $request->large;

              if ($request->medium == null)
                $inv->medium = 0;

              else
                $inv->medium = $request->medium;

              if ($request->small == null)
                $inv->small = 0;

              else
                $inv->small = $request->small;

              if ($request->peewee == null)
                $inv->peewee = 0;

              else
                $inv->peewee = $request->peewee;

              if ($request->softshell == null)
                $inv->softshell = 0;

              else
                $inv->softshell = $request->softshell;

              $inv->total_jumbo = $total_jumbo + $request->jumbo;
              $inv->total_xlarge = $total_xlarge + $request->xlarge;
              $inv->total_large = $total_large + $request->large;
              $inv->total_medium = $total_medium + $request->medium;
              $inv->total_small = $total_small + $request->small;
              $inv->total_peewee = $total_peewee + $request->peewee;
              $inv->total_softshell = $total_softshell + $request->softshell;
              $inv->added_by = Auth::user()->email;
              $inv->lifetime = $life->toDateString();
              $inv->created_at = Carbon::now()->toDateString();
              $inv->time_added = Carbon::now()->toTimeString();

              $inv->save();

              if ($request->reject != null)
              {
                $gettotal = RejectEggs::orderBy('id', 'desc')->first();
                $reject = new RejectEggs();

                $reject->batch_id = Carbon::now()->format('YmdA') . '-' . $request->batch_id;
                $reject->quantity = $request->reject;

                if (empty($gettotal))
                  $reject->total = $request->reject; 
                
                else
                  $reject->total = $gettotal->total + $request->reject;

                $reject->remarks = 'Reject from new batch';
                $reject->added_by = Auth::user()->email;

                $reject->save();
              }

              $changes = new InventoryChanges;

              $changes->name = 'Egg Batch ' . $request->batch_id;
              $changes->type = 'Eggs';
              $changes->activity = 'Added new count';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Eggs';
              $act->activity = 'Added a new batch of eggs from Batch ' . $request->batch_id;
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();


              return response()->json($inv);
            }
        }
    }

    public function updateEggs(Request $request)
    {

      $validator = Validator::make(Input::all(), $this->eggrules1, ['required_without_all' => 'Input atleast one field! ']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $inv = Eggs::orderBy('id', 'desc')->first();
            $checkjumbo = $inv->total_jumbo - $request->jumbo;
            $checkxlarge = $inv->total_xlarge - $request->xlarge;
            $checklarge = $inv->total_large - $request->large;
            $checkmedium = $inv->total_medium - $request->medium;
            $checksmall = $inv->total_small - $request->small;
            $checkpeewee = $inv->total_peewee - $request->peewee;
            $checksoftshell = $inv->total_softshell - $request->softshell;            

           if ($checkjumbo < 0 || $checkxlarge < 0 || $checklarge < 0 || $checkmedium < 0 || $checksmall < 0 || $checkpeewee < 0 || $checksoftshell < 0)
            {
              return response()->json(array('error' => 'Check your count!'));
            }

            else
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();
                $add->email = Auth::user()->email;
                $add->action = 'Quantity Update';
                $add->module = 'Inventory - Eggs';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->jumbo = $request->jumbo;
                $add->xlarge = $request->xlarge;
                $add->large = $request->large;
                $add->medium = $request->medium;
                $add->small = $request->small;
                $add->peewee = $request->peewee;
                $add->softshell = $request->softshell;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $inv->total_jumbo -= $request->jumbo;
                $inv->total_xlarge -= $request->xlarge;
                $inv->total_large -= $request->large;
                $inv->total_medium -= $request->medium;
                $inv->total_small -= $request->small;
                $inv->total_peewee -= $request->peewee;
                $inv->total_softshell -= $request->softshell;


                $inv->update();

                if ($request->remarks == 'Broken.')
                {
                  $gettotal = BrokenEggs::orderBy('id', 'desc')->first();

                  $broken = new BrokenEggs();

                  $broken->quantity = $request->jumbo + $request->xlarge + $request->large + $request->medium + $request->small + $request->peewee + $request->softshell;
                  
                  if (empty($gettotal))
                    $broken->total = $request->jumbo + $request->xlarge + $request->large + $request->medium + $request->small + $request->peewee + $request->softshell;
                  else
                    $broken->total = $gettotal->total + $request->jumbo + $request->xlarge + $request->large + $request->medium + $request->small + $request->peewee + $request->softshell;

                  $broken->remarks = 'From Accident';
                  $broken->added_by = Auth::user()->email;

                  $broken->save();
                }


                $changes = new InventoryChanges;

                $changes->name = 'Egg Batch ' . $request->batch_id;
                $changes->type = 'Eggs';
                $changes->activity = 'Deducted eggs';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Eggs';
                $act->activity = 'Deducted eggs from total count';
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();


                return response()->json($inv);
              }
          }
        }
    }

    public function editEggs(Request $request)
    {

      $validator = Validator::make(Input::all(), $this->eggrules1, ['required_without_all' => 'Input atleast one field! ']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if (Auth::user()->access == 'Farm Hand')
            {
              $add = new Approvals();

              $add->email = Auth::user()->email;
              $add->action = 'Edit Entry';
              $add->module = 'Inventory - Eggs';
              $add->remarks = $request->remarks;
              $add->status = 'Pending';

              $add->jumbo = $request->jumbo;
              $add->xlarge = $request->xlarge;
              $add->large = $request->large;
              $add->medium = $request->medium;
              $add->small = $request->small;
              $add->peewee = $request->peewee;
              $add->softshell = $request->softshell;
              $add->old_id = $request->batch_id;

              $inv = Eggs::where('batch_id', '=', $request->batch_id)->first();

              $add->request_id = substr_replace($inv->batch_id, $request->id, -1);

              $add->save();

              $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

              return response()->json($add);
            }

            else
            {
              $inv = Eggs::where('batch_id', '=', $request->batch_id)->first();

              // update total eggs from latest entry
              $check = Eggs::orderBy('id', 'desc')->first();

              if ($inv->jumbo != $request->jumbo)
              {
                if ($inv->jumbo > $request->jumbo)
                  $check->total_jumbo -= ($inv->jumbo - $request->jumbo);

                else
                  $check->total_jumbo += ($request->jumbo - $inv->jumbo);
              }

              if ($inv->xlarge != $request->xlarge)
              {
                if ($inv->xlarge > $request->xlarge)
                  $check->total_xlarge -= ($inv->xlarge - $request->xlarge);

                else
                  $check->total_xlarge += ($request->xlarge - $inv->xlarge);
              }

              if ($inv->large != $request->large)
              {
                if ($inv->large > $request->large)
                  $check->total_large -= ($inv->large - $request->large);

                else
                  $check->total_large += ($request->large - $inv->large);
              }

              if ($inv->medium != $request->medium)
              {
                if ($inv->medium > $request->medium)
                  $check->total_medium -= ($inv->medium - $request->medium);

                else
                  $check->total_medium += ($request->medium - $inv->medium);
              }

              if ($inv->small != $request->small)
              {
                if ($inv->small > $request->small)
                  $check->total_small -= ($inv->small - $request->small);

                else
                  $check->total_small += ($request->small - $inv->small);
              }

              if ($inv->peewee != $request->peewee)
              {
                if ($inv->peewee > $request->peewee)
                  $check->total_peewee -= ($inv->peewee - $request->peewee);

                else
                  $check->total_peewee += ($request->peewee - $inv->peewee);
              }

              if ($inv->softshell != $request->softshell)
              {
                if ($inv->softshell > $request->softshell)
                  $check->total_softshell -= ($inv->softshell - $request->softshell);

                else
                  $check->total_softshell += ($request->softshell - $inv->softshell);
              }     

              $check->update();

              // replace batch id
              $inv->batch_id = substr_replace($inv->batch_id, $request->id, -1);

              $inv->jumbo = $request->jumbo;
              $inv->xlarge = $request->xlarge;
              $inv->large = $request->large;
              $inv->medium = $request->medium;
              $inv->small = $request->small;
              $inv->peewee = $request->peewee;
              $inv->softshell = $request->softshell;

              $inv->update();

              $changes = new InventoryChanges;

              $changes->name = 'Egg Batch ' . $request->batch_id;
              $changes->type = 'Eggs';
              $changes->activity = 'Edited eggs entry';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Eggs';
              $act->activity = 'Edited eggs entry';
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();


              return response()->json($inv);
            }

          }
    }

    public function editOther(Request $request)
    {

      $validator = Validator::make(Input::all(), ['quantity' => 'integer']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if ($request->type == 'reject')
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Edit Reject';
                $add->module = 'Inventory - Eggs';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->old_id = $request->batch_id;

                $inv = Eggs::where('batch_id', '=', $request->batch_id)->first();

                $add->request_id = substr_replace($inv->batch_id, $request->id, -1);

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $inv = RejectEggs::where('batch_id', '=', $request->batch_id)->first();

                // update total eggs from latest entry
                $check = RejectEggs::orderBy('id', 'desc')->first();

                if ($inv->quantity != $request->quantity)
                {
                  if ($inv->quantity > $request->quantity)
                    $check->total -= ($inv->quantity - $request->quantity);

                  else
                    $check->total += ($request->quantity - $inv->quantity);
                }

                $check->update();

                // replace batch id
                $inv->batch_id = substr_replace($inv->batch_id, $request->id, -1);

                $inv->quantity = $request->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Reject Batch ' . $inv->batch_id;
                $changes->type = 'Eggs';
                $changes->activity = 'Edited eggs entry';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Eggs';
                $act->activity = 'Edited eggs entry';
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                return response()->json($inv);
              }
            }

            if ($request->type == 'broken')
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Edit Broken';
                $add->module = 'Inventory - Eggs';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->request_id = $request->id;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $inv = BrokenEggs::find($request->id);

                // update total eggs from latest entry
                $check = BrokenEggs::orderBy('id', 'desc')->first();

                if ($inv->quantity != $request->quantity)
                {
                  if ($inv->quantity > $request->quantity)
                    $check->total -= ($inv->quantity - $request->quantity);

                  else
                    $check->total += ($request->quantity - $inv->quantity);
                }

                $check->update();

                $inv->quantity = $request->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Broken Batch ' . $request->id;
                $changes->type = 'Eggs';
                $changes->activity = 'Edited eggs entry';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Eggs';
                $act->activity = 'Edited eggs entry';
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                return response()->json($inv);
              }
            }

          }
    }

    // Chikiiiin

    public function showChickens()
    {
      $total = TotalChickens::all();
      $inv = Chickens::all();
      $dead = DeadChickens::all();
      $cull = Cull::all();
      $changes = InventoryChanges::where('type', '=', 'Chickens')->get();

      return view('admin.invchickens', ['inv' => $inv, 'dead' => $dead, 'cull' => $cull, 'changes' => $changes, 'total' => $total, 'user' => Auth::user()]);
    }

    public function addChickens(Request $request)
    {
      $cull = Carbon::now();
      $cull->addDays(548);

      $validator = Validator::make(Input::all(), ['batch_id' => 'required|min:1', 'quantity' => 'required|integer|min:1', 'remarks' => 'required|string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if ($request->batch_id == 'New Batch')
            {
              $last = TotalChickens::orderBy('id', 'desc')->first();
              $request->batch_id = $last->id + 1;
            }

            if (Auth::user()->access == 'Farm Hand')
            {
              $add = new Approvals();

              $add->email = Auth::user()->email;
              $add->action = 'Add New';
              $add->module = 'Inventory - Chickens';
              $add->remarks = $request->remarks;
              $add->status = 'Pending';
              $add->quantity = $request->quantity;
              $add->old_id = $request->batch_id;
              $add->request_id = Carbon::now()->format('YmdA') . '-' . $request->batch_id;

              $add->save();

              $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

              return response()->json($add);
            }

            else
            {
              $inv = new Chickens();

              $inv->batch = $request->batch_id;
              $inv->batch_id = Carbon::now()->format('YmdA') . '-' . $request->batch_id;
              $inv->quantity = $request->quantity;
              $inv->added_by = Auth::user()->email;
              $inv->to_cull = $cull->toDateString();
              $inv->remarks = $request->remarks;
              $inv->created_at = Carbon::now();

              $inv->save();

              $total = TotalChickens::find($request->batch_id);

              if (empty($total))
              {
                $last = TotalChickens::orderBy('id', 'desc')->first();
                $create = new TotalChickens();

                $create->batch = $request->batch_id;
                $create->quantity = $request->quantity;
                $create->total = $last->total + $request->quantity;
                $create->updated_by = Auth::user()->email;

                $create->save();
              }

              else
              {
                $total->batch = $request->batch_id;
                $total->quantity += $request->quantity;
                $total->total += $request->quantity;
                $total->updated_by = Auth::user()->email;

                $total->update();
              }

              $changes = new InventoryChanges;

              $changes->name = 'Chicken Batch ' . $request->batch_id;
              $changes->type = 'Chickens';
              $changes->activity = 'Added new batch of chickens';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Chickens';
              $act->activity = 'Added a new batch of chickens';
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();


              return response()->json($inv);
            }
        }
    }

    public function updateChickens(Request $request)
    {

      $validator = Validator::make(Input::all(), ['batch_id' => 'required|integer|min:1', 'quantity' => 'required|integer|min:1', 'remarks' => 'string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $total = TotalChickens::find($request->batch_id);
            $check = $total->quantity - $request->quantity;

            if ($check < 0)
            {
              return response()->json(array('error' => 'Check your count!'));
            }

            else
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Quantity Update';
                $add->module = 'Inventory - Chickens';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->request_id = $request->batch_id;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $total->quantity -= $request->quantity;
                $total->total -= $request->quantity;
                $total->updated_by = Auth::user()->email;

                $total->update();

                if ($request->remarks == 'Early Cull')
                {
                  $culltotal = Cull::orderBy('id', 'desc')->first();
                  $cull = new Cull();

                  $cull->batch_id = $request->batch_id;
                  $cull->quantity = $request->quantity;
                  $cull->total = $culltotal->total + $request->quantity;
                  $cull->remarks = $request->remarks;
                  $cull->added_by = Auth::user()->email;

                  $cull->save();

                  $prods = Products::where('name', '=', 'Cull')->first();

                  $prods->stocks = $culltotal->total;
                  $prods->update();
                }

                else
                {
                  $deadtotal = DeadChickens::orderBy('id', 'desc')->first();
                  $dead = new DeadChickens;

                  $dead->batch_id = $request->batch_id;
                  $dead->quantity = $request->quantity;
                  $dead->total = $deadtotal->total + $request->quantity;
                  $dead->remarks = $request->remarks;
                  $dead->added_by = Auth::user()->email;

                  $dead->save();
                }

                $changes = new InventoryChanges;

                $changes->name = 'Chicken Batch ' . $request->batch_id;
                $changes->type = 'Chickens';
                $changes->activity = '-' . $request->quantity . ' chickens from Batch ' . $request->batch_id;
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Chickens';
                $act->activity = 'Updated chickens from Batch ' . $request->batch_id;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();


                return response()->json($total);
              }
          }
        }
    }

    public function editChickens(Request $request)
    {

      $validator = Validator::make(Input::all(), ['quantity' => 'integer']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if ($request->type == 'chickens')
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Edit Entry';
                $add->module = 'Inventory - Chickens';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->old_id = $request->batch_id;
                $add->request_id = $request->id;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $inv = Chickens::where('batch_id', '=', $request->batch_id)->first();

                // update total chickens from batch id
                $check = TotalChickens::where('batch', '=', $request->id)->first();

                if ($request->batch_id != substr_replace($inv->batch_id, $request->id, -1))
                {
                  $check = TotalChickens::where('batch', '=', substr($request->batch_id, -1))->first();

                  $check->quantity -= $request->quantity;

                  $check->update();

                  $check = TotalChickens::where('batch', '=', $request->id)->first();

                  $check->quantity += $request->quantity;

                  $check->update();
                }

                if ($inv->quantity != $request->quantity)
                {
                  $check = TotalChickens::where('batch', '=', $request->id)->first();

                  if ($inv->quantity > $request->quantity)
                  {
                    $check->total -= ($inv->quantity - $request->quantity);
                    $check->quantity -= ($inv->quantity - $request->quantity);
                  }

                  else
                  {
                    $check->total -= ($inv->quantity - $request->quantity);
                    $check->quantity += ($request->quantity - $inv->quantity);
                  }

                  $check->update();

                  $check = TotalChickens::orderBy('id', 'desc')->first();

                  if ($inv->quantity > $request->quantity)
                    $check->total -= ($inv->quantity - $request->quantity);

                  else
                    $check->total += ($request->quantity - $inv->quantity);

                  $check->update();
                }

                // replace batch id
                $inv->batch_id = substr_replace($inv->batch_id, $request->id, -1);

                $inv->quantity = $request->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Chickens Batch ' . $inv->batch_id;
                $changes->type = 'Chickens';
                $changes->activity = 'Edited chickens entry';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Chickens';
                $act->activity = 'Edited chickens entry';
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                return response()->json($inv);
              }
            }

            if ($request->type == 'dead')
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Edit Entry';
                $add->module = 'Inventory - Chickens (Dead)';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->request_id = $request->id;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $inv = DeadChickens::find($request->id);

                // update total chickens from latest entry
                $check = DeadChickens::orderBy('id', 'desc')->first();

                if ($inv->quantity != $request->quantity)
                {
                  if ($inv->quantity > $request->quantity)
                    $check->total -= ($inv->quantity - $request->quantity);

                  else
                    $check->total += ($request->quantity - $inv->quantity);
                }

                $check->update();

                $inv->batch_id = $request->id;
                $inv->quantity = $request->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Dead Chickens Batch ' . $request->id;
                $changes->type = 'Chickens';
                $changes->activity = 'Edited dead chickens entry';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Chickens';
                $act->activity = 'Edited dead chickens entry';
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                return response()->json($inv);
              }
            }

            if ($request->type == 'cull')
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Edit Entry';
                $add->module = 'Inventory - Chickens (Cull)';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->request_id = $request->id;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $inv = Cull::find($request->id);

                // update total chickens from latest entry
                $check = Cull::orderBy('id', 'desc')->first();

                if ($inv->quantity != $request->quantity)
                {
                  if ($inv->quantity > $request->quantity)
                    $check->total -= ($inv->quantity - $request->quantity);

                  else
                    $check->total += ($request->quantity - $inv->quantity);
                }

                $check->update();

                $inv->batch_id = $request->id;
                $inv->quantity = $request->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Cull Batch ' . $request->id;
                $changes->type = 'Chickens';
                $changes->activity = 'Edited cull entry';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Chickens';
                $act->activity = 'Edited cull entry';
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                $prods = Products::where('name', '=', 'Cull')->first();
                $prods->stocks = $check->total;
                $prods->update();


                return response()->json($inv);
              }
            }

          }
    }

    // Pullets

    public function showPullets()
    {
      $inv = Pullets::all();
      $dead = DeadPullets::all();
      $total = TotalPullets::all();
      $changes = InventoryChanges::where('type', '=', 'Pullets')->get();

      return view('admin.invpullets', ['inv' => $inv, 'dead' => $dead, 'changes' => $changes, 'total' => $total, 'user' => Auth::user()]);
    }

    public function addPullets(Request $request)
    {
      $mature = Carbon::now();
      $mature->addDays(182);

      $validator = Validator::make(Input::all(), ['batch_id' => 'required|min:1', 'quantity' => 'required|integer|min:1', 'remarks' => 'required|string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if ($request->batch_id == 'New Batch')
            {
              $last = TotalPullets::orderBy('id', 'desc')->first();
              $request->batch_id = $last->id + 1;
            }

            if (Auth::user()->access == 'Farm Hand')
            {
              $add = new Approvals();

              $add->email = Auth::user()->email;
              $add->action = 'Add New';
              $add->module = 'Inventory - Pullets';
              $add->remarks = $request->remarks;
              $add->status = 'Pending';
              $add->quantity = $request->quantity;
              $add->old_id = $request->batch_id;
              $add->request_id = Carbon::now()->format('YmdA') . '-' . $request->batch_id;

              $add->save();

              $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

              return response()->json($add);
            }

            else
            {
              $inv = new Pullets();

              $inv->batch = $request->batch_id;
              $inv->batch_id = Carbon::now()->format('YmdA') . '-' . $request->batch_id;
              $inv->quantity = $request->quantity;
              $inv->added_by = Auth::user()->email;
              $inv->maturity = $mature->toDateString();
              $inv->remarks = $request->remarks;
              $inv->date_added = Carbon::now()->toDateString();

              $inv->save();

              $total = TotalPullets::find($request->batch_id);

              if (empty($total))
              {
                $total = new TotalPullets();

                $total->batch = $request->batch_id;
                $total->quantity = $request->quantity;
                $total->total += $request->quantity;
                $total->updated_by = Auth::user()->email;

                $total->save();
              }

              else
              {
                $total->batch = $request->batch_id;
                $total->quantity += $request->quantity;
                $total->total += $request->quantity;
                $total->updated_by = Auth::user()->email;

                $total->update();
              }

              $changes = new InventoryChanges;

              $changes->name = 'Pullet Batch ' . $request->batch_id;
              $changes->type = 'Pullets';
              $changes->activity = 'Added new batch of pullets';
              $changes->remarks = $request->remarks;
              $changes->user = Auth::user()->email;
              $changes->changed_at = Carbon::now();

              $changes->save();

              $act = new Activity();

              $act->user_id = Auth::user()->id;
              $act->email = Auth::user()->email;
              $act->module = 'Inventory - Pullets';
              $act->activity = 'Added a new batch of pullets';
              $act->ref_id = $changes->id;
              $act->date_time = Carbon::now();

              $act->save();


              return response()->json($inv);
            }
        }
    }

    public function updatePullets(Request $request)
    {

      $validator = Validator::make(Input::all(), ['batch_id' => 'required|integer|min:1', 'quantity' => 'required|integer|min:1', 'remarks' => 'string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $total = TotalPullets::find($request->batch_id);
            $check = $total->quantity - $request->quantity;

            if ($check < 0)
            {
              return response()->json(array('error' => 'Check your count!'));
            }

            else
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Quantity Update';
                $add->module = 'Inventory - Pullets';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->request_id = $request->batch_id;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                if ($request->remarks == 'For Transfer')
                {
                  $current = TotalChickens::orderBy('id', 'desc')->first();
                  
                  $transfer = new Chickens();

                  $transfer->batch = $current->batch + 1;
                  $transfer->batch_id = Carbon::now()->format('YmdA') . '-' . $current->batch;
                  $transfer->quantity = $request->quantity;
                  $transfer->to_cull = Carbon::now()->addDays(548);
                  $transfer->added_by = Auth::user()->email;
                  $transfer->remarks = "Reached Maturity; New Batch";

                  $transfer->save();

                  $get = Chickens::orderBy('id', 'desc')->first();

                  $new = new TotalChickens();

                  $new->batch = $get->batch;
                  $new->quantity = $request->quantity;
                  $new->total = $current->total + $request->quantity;
                  $new->updated_by = Auth::user()->email;

                  $new->save();

                  $changes = new InventoryChanges;

                  $changes->name = 'Pullet Batch ' . $request->batch_id;
                  $changes->type = 'Pullets';
                  $changes->activity = '-' . $request->quantity . ' pullets from Batch ' . $request->batch_id;
                  $changes->remarks = $request->remarks . ' - New Chicken batch';
                  $changes->user = Auth::user()->email;
                  $changes->changed_at = Carbon::now();

                  $changes->save();

                }

                else
                {
                  $deadtotal = DeadPullets::orderBy('id', 'desc')->first();
                  $dead = new DeadPullets;

                  $dead->batch_id = $request->batch_id;
                  $dead->quantity = $request->quantity;
                  $dead->total = $deadtotal->total + $request->quantity;
                  $dead->remarks = $request->remarks;
                  $dead->added_by = Auth::user()->email;

                  $dead->save();
                }

                $total->quantity -= $request->quantity;
                $total->total -= $request->quantity;
                $total->updated_by = Auth::user()->email;

                $total->update();

                $changes = new InventoryChanges;

                $changes->name = 'Pullet Batch ' . $request->batch_id;
                $changes->type = 'Pullets';
                $changes->activity = '-' . $request->quantity . ' pullets from Batch ' . $request->batch_id;
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Pullets';
                $act->activity = 'Updated pullets from Batch ' . $request->batch_id;
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();


                return response()->json($total);
              }
          }
      }
    }

    public function editPullets(Request $request)
    {

      $validator = Validator::make(Input::all(), ['quantity' => 'integer']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if ($request->type == 'pullets')
            {

              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Edit Entry';
                $add->module = 'Inventory - Pullets';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->old_id = $request->batch_id;
                $add->request_id = $request->id;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $inv = Pullets::where('batch_id', '=', $request->batch_id)->first();

                // update total pullets from batch id
                $check = TotalPullets::where('batch', '=', $request->id)->first();

                if ($request->batch_id != substr_replace($inv->batch_id, $request->id, -1))
                {
                  $check = TotalPullets::where('batch', '=', substr($request->batch_id, -1))->first();

                  $check->quantity -= $request->quantity;

                  $check->update();

                  $check = TotalPullets::where('batch', '=', $request->id)->first();

                  $check->quantity += $request->quantity;

                  $check->update();
                }

                if ($inv->quantity != $request->quantity)
                {
                  $check = TotalPullets::where('batch', '=', $request->id)->first();

                  if ($inv->quantity > $request->quantity)
                  {
                    $check->total -= ($inv->quantity - $request->quantity);
                    $check->quantity -= ($inv->quantity - $request->quantity);
                  }

                  else
                  {
                    $check->total -= ($inv->quantity - $request->quantity);
                    $check->quantity += ($request->quantity - $inv->quantity);
                  }

                  $check->update();

                  $check = TotalPullets::orderBy('id', 'desc')->first();

                  if ($inv->quantity > $request->quantity)
                    $check->total -= ($inv->quantity - $request->quantity);

                  else
                    $check->total += ($request->quantity - $inv->quantity);

                  $check->update();
                }

                // replace batch id
                $inv->batch_id = substr_replace($inv->batch_id, $request->id, -1);

                $inv->quantity = $request->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Pullets Batch ' . $inv->batch_id;
                $changes->type = 'Pullets';
                $changes->activity = 'Edited pullets entry';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Pullets';
                $act->activity = 'Edited pullets entry';
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                return response()->json($inv);
              }
            }

            if ($request->type == 'dead')
            {
              if (Auth::user()->access == 'Farm Hand')
              {
                $add = new Approvals();

                $add->email = Auth::user()->email;
                $add->action = 'Edit Entry';
                $add->module = 'Inventory - Pullets (Dead)';
                $add->remarks = $request->remarks;
                $add->status = 'Pending';
                $add->quantity = $request->quantity;
                $add->request_id = $request->id;

                $add->save();

                $add = Approvals::orderBy('id', 'desc')->first();

                $manager = User::where('access', '=', "Manager")->get();
                $admin = User::where('access', '=', "SysAdmin")->get();

                foreach ($manager as $x)
                  $x->notify(new ActionApprovals($add));

                foreach ($admin as $y)
                  $y->notify(new ActionApprovals($add));

                return response()->json($add);
              }

              else
              {
                $inv = DeadPullets::find($request->id);

                // update total pullets from latest entry
                $check = DeadPullets::orderBy('id', 'desc')->first();

                if ($inv->quantity != $request->quantity)
                {
                  if ($inv->quantity > $request->quantity)
                    $check->total -= ($inv->quantity - $request->quantity);

                  else
                    $check->total += ($request->quantity - $inv->quantity);
                }

                $check->update();

                $inv->batch_id = $request->id;
                $inv->quantity = $request->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Dead Pullets Batch ' . $request->id;
                $changes->type = 'Pullets';
                $changes->activity = 'Edited dead pullets entry';
                $changes->remarks = $request->remarks;
                $changes->user = Auth::user()->email;
                $changes->changed_at = Carbon::now();

                $changes->save();

                $act = new Activity();

                $act->user_id = Auth::user()->id;
                $act->email = Auth::user()->email;
                $act->module = 'Inventory - Pullets';
                $act->activity = 'Edited dead pullets entry';
                $act->ref_id = $changes->id;
                $act->date_time = Carbon::now();

                $act->save();

                return response()->json($inv);
              }
            }
        }
    }
}
