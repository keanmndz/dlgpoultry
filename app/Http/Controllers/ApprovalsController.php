<?php

namespace DLG\Http\Controllers;

use DLG\Notifications\ActionApprovals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DLG\Mail\SendPassword;
use DLG\Eggs;
use DLG\Feeds;
use DLG\User;
use DLG\Sales;
use DLG\Supplies;
use DLG\Products;
use DLG\Medicines;
use DLG\Equipment;
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
use DLG\Customers;
use DLG\CustomerArchives;
use DLG\CustomerChanges;
use Carbon\Carbon;
use Mail;

class ApprovalsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('admin');
    }

    public function approve($id)
    {
    	$action = Approvals::find($id);

    	if ($action->action == 'Add New')
    	{
    		if ($action->module == 'Inventory - Feeds')
    		{
				$inv = new Feeds();

				$inv->name = $action->item_name;
				$inv->price = $action->price;
				$inv->quantity = $action->quantity;
				$inv->unit = $action->unit;
				$inv->reorder_level = $action->reorder_level;
				$inv->added_by = $action->email;

				$inv->save();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Feeds';
				$changes->activity = 'Added new feed';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();

    		}

    		if ($action->module == 'Inventory - Medicines')
    		{
				$inv = new Medicines();

				$inv->name = $action->item_name;
				$inv->price = $action->price;
				$inv->quantity = $action->quantity;
				$inv->unit = $action->unit;
				$inv->reorder_level = $action->reorder_level;
				$inv->expiry = Carbon::now()->addYears(3)->toDateString();
				$inv->added_by = $action->email;

				$inv->save();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Medicines';
				$changes->activity = 'Added a new medicine';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();

    		}

    		if ($action->module == 'Inventory - Supplies')
    		{
				$inv = new Supplies();

				$inv->name = $action->item_name;
				$inv->price = $action->price;
				$inv->quantity = $action->quantity;
				$inv->reorder_level = $action->reorder_level;
				$inv->added_by = Auth::user()->email;

				$inv->save();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Supplies';
				$changes->activity = 'Added new supply item';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Equipment')
    		{
				$inv = new Equipment();

				$inv->name = $action->item_name;
				$inv->price = $action->price;
				$inv->quantity = $action->quantity;
				$inv->reorder_level = $action->reorder_level;
				$inv->added_by = Auth::user()->email;

				$inv->save();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Equipment';
				$changes->activity = 'Added new Equipment';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Products')
    		{
				$inv = new Products();

				$inv->name = $action->item_name;
				$inv->retail_price = $action->price;
				$inv->wholesale_price = $action->reorder_level;
				$inv->stocks = $action->quantity;
				$inv->added_by = Auth::user()->email;

				$inv->save();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Products';
				$changes->activity = 'Added new product item';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Eggs')
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

    			$inv = new Eggs();

	            $inv->batch_id = $action->request_id;
	                 
	            $inv->jumbo = $action->jumbo;
	            $inv->xlarge = $action->xlarge;
	            $inv->large = $action->large;
	            $inv->medium = $action->medium;
	            $inv->small = $action->small;
	            $inv->peewee = $action->peewee;
				$inv->softshell = $action->softshell;

	            $inv->total_jumbo = $total_jumbo + $action->jumbo;
	            $inv->total_xlarge = $total_xlarge + $action->xlarge;
	            $inv->total_large = $total_large + $action->large;
	            $inv->total_medium = $total_medium + $action->medium;
	            $inv->total_small = $total_small + $action->small;
	            $inv->total_peewee = $total_peewee + $action->peewee;
	            $inv->total_softshell = $total_softshell + $action->softshell;
	            $inv->added_by = $action->email;
	            $inv->lifetime = $life->toDateString();
	            $inv->created_at = Carbon::now()->toDateString();
	            $inv->time_added = Carbon::now()->toTimeString();

	            $inv->save();

	            if ($action->reject != null)
	            {
	              $total = RejectEggs::orderBy('id', 'desc')->first();
	              $reject = new RejectEggs();

	              $reject->batch_id = $action->request_id;
	              $reject->quantity = $action->reject;

	              if (empty($total))
		              $reject->total = $action->reject;
		          else
		          	  $reject->total = $total->total + $action->reject;
	              
	              $reject->remarks = 'Reject from new batch';
	              $reject->added_by = $action->email;

	              $reject->save();
	            }

	            $changes = new InventoryChanges;

	            $changes->name = 'Egg Batch ' . $action->request_id;
	            $changes->type = 'Eggs';
	            $changes->activity = 'Added new count';
	            $changes->remarks = $action->remarks;
	            $changes->user = $action->email;
	            $changes->changed_at = Carbon::now();

	            $changes->save();
    		}

    		if ($action->module == 'Inventory - Chickens')
    		{
    			$cull = Carbon::now();
				$cull->addDays(548);

    			$inv = new Chickens();

				$inv->batch = $action->old_id;
				$inv->batch_id = $action->request_id;
				$inv->quantity = $action->quantity;
				$inv->added_by = $action->email;
				$inv->to_cull = $cull->toDateString();
				$inv->remarks = $action->remarks;
				$inv->created_at = Carbon::now();

				$inv->save();

				$total = TotalChickens::find($action->old_id);

				if (empty($total))
				{
					$last = TotalChickens::orderBy('id', 'desc')->first();
					$create = new TotalChickens();

					$create->batch = $action->old_id;
					$create->quantity = $action->quantity;
					$create->total = $last->total + $action->quantity;
					$create->updated_by = $action->email;

					$create->save();
				}

				else
				{
					$total->batch = $action->old_id;
					$total->quantity += $action->quantity;
					$total->total += $action->quantity;
					$total->updated_by = $action->email;

					$total->update();
				}

				$changes = new InventoryChanges;

				$changes->name = 'Chicken Batch ' . $action->old_id;
				$changes->type = 'Chickens';
				$changes->activity = 'Added new batch of chickens';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Pullets')
    		{
    			$mature = Carbon::now();
			    $mature->addDays(182);
    			
    			$inv = new Pullets();

	            $inv->batch = $action->old_id;
	            $inv->batch_id = $action->request_id;
	            $inv->quantity = $action->quantity;
	            $inv->added_by = $action->email;
	            $inv->maturity = $mature->toDateString();
	            $inv->remarks = $action->remarks;
	            $inv->date_added = Carbon::now()->toDateString();

	            $inv->save();

	            $total = TotalPullets::find($action->old_id);

	            if (empty($total))
	            {
	              $total = new TotalPullets();

	              $total->batch = $action->old_id;
	              $total->quantity = $action->quantity;
	              $total->total += $action->quantity;
	              $total->updated_by = $action->email;

	              $total->save();
	            }

	            else
	            {
	              $total->batch = $action->old_id;
	              $total->quantity += $action->quantity;
	              $total->total += $action->quantity;
	              $total->updated_by = $action->email;

	              $total->update();
	            }

	            $changes = new InventoryChanges;

	            $changes->name = 'Pullet Batch ' . $action->old_id;
	            $changes->type = 'Pullets';
	            $changes->activity = 'Added new batch of pullets';
	            $changes->remarks = $action->remarks;
	            $changes->user = $action->email;
	            $changes->changed_at = Carbon::now();

	            $changes->save();
	    	}

	    	if ($action->module == 'Customers')
	    	{
	    		$random = str_random(10);

	    		$customers = new Customers();

	        	$customers->lname=$action->lname;
	        	$customers->fname=$action->fname;
	            $customers->mname=$action->mname;
	            $customers->email=$action->cust_email;
	            $customers->password=bcrypt($random);
	            $customers->company=$action->company;
	        	$customers->address=$action->address;
	        	$customers->contact=$action->contact;
	        	$customers->token=str_random(10);
	            $customers->remember_token=str_random(10);

	        	$customers->save();

	        	$data = [
	        		'fname' => $action->fname,
	        		'lname' => $action->lname,
	        		'pass' => $random
	        	];

	        	Mail::to($action->cust_email)->send(new SendPassword($data));

	        	$changes = new CustomerChanges;

	        	$changes->activity = 'Created New Account';
	        	$changes->cust_email = $action->cust_email;
	        	$changes->remarks = 'New Customer: ' . $action->fname . ' ' . $action->lname;
	        	$changes->user = $action->email;
	        	$changes->changed_at = Carbon::now()->toDateTimeString();

	        	$changes->save();
	    	}
    	}

    	if ($action->action == 'Add Quantity')
    	{
    		if ($action->module == 'Inventory - Feeds')
    		{
    			$inv = Feeds::find($action->request_id);

		        $sum = $inv->quantity;
		        $add = $action->quantity;

		        $inv->quantity = $sum + $add;
		        $inv->updated_at = Carbon::now();

		        $inv->update();

		        $changes = new InventoryChanges;

	            $changes->name = $action->item_name;
	            $changes->type = 'Feeds';
	            $changes->activity = 'Added quantity';
	            $changes->remarks = $action->remarks;
	            $changes->user = $action->email;
	            $changes->changed_at = Carbon::now();

	            $changes->save();
    		}

    		if ($action->module == 'Inventory - Medicines')
    		{
    			$inv = Medicines::find($action->request_id);

		        $sum = $inv->quantity;
		        $add = $action->quantity;

		        $inv->quantity = $sum + $add;
		        $inv->updated_at = Carbon::now();

		        $inv->update();

		        $changes = new InventoryChanges;

	            $changes->name = $action->item_name;
	            $changes->type = 'Medicines';
	            $changes->activity = 'Added quantity';
	            $changes->remarks = $action->remarks;
	            $changes->user = $action->email;
	            $changes->changed_at = Carbon::now();

	            $changes->save();
    		}

    		if ($action->module == 'Inventory - Supplies')
    		{
    			$inv = Supplies::find($action->request_id);

		        $sum = $inv->quantity;
		        $add = $action->quantity;

		        $inv->quantity = $sum + $add;
		        $inv->updated_at = Carbon::now();

		        $inv->update();

		        $changes = new InventoryChanges;

	            $changes->name = $action->item_name;
	            $changes->type = 'Supplies';
	            $changes->activity = 'Added quantity';
	            $changes->remarks = $action->remarks;
	            $changes->user = $action->email;
	            $changes->changed_at = Carbon::now();

	            $changes->save();
    		}

    		if ($action->module == 'Inventory - Equipment')
    		{
    			$inv = Equipment::find($action->request_id);

		        $sum = $inv->quantity;
		        $add = $action->quantity;

		        $inv->quantity = $sum + $add;
		        $inv->updated_at = Carbon::now();

		        $inv->update();

		        $changes = new InventoryChanges;

	            $changes->name = $action->item_name;
	            $changes->type = 'Equipment';
	            $changes->activity = 'Added quantity';
	            $changes->remarks = $action->remarks;
	            $changes->user = $action->email;
	            $changes->changed_at = Carbon::now();

	            $changes->save();
    		}

    		if ($action->module == 'Inventory - Products')
    		{
    			$inv = Products::find($action->request_id);

		        $sum = $inv->stocks;
		        $add = $action->quantity;

		        $inv->stocks = $sum + $add;
		        $inv->updated_at = Carbon::now();

		        $inv->update();

		        $changes = new InventoryChanges;

	            $changes->name = $action->item_name;
	            $changes->type = 'Products';
	            $changes->activity = 'Added quantity';
	            $changes->remarks = $action->remarks;
	            $changes->user = $action->email;
	            $changes->changed_at = Carbon::now();

	            $changes->save();
    		}
    	}

    	if ($action->action == 'Use Quantity')
    	{
    		if ($action->module == 'Inventory - Feeds')
    		{
    			$inv = Feeds::find($action->request_id);

    			$sum = $inv->quantity;
                $use = $action->quantity;
    
                $inv->quantity = $sum - $use;
                $inv->updated_at = Carbon::now();
    
                $inv->update();

                $changes = new InventoryChanges;
    
                $changes->name = $action->item_name;
                $changes->type = 'Feeds';
                $changes->activity = 'Used quantity';
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();
    
                $changes->save();
    		}

    		if ($action->module == 'Inventory - Medicines')
    		{
    			$inv = Medicines::find($action->request_id);

    			$sum = $inv->quantity;
                $use = $action->quantity;
    
                $inv->quantity = $sum - $use;
                $inv->updated_at = Carbon::now();
    
                $inv->update();

                $changes = new InventoryChanges;
    
                $changes->name = $action->item_name;
                $changes->type = 'Medicines';
                $changes->activity = 'Used quantity';
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();
    
                $changes->save();
    		}

    		if ($action->module == 'Inventory - Supplies')
    		{
    			$inv = Supplies::find($action->request_id);

    			$sum = $inv->quantity;
                $use = $action->quantity;
    
                $inv->quantity = $sum - $use;
                $inv->updated_at = Carbon::now();
    
                $inv->update();

                $changes = new InventoryChanges;
    
                $changes->name = $action->item_name;
                $changes->type = 'Supplies';
                $changes->activity = 'Used quantity';
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();
    
                $changes->save();
    		}

    		if ($action->module == 'Inventory - Equipment')
    		{
    			$inv = Equipment::find($action->request_id);

    			$sum = $inv->quantity;
                $use = $action->quantity;
    
                $inv->quantity = $sum - $use;
                $inv->updated_at = Carbon::now();
    
                $inv->update();

                $changes = new InventoryChanges;
    
                $changes->name = $action->item_name;
                $changes->type = 'Equipment';
                $changes->activity = 'Used quantity';
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();
    
                $changes->save();
    		}

    		if ($action->module == 'Inventory - Products')
    		{
    			$inv = Products::find($action->request_id);

    			$sum = $inv->stocks;
                $use = $action->quantity;
    
                $inv->quantity = $sum - $use;
                $inv->updated_at = Carbon::now();
    
                $inv->update();

                $changes = new InventoryChanges;
    
                $changes->name = $action->item_name;
                $changes->type = 'Products';
                $changes->activity = 'Used quantity';
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();
    
                $changes->save();
    		}
    	}

    	if ($action->action == 'Price Update')
    	{
    		if ($action->module == 'Inventory - Feeds')
    		{
	    		$total = Feeds::find($action->request_id);
				$total->price = $action->price;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Feeds';
				$changes->activity = 'Updated price of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Medicines')
    		{
	    		$total = Medicines::find($action->request_id);
				$total->price = $action->price;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Medicines';
				$changes->activity = 'Updated price of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Supplies')
    		{
	    		$total = Supplies::find($action->request_id);
				$total->price = $action->price;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Supplies';
				$changes->activity = 'Updated price of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Equipment')
    		{
	    		$total = Equipment::find($action->request_id);
				$total->price = $action->price;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Equipment';
				$changes->activity = 'Updated price of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Products')
    		{
	    		$total = Products::find($action->request_id);
				
				if ($action->unit == 'Retail')
                  $total->retail_price = $action->price;

                else
                  $total->wholesale_price = $action->price;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Products';
				$changes->activity = 'Updated price of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}
    	}

    	if ($action->action == 'Reorder Update')
    	{
    		if ($action->module == 'Inventory - Feeds')
    		{
	    		$total = Feeds::find($action->request_id);
				$total->reorder_level = $action->reorder_level;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Feeds';
				$changes->activity = 'Updated reorder level of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Medicines')
    		{
	    		$total = Medicines::find($action->request_id);
				$total->reorder_level = $action->reorder_level;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Medicines';
				$changes->activity = 'Updated reorder level of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Supplies')
    		{
	    		$total = Supplies::find($action->request_id);
				$total->reorder_level = $action->reorder_level;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Supplies';
				$changes->activity = 'Updated reorder level of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}

    		if ($action->module == 'Inventory - Equipment')
    		{
	    		$total = Equipment::find($action->request_id);
				$total->reorder_level = $action->reorder_level;

				$total->update();

				$changes = new InventoryChanges;

				$changes->name = $action->item_name;
				$changes->type = 'Equipment';
				$changes->activity = 'Updated reorder level of ' . $action->item_name;
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
    		}
    	}

    	if ($action->action == 'Quantity Update')
    	{
    		if ($action->module == 'Inventory - Eggs')
    		{
    			$inv = Eggs::orderBy('id', 'desc')->first();

    			$inv->total_jumbo -= $action->jumbo;
                $inv->total_xlarge -= $action->xlarge;
                $inv->total_large -= $action->large;
                $inv->total_medium -= $action->medium;
                $inv->total_small -= $action->small;
                $inv->total_peewee -= $action->peewee;
                $inv->total_softshell -= $action->softshell;


                $inv->update();

                if ($action->remarks == 'Broken.')
                {
                  $total = BrokenEggs::orderBy('id', 'desc')->first();
                  $broken = new BrokenEggs();

                  $broken->quantity = $action->jumbo + $action->xlarge + $action->large + $action->medium + $action->small + $action->peewee + $action->softshell;
                  
                  if (empty($total))
	                  $broken->total = $action->jumbo + $action->xlarge + $action->large + $action->medium + $action->small + $action->peewee + $action->softshell;
	              else
	            	  $broken->total = $total->total + $action->jumbo + $action->xlarge + $action->large + $action->medium + $action->small + $action->peewee + $action->softshell;
                  $broken->remarks = 'From Accident';
                  $broken->added_by = $action->email;

                  $broken->save();
                }


                $changes = new InventoryChanges;

                $changes->name = 'Egg Batch ' . $request->batch_id;
                $changes->type = 'Eggs';
                $changes->activity = 'Deducted eggs';
                $changes->remarks = $request->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();

                $changes->save();
    		}

    		if ($action->module == 'Inventory - Chickens')
    		{
    			$total = TotalChickens::find($action->request_id);

    			$total->quantity -= $action->quantity;
                $total->total -= $action->quantity;
                $total->updated_by = $action->email;

                $total->update();

                if ($action->remarks == 'Early Cull')
                {
                  $culltotal = Cull::orderBy('id', 'desc')->first();
                  $cull = new Cull();

                  $cull->batch_id = $action->request_id;
                  $cull->quantity = $action->quantity;
                  $cull->total = $culltotal->total + $action->quantity;
                  $cull->remarks = $action->remarks;
                  $cull->added_by = $action->email;

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

                $changes->name = 'Chicken Batch ' . $action->request_id;
                $changes->type = 'Chickens';
                $changes->activity = '-' . $action->quantity . ' chickens from Batch ' . $action->request_id;
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();

                $changes->save();
    		}

    		if ($action->module == 'Inventory - Pullets')
    		{
    			if ($action->remarks == 'For Transfer')
                {
                  $current = TotalChickens::orderBy('id', 'desc')->first();
                  
                  $transfer = new Chickens();

                  $transfer->batch = $current->batch + 1;
                  $transfer->batch_id = Carbon::now()->format('YmdA') . '-' . $current->batch;
                  $transfer->quantity = $action->quantity;
                  $transfer->to_cull = Carbon::now()->addDays(548);
                  $transfer->added_by = $action->email;
                  $transfer->remarks = "Reached Maturity; New Batch";

                  $transfer->save();

                  $get = Chickens::orderBy('id', 'desc')->first();

                  $new = new TotalChickens();

                  $new->batch = $get->batch;
                  $new->quantity = $action->quantity;
                  $new->total = $current->total + $action->quantity;
                  $new->updated_by = $action->email;

                  $new->save();

                  $changes = new InventoryChanges;

                  $changes->name = 'Pullet Batch ' . $action->request_id;
                  $changes->type = 'Pullets';
                  $changes->activity = '-' . $action->quantity . ' pullets from Batch ' . $action->request_id;
                  $changes->remarks = $action->remarks . ' - New Chicken batch';
                  $changes->user = $action->email;
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

                $total->quantity -= $action->quantity;
                $total->total -= $action->quantity;
                $total->updated_by = $action->email;

                $total->update();

                $changes = new InventoryChanges;

                $changes->name = 'Pullet Batch ' . $action->request_id;
                $changes->type = 'Pullets';
                $changes->activity = '-' . $request->quantity . ' pullets from Batch ' . $action->request_id;
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();

                $changes->save();
    		}
    	}

    	if ($action->action == 'Edit Entry')
    	{
    		if ($action->module == 'Inventory - Eggs')
    		{	
    			$inv = Eggs::where('batch_id', '=', $action->old_id)->first();

    			// update total eggs from latest entry
				$check = Eggs::orderBy('id', 'desc')->first();

				if ($inv->jumbo != $action->jumbo)
				{
				if ($inv->jumbo > $action->jumbo)
				  $check->total_jumbo -= ($inv->jumbo - $action->jumbo);

				else
				  $check->total_jumbo += ($action->jumbo - $inv->jumbo);
				}

				if ($inv->xlarge != $action->xlarge)
				{
				if ($inv->xlarge > $action->xlarge)
				  $check->total_xlarge -= ($inv->xlarge - $action->xlarge);

				else
				  $check->total_xlarge += ($action->xlarge - $inv->xlarge);
				}

				if ($inv->large != $action->large)
				{
				if ($inv->large > $action->large)
				  $check->total_large -= ($inv->large - $action->large);

				else
				  $check->total_large += ($action->large - $inv->large);
				}

				if ($inv->medium != $action->medium)
				{
				if ($inv->medium > $action->medium)
				  $check->total_medium -= ($inv->medium - $action->medium);

				else
				  $check->total_medium += ($action->medium - $inv->medium);
				}

				if ($inv->small != $action->small)
				{
				if ($inv->small > $action->small)
				  $check->total_small -= ($inv->small - $action->small);

				else
				  $check->total_small += ($action->small - $inv->small);
				}

				if ($inv->peewee != $action->peewee)
				{
				if ($inv->peewee > $action->peewee)
				  $check->total_peewee -= ($inv->peewee - $action->peewee);

				else
				  $check->total_peewee += ($action->peewee - $inv->peewee);
				}

				if ($inv->softshell != $action->softshell)
				{
				if ($inv->softshell > $action->softshell)
				  $check->total_softshell -= ($inv->softshell - $action->softshell);

				else
				  $check->total_softshell += ($action->softshell - $inv->softshell);
				}     

				$check->update();

				// replace batch id
				$inv->batch_id = $action->request_id;

				$inv->jumbo = $action->jumbo;
				$inv->xlarge = $action->xlarge;
				$inv->large = $action->large;
				$inv->medium = $action->medium;
				$inv->small = $action->small;
				$inv->peewee = $action->peewee;
				$inv->softshell = $action->softshell;

				$inv->update();

				$changes = new InventoryChanges;

				$changes->name = 'Egg Batch ' . $action->request_id;
				$changes->type = 'Eggs';
				$changes->activity = 'Edited eggs entry';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
			}

			if ($action->module == 'Inventory - Chickens')
			{
				$inv = Chickens::where('batch_id', '=', $action->old_id)->first();

                // update total chickens from batch id
                $check = TotalChickens::where('batch', '=', $action->request_id)->first();

                if ($action->old_id != substr_replace($inv->batch_id, $action->request_id, -1))
                {
                  $check = TotalChickens::where('batch', '=', substr($action->old_id, -1))->first();

                  $check->quantity -= $action->quantity;

                  $check->update();

                  $check = TotalChickens::where('batch', '=', $action->request_id)->first();

                  $check->quantity += $action->quantity;

                  $check->update();
                }

                if ($inv->quantity != $action->quantity)
                {
                  $check = TotalChickens::where('batch', '=', $action->request_id)->first();

                  if ($inv->quantity > $action->quantity)
                  {
                    $check->total -= ($inv->quantity - $action->quantity);
                    $check->quantity -= ($inv->quantity - $action->quantity);
                  }

                  else
                  {
                    $check->total -= ($inv->quantity - $action->quantity);
                    $check->quantity += ($action->quantity - $inv->quantity);
                  }

                  $check->update();

                  $check = TotalChickens::orderBy('id', 'desc')->first();

                  if ($inv->quantity > $action->quantity)
                    $check->total -= ($inv->quantity - $action->quantity);

                  else
                    $check->total += ($action->quantity - $inv->quantity);

                  $check->update();
                }

                // replace batch id
                $inv->batch_id = substr_replace($inv->batch_id, $action->request_id, -1);

                $inv->quantity = $action->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Chickens Batch ' . $inv->batch_id;
                $changes->type = 'Chickens';
                $changes->activity = 'Edited chickens entry';
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();

                $changes->save();
			}

			if ($action->module == 'Inventory - Chickens (Dead)')
			{
				$inv = DeadChickens::find($action->request_id);

                // update total chickens from latest entry
                $check = DeadChickens::orderBy('id', 'desc')->first();

                if ($inv->quantity != $action->quantity)
                {
                  if ($inv->quantity > $action->quantity)
                    $check->total -= ($inv->quantity - $action->quantity);

                  else
                    $check->total += ($action->quantity - $inv->quantity);
                }

                $check->update();

                $inv->batch_id = $action->request_id;
                $inv->quantity = $action->quantity;

                $inv->update();

                $changes = new InventoryChanges;

                $changes->name = 'Dead Chickens Batch ' . $action->request_id;
                $changes->type = 'Chickens';
                $changes->activity = 'Edited dead chickens entry';
                $changes->remarks = $action->remarks;
                $changes->user = $action->email;
                $changes->changed_at = Carbon::now();

                $changes->save();
			}

			if ($action->module == 'Inventory - Chickens (Cull)')
			{
				$inv = Cull::find($action->request_id);

              // update total chickens from latest entry
              $check = Cull::orderBy('id', 'desc')->first();

              if ($inv->quantity != $action->quantity)
              {
                if ($inv->quantity > $action->quantity)
                  $check->total -= ($inv->quantity - $action->quantity);

                else
                  $check->total += ($action->quantity - $inv->quantity);
              }

              $check->update();

              $inv->batch_id = $action->request_id;
              $inv->quantity = $action->quantity;

              $inv->update();

              $changes = new InventoryChanges;

              $changes->name = 'Cull Batch ' . $action->request_id;
              $changes->type = 'Chickens';
              $changes->activity = 'Edited cull entry';
              $changes->remarks = $action->remarks;
              $changes->user = $action->email;
              $changes->changed_at = Carbon::now();

              $changes->save();
			}

			if ($action->module == 'Inventory - Pullets')
			{
				$inv = Pullets::where('batch_id', '=', $action->old_id)->first();

				// update total pullets from batch id
				$check = TotalPullets::where('batch', '=', $action->request_id)->first();

				if ($action->old_id != substr_replace($inv->batch_id, $action->request_id, -1))
				{
					$check = TotalPullets::where('batch', '=', substr($action->old_id, -1))->first();

					$check->quantity -= $action->quantity;

					$check->update();

					$check = TotalPullets::where('batch', '=', $action->request_id)->first();

					$check->quantity += $action->quantity;

					$check->update();
				}

				if ($inv->quantity != $action->quantity)
				{
					$check = TotalPullets::where('batch', '=', $action->request_id)->first();

					if ($inv->quantity > $action->quantity)
					{
						$check->total -= ($inv->quantity - $action->quantity);
						$check->quantity -= ($inv->quantity - $action->quantity);
					}

					else
					{
						$check->total -= ($inv->quantity - $action->quantity);
						$check->quantity += ($action->quantity - $inv->quantity);
					}

					$check->update();

					$check = TotalPullets::orderBy('id', 'desc')->first();

					if ($inv->quantity > $action->quantity)
						$check->total -= ($inv->quantity - $action->quantity);

					else
						$check->total += ($action->quantity - $inv->quantity);

					$check->update();
				}

				// replace batch id
				$inv->batch_id = substr_replace($inv->batch_id, $action->request_id, -1);

				$inv->quantity = $action->quantity;

				$inv->update();

				$changes = new InventoryChanges;

				$changes->name = 'Pullets Batch ' . $inv->batch_id;
				$changes->type = 'Pullets';
				$changes->activity = 'Edited pullets entry';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
			}

			if ($action->module == 'Inventory - Pullets (Dead)')
			{
				$inv = DeadPullets::find($action->request_id);

				// update total pullets from latest entry
				$check = DeadPullets::orderBy('id', 'desc')->first();

				if ($inv->quantity != $action->quantity)
				{
					if ($inv->quantity > $action->quantity)
					  $check->total -= ($inv->quantity - $action->quantity);

					else
					  $check->total += ($action->quantity - $inv->quantity);
				}

				$check->update();

				$inv->batch_id = $action->request_id;
				$inv->quantity = $action->quantity;

				$inv->update();

				$changes = new InventoryChanges;

				$changes->name = 'Dead Pullets Batch ' . $action->request_id;
				$changes->type = 'Pullets';
				$changes->activity = 'Edited dead pullets entry';
				$changes->remarks = $action->remarks;
				$changes->user = $action->email;
				$changes->changed_at = Carbon::now();

				$changes->save();
			}
    	}

    	if ($action->action == 'Edit Reject')
    	{
    		$inv = RejectEggs::where('batch_id', '=', $action->old_id)->first();

            // update total eggs from latest entry
            $check = RejectEggs::orderBy('id', 'desc')->first();

            if ($inv->quantity != $action->quantity)
            {
              if ($inv->quantity > $action->quantity)
                $check->total -= ($inv->quantity - $action->quantity);

              else
                $check->total += ($action->quantity - $inv->quantity);
            }

            $check->update();

            // replace batch id
            $inv->batch_id = $action->request_id;

            $inv->quantity = $action->quantity;

            $inv->update();

            $changes = new InventoryChanges;

            $changes->name = 'Reject Batch ' . $action->batch_id;
            $changes->type = 'Eggs';
            $changes->activity = 'Edited eggs entry';
            $changes->remarks = $action->remarks;
            $changes->user = $action->email;
            $changes->changed_at = Carbon::now();

            $changes->save();
    	}

    	if ($action->action == 'Edit Broken')
    	{
    		$inv = BrokenEggs::find($action->request_id);

                // update total eggs from latest entry
            $check = BrokenEggs::orderBy('id', 'desc')->first();

            if ($inv->quantity != $action->quantity)
            {
              if ($inv->quantity > $action->quantity)
                $check->total -= ($inv->quantity - $action->quantity);

              else
                $check->total += ($action->quantity - $inv->quantity);
            }

            $check->update();

            $inv->quantity = $action->quantity;

            $inv->update();

            $changes = new InventoryChanges;

            $changes->name = 'Broken Batch ' . $action->request_id;
            $changes->type = 'Eggs';
            $changes->activity = 'Edited eggs entry';
            $changes->remarks = $action->remarks;
            $changes->user = $action->email;
            $changes->changed_at = Carbon::now();

            $changes->save();
    	}

    	if ($action->action == 'Update Customer')
    	{
    		$lname = $action->lname;
            $fname = $action->fname;
            $mname = $action->mname;
            $company = $action->company;
            $address = $action->address;
            $contact = $action->contact;
            $updateCustomer = DB::update('update customers set lname =?, fname = ?, mname = ?, company = ?, address = ?, contact = ? where id=?',[$lname,$fname,$mname,$company,$address,$contact,$action->request_id]);

            $changes = new CustomerChanges;

            $changes->activity = 'Updated Account';
            $changes->cust_email = $action->cust_email;
            $changes->remarks = 'Updated Customer: ' . $action->fname . ' ' . $action->lname;
            $changes->user = $action->email;
            $changes->changed_at = Carbon::now()->toDateTimeString();

            $changes->save();
    	}

    	if ($action->action == 'Disable Customer')
    	{
    		$cust = Customers::find($action->request_id);

            $archive = new CustomerArchives;

            $archive->cust_id = $cust->id;
            $archive->lname = $cust->lname;
            $archive->fname = $cust->fname;
            $archive->mname = $cust->mname;
            $archive->email = $cust->email;
            $archive->password = $cust->lname;
            $archive->company = $cust->company;
            $archive->address = $cust->address;
            $archive->contact = $cust->contact;
            $archive->disabled_by = $action->email;
            $archive->status = "Disabled";
            $archive->remember_token = $cust->remember_token;

            $archive->save();

            $cust->delete();

            $changes = new CustomerChanges;

            $changes->activity = 'Disabled Account';
            $changes->cust_email = $archive->email;
            $changes->remarks = 'Disabled Account of ' . $archive->fname . ' ' . $archive->lname;
            $changes->user = $action->email;
            $changes->changed_at = Carbon::now()->toDateTimeString();

            $changes->save();
    	}

    	$act = new Activity();

		$act->user_id = Auth::user()->id;
		$act->email = Auth::user()->email;
		$act->module = 'Approvals';
		$act->activity = 'Approved an action by ' . $action->email;
		$act->ref_id = $action->id;
		$act->date_time = Carbon::now();

		$act->save();

    	$action->status = 'Approved';

    	$action->update();

    	$user = User::where('email', '=', $action->email)->first();

    	$user->notify(new ActionApprovals($action));

    	return redirect('/admin/details')->with('success', 'You have approved this action.');
    }

    public function disapprove($id)
    {
    	$action = Approvals::find($id);

    	$action->status = 'Disapproved';

    	$action->update();

    	$act = new Activity();

		$act->user_id = Auth::user()->id;
		$act->email = Auth::user()->email;
		$act->module = 'Approvals';
		$act->activity = 'Disapproved an action by ' . $action->email;
		$act->ref_id = $action->id;
		$act->date_time = Carbon::now();

		$act->save();

		$user = User::where('email', '=', $action->email)->first();

    	$user->notify(new ActionApprovals($action));

    	return redirect('/admin/details')->with('success', 'You have disapproved this action.');
    }	
}
