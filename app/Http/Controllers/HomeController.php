<?php

namespace DLG\Http\Controllers;

use Cart;
use Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DLG\Mail\SendPassword;
use DLG\Customers;
use DLG\Orders;
use DLG\order_list;
use DLG\OrderDetails;
use DLG\CustomerArchives;
use DLG\CustomerChanges;
use Carbon\Carbon;
use Alert;
use PDF;
use Mail;
use Redirect;
use DLG\Products;

class HomeController extends Controller
{

    public function index()
    {
    	return view('enduser.user-main')->with('user', Auth::guard('customer')->user());
    }

    // Customer Account
    public function viewAccount()
    {
        $allusers = Customers::all();
        $allorder = Orders::where('cust_email', '=', Auth::guard('customer')->user()->email)->get();

        return view('enduser.account', ['customer' => Auth::guard('customer')->user(), 'allusers' => $allusers, 'orders'=> $allorder]);

    }

    // Edit Account
    public function editAccount($id)
    {
        $customers = Customers::find($id);

        return view('enduser.editaccount', compact('customers'))->with('customer', Auth::guard('customer')->user());
    }

    // Insert Edit
    public function insertEdit($id)
    {
        $this->validate(request(), [
            'fname'         => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'lname'         => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'mname'         => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'contact'       => 'required|digits:11',
            'address'       => 'required|max:255',
            'company'       => 'required|string',
        ]);

        $cust = Customers::find($id);

        $cust->fname = request('fname');
        $cust->lname = request('lname');
        $cust->mname = request('mname');
        $cust->company = request('company');
        $cust->contact = request('contact');
        $cust->address = request('address');

        $cust->update();

        return redirect('/account')->with(['customer' => Auth::guard('customer')->user(), 'success' => 'Successfully edited your details!']);
    }

    public function resetPassword()
    {
        return view('enduser.changepass')->with('customer', Auth::guard('customer')->user());
    }

    public function confirmReset()
    {
        $this->validate(request(), [
            'password' => 'required|confirmed|min:4',
        ]);

        $user = Customers::find(request('userid'));

        $user->password = bcrypt(request('password'));
        $user->token = str_random(10);

        $user->update();

        return redirect('/account')->with('success', 'You have changed your password!');
    }

    // Disable Account

    public function disableView()
    {
        return view('enduser.disable')->with('customer', Auth::guard('customer')->user());
    }

    public function disable()
    {
        $cust = Customers::find(request('userid'));

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
        $archive->disabled_by = Auth::guard('customer')->user()->email;
        $archive->status = "Disabled";
        $archive->token = $cust->token;
        $archive->remember_token=str_random(10);

        $archive->save();

        $cust->delete();

        $changes = new CustomerChanges;

        $changes->activity = 'Disabled Account';
        $changes->cust_email = $archive->email;
        $changes->remarks = 'Disabled Account of ' . $archive->fname . ' ' . $archive->lname;
        $changes->user = Auth::guard('customer')->user()->email;
        $changes->changed_at = Carbon::now()->toDateTimeString();

        $changes->save();

        return redirect('/register')->with('success', 'You have disabled your account!');
    }

    //Register an Account

    public function register()
    {
       
        if (Auth::guard('customer')->check())
            return redirect('account')->with('user', Auth::guard('customer')->user());

        else
            return view('enduser.register');
    }

    public function newCustomer(request $request)
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

        $customers = new Customers();

        $customers->lname=request('lname');
        $customers->fname=request('fname');
        $customers->mname=request('mname');
        $customers->email=request('email');
        $customers->password=bcrypt($random);
        $customers->company=request('company');
        $customers->address=request('address');
        $customers->contact=request('contact');
        $customers->token=str_random(10);
        $customers->remember_token=str_random(10);

        $customers->save();

        $data = [
            'fname' => request('fname'),
            'lname' => request('lname'),
            'pass' => $random
        ];

        Mail::to(request('email'))->send(new SendPassword($data));

        return redirect('/register')->with('success', 'Account created! Your temporary password has been sent to your given email address.');
    }

    //Customer Login

    public function login(HttpRequest $request)
    {

         if(Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password]))
        { 
            $user = Auth::guard('customer')->user();

            return redirect('account')->with('user', $user);
        }

        else
            return redirect('register')->withErrors('Access denied.');
    }

    //Customer Logout

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }

    //Show Cart in Menu

    public function show()
    {
        $prods = Products::where('stocks', '>=', '30')->get();

        if (Request::isMethod('post')) 
        {
        $product_id = Request::get('product_id');
        $qty = Request::get('quantity');
        $product = Products::find($product_id);
        Cart::add(array('id' => $product_id, 'name' => $product->name, 'qty' => $qty, 'price' => $product->wholesale_price, 'stocks' => $product->stocks));
         }

        $cart = Cart::content();

        return view('enduser.menu',['prods' => $prods, 'customer' => Auth::guard('customer')->user()], array('cart' => $cart));
    }

    //Show cart in checkout

     public function cart()
    {
        $cart = Cart::content();

        return view('enduser.checkout',array('cart' => $cart, 'customer' => Auth::guard('customer')->user()));

    }

    //Remove item in cart

    public function remove()
    {
        $prods = Products::all();

        if (Request::get('product_id'))
        {
            $item = Cart::search(function($key, $value) { return $key->id == Request::get('product_id'); })->first();
            Cart::remove($item->rowId);
        }

        $cart = Cart::content();

        return view('enduser.menu', ['prods' => $prods, 'customer' => Auth::guard('customer')->user()], array('cart' => $cart));

    }

    //Show Guest information 

    public function checkDetails(HttpRequest $request)
    {
       $lname = $request->lname;
       $fname = $request->fname;
       $mname = $request->mname;
       $company = $request->company;
       $address = $request->address;
       $contact = $request->contactnum;
       $email = $request->email;

       $cart = Cart::content();


        return view('enduser.confirm', array('cart'=>$cart))->with('lname', $lname)->with('fname',$fname)->with('mname', $mname)->with('company', $company)->with('address', $address)->with('contact', $contact)->with('email', $email)->with('customer', Auth::guard('customer')->user());
    }

    public function Reserve(HttpRequest $request)
    {
        $gettotal = Cart::content();

        foreach ($gettotal as $item)
        {
            $total = $item->subtotal;
        }

        $cust = customers::where('email', '=', $request->email)->first();

        $getid = Orders::count();

        if ($getid == null || $getid == '' || $getid == '0')
            $getid = '1';
        else
            $getid++;
    
        $orderid = Carbon::now()->format('Ymd') . '-' . $getid;

        if (empty($cust))
        {
            $trans = new Orders();

            $trans->order_id = $orderid;
            $trans->total_cost = $total;
            $trans->cust_email = $request->email;
            $trans->user_id = 'Guest';
            $trans->handled_by = 'Web';
            $trans->order_placed = 'Online';
            $trans->status = 'Reserved';
            $trans->trans_date = Carbon::now();
        }

        else
        {
            $trans = new Orders();

            $trans->order_id = $orderid;
            $trans->total_cost = $total;
            $trans->cust_email = $cust->email;
            $trans->user_id = $cust->id;
            $trans->handled_by = 'Web';
            $trans->order_placed = 'Online';
            $trans->status = 'Reserved';
            $trans->trans_date = Carbon::now();
        }

        $trans->save();

        $order = Cart::content();

        foreach ($order as $item)
        {
            $confirm = new OrderDetails();

            $confirm->order_id = $orderid;
            $confirm->product_name = $item->name;
            $confirm->quantity = $item->qty;
            $confirm->unit_price = $item->price;

            $confirm->save();
        }

        $order = Orders::orderBy('id', 'desc')->first();

        Cart::destroy();

        if (!Auth::check())
            return redirect('/register')->with('success', 'Successfully reserved your order!');
        else
            return redirect('/account')->with('success', 'Successfully reserved your order!');

    }

    public function cancelReservation($id)
    {
        $order = Orders::find($id);

        $order->status = 'Cancelled by User';

        $order->update();

        return redirect('/account')->with('success', 'Your order has been cancelled!');
    }
}
