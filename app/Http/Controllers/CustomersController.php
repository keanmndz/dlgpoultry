<?php

namespace DLG\Http\Controllers;

use DLG\Notifications\ActionApprovals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DLG\Mail\SendPassword;
use DLG\User;
use DLG\Customers;
use DLG\CustomerArchives;
use DLG\CustomerChanges;
use DLG\Products;
use DLG\Approvals;
use DLG\Activity;
use Carbon\Carbon;
use Mail;
use Alert;
use PDF;
use Redirect;

class CustomersController extends Controller
{

    // Authenticate

    public function __construct()
    {
        $this->middleware('admin');
    }

    // Show

    public function ViewCustomers()
    {
        $today = Carbon::now();
        $lastWk = Carbon::now()->subWeek();
    	$customers = Customers::all();
        $newcust = Customers::whereBetween('created_at', [$lastWk->toDateTimeString(), $today->toDateTimeString()])->orderBy('created_at', 'desc')->take(5)->get();
        $activity = CustomerChanges::all();

    	return view ('admin.customers', ['customers' => $customers, 'user' => Auth::user(), 'newcust' => $newcust, 'activity' => $activity]);
    }

    public function createCustomer()
    {

    	return view('admin.custcreate')->with('user', Auth::user());
    }

    public function addCustomer(request $request)
    {

        $this->validate(request(), [

            'lname' => 'required|regex:/^[\pL\s\-]+$/u',
            'fname' => 'required|regex:/^[\pL\s\-]+$/u',
            'mname' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|min:4|unique:customers',
            'company' => 'required|string',
            'address' => 'required',
            'contact' => 'required|digits:11'

        ]);

        $random = str_random(10);

        if (Auth::user()->access == 'Farm Hand')
        {
            $add = new Approvals();

            $add->email = Auth::user()->email;
            $add->action = 'Add New';
            $add->module = 'Customers';
            $add->remarks = 'New Customer Account';
            $add->status = 'Pending';
            $add->lname = $request->input('lname');
            $add->fname = $request->input('fname');
            $add->mname = $request->input('mname');
            $add->cust_email = $request->input('email');
            $add->password = bcrypt($random);
            $add->company = $request->input('company');
            $add->address = $request->input('address');
            $add->contact = $request->input('contact');

            $add->save();

            $add = Approvals::orderBy('id', 'desc')->first();

            $manager = User::where('access', '=', "Manager")->get();
            $admin = User::where('access', '=', "SysAdmin")->get();

            foreach ($manager as $x)
              $x->notify(new ActionApprovals($add));

            foreach ($admin as $y)
              $y->notify(new ActionApprovals($add));

            return redirect('/customers')->with('success', 'Your action is now under approval!');
        }

        else
        {
    		$customers = new Customers();

        	$customers->lname=$request->input('lname');
        	$customers->fname=$request->input('fname');
            $customers->mname=$request->input('mname');
            $customers->email=$request->input('email');
            $customers->password=bcrypt($random);
            $customers->company=$request->input('company');
        	$customers->address=$request->input('address');
        	$customers->contact=$request->input('contact');
            $customers->token=str_random(10);
            $customers->remember_token=str_random(10);

        	$customers->save();

            $data = [
                'fname' => $request->input('fname'),
                'lname' => $request->input('lname'),
                'pass' => $random
            ];

            Mail::to(request('email'))->send(new SendPassword($data));

            $changes = new CustomerChanges;

            $changes->activity = 'Created New Account';
            $changes->cust_email = $request->input('email');
            $changes->remarks = 'New Customer: ' . $request->input('fname') . ' ' . $request->input('lname');
            $changes->user = Auth::user()->email;
            $changes->changed_at = Carbon::now()->toDateTimeString();

            $changes->save();

            $act = new Activity();

            $act->user_id = Auth::user()->id;
            $act->email = Auth::user()->email;
            $act->module = 'Customers';
            $act->activity = 'Created New Account: ' . $request->input('email');
            $act->ref_id = $changes->id;
            $act->date_time = Carbon::now();

            $act->save();

            return redirect('/customers')->with('success', 'New customer created!');
        }
    }

    public function editCustomer($id)
    {
        $customers = DB::select('select * from customers where id = ?', [$id]);
        return view('admin.custedit', ['customers' => $customers, 'user' => Auth::user()]);
    }

    public function updateCustomer(request $request,$id)
    {

        $this->validate(request(), [

            'lname' => 'required|regex:/^[\pL\s\-]+$/u',
            'fname' => 'required|regex:/^[\pL\s\-]+$/u',
            'mname' => 'required|regex:/^[\pL\s\-]+$/u',
            'company' => 'required|string',
            'address' => 'required',
            'contact' => 'required|digits:11'

        ]);

        if (Auth::user()->access == 'Farm Hand')
        {
            $custemail = Customers::find($id);

            $add = new Approvals();

            $add->email = Auth::user()->email;
            $add->action = 'Update Customer';
            $add->module = 'Customers';
            $add->remarks = 'Updated an Account';
            $add->status = 'Pending';
            $add->request_id = $id;
            $add->lname = $request->input('lname');
            $add->fname = $request->input('fname');
            $add->mname = $request->input('mname');
            $add->cust_email = $custemail->email;
            $add->company = $request->input('company');
            $add->address = $request->input('address');
            $add->contact = $request->input('contact');

            $add->save();

            $add = Approvals::orderBy('id', 'desc')->first();

            $manager = User::where('access', '=', "Manager")->get();
            $admin = User::where('access', '=', "SysAdmin")->get();

            foreach ($manager as $x)
              $x->notify(new ActionApprovals($add));

            foreach ($admin as $y)
              $y->notify(new ActionApprovals($add));

            return redirect('/customers')->with('success', 'Your action is now under approval!');
        }

        else
        {
            $lname=$request->input('lname');
            $fname=$request->input('fname');
            $mname=$request->input('mname');
            $company=$request->input('company');
            $address=$request->input('address');
            $contact=$request->input('contact');
            $updateCustomer=DB::update('update customers set lname =?, fname = ?, mname = ?, company = ?, address = ?, contact = ? where id=?',[$lname,$fname,$mname,$company,$address,$contact,$id]);

            $changes = new CustomerChanges;

            $changes->activity = 'Updated Account';
            $changes->cust_email = $request->input('email');
            $changes->remarks = 'Updated Customer: ' . $request->input('fname') . ' ' . $request->input('lname');
            $changes->user = Auth::user()->email;
            $changes->changed_at = Carbon::now()->toDateTimeString();

            $changes->save();

            $act = new Activity();

            $act->user_id = Auth::user()->id;
            $act->email = Auth::user()->email;
            $act->module = 'Customers';
            $act->activity = 'Updated Account: ' . $request->input('email');
            $act->ref_id = $changes->id;
            $act->date_time = Carbon::now();

            $act->save();

            return redirect('/customers')->with('success', 'Customer has been updated!');
        }
    }

    public function delCustomer($id)
    {

        if (Auth::user()->access == 'Farm Hand')
        {
            $add = new Approvals();

            $add->email = Auth::user()->email;
            $add->action = 'Disable Customer';
            $add->module = 'Customers';
            $add->remarks = 'Disable an Account';
            $add->status = 'Pending';
            $add->request_id = $id;

            $add->save();

            return response()->json($add);
        }

        else
        {
            $cust = Customers::find($id);

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
            $archive->disabled_by = Auth::user()->email;
            $archive->status = "Disabled";
            $archive->token = $cust->token;
            $archive->remember_token=str_random(10);

            $archive->save();

            $cust->delete();

            $changes = new CustomerChanges;

            $changes->activity = 'Disabled Account';
            $changes->cust_email = $archive->email;
            $changes->remarks = 'Disabled Account of ' . $archive->fname . ' ' . $archive->lname;
            $changes->user = Auth::user()->email;
            $changes->changed_at = Carbon::now()->toDateTimeString();

            $changes->save();

            $act = new Activity();

            $act->user_id = Auth::user()->id;
            $act->email = Auth::user()->email;
            $act->module = 'Customers';
            $act->activity = 'Disabled Account: ' . $archive->email;;
            $act->ref_id = $changes->id;
            $act->date_time = Carbon::now();

            $act->save();

            return response()->json($cust);
        }

    }

    public function custArchives()
    {
        $arc = CustomerArchives::all();

        return view('admin.custarchives', ['arc' => $arc, 'user' => Auth::user()]);
    }
}