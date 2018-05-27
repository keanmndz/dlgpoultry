<?php

namespace DLG\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use DLG\Sales;
use DLG\User;
use DLG\Orders;
use DLG\Chickens;
use DLG\Customers;
use DLG\Feeds;
use DLG\Medicines;
use DLG\DeadChickens;
use DLG\UsersArchives;
use DLG\Activity;
use DLG\Approvals;
use DLG\UserChanges;
use DLG\InventoryChanges;
use DLG\Vet;
use Validator;
use Response;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    // Logged in User Information

    public function details()
    {
        $allusers = User::all();
        $approvals = Approvals::where('status', '=', 'Pending')->get();
        $history = Approvals::where('status', '!=', 'Pending')->get();
        $vet = Vet::orderBy('id', 'desc')->get();

        return view('admin.admindetails', ['user' => Auth::user(), 'allusers' => $allusers, 'approvals' => $approvals, 'history' => $history, 'vet' => $vet]);
    }

    // Admin New Account Registration

    public function createNew()
    {
        return view('admin.admincreate')->with('user', Auth::user());
    }

    // Edit Own Information

    public function editInfo()
    {
        return view('admin.adminedit')->with('user', Auth::user());
    }

    // Insert Own Edit

    public function insertEdit($id)
    {
        $this->validate(request(), [
            'fname'         => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'lname'         => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'mobile'        => 'required|digits:11',
            'address'       => 'required|max:255',
        ]);

        $user = User::find($id);

        $user->fname = request('fname');
        $user->lname = request('lname');
        $user->mobile = request('mobile');
        $user->address = request('address');

        $user->update();

        $changes = new UserChanges;

        $changes->activity = 'Updated Account';
        $changes->user_email = Auth::user()->email;
        $changes->remarks = 'Updated own account details';
        $changes->user = Auth::user()->email;
        $changes->changed_at = Carbon::now()->toDateTimeString();

        $changes->save();

        $act = new Activity;

        $act->user_id = Auth::user()->id;
        $act->email = Auth::user()->email;
        $act->module = 'Users';
        $act->activity = 'Updated own account';
        $act->ref_id = $changes->id;
        $act->date_time = Carbon::now();

        $act->save();

        $allusers = User::all();

        return redirect('/admin/details')->with(['user' => Auth::user(), 'allusers' => $allusers, 'success' => 'Successfully updated your details!']);
    }

    // Delete A User

    public function deleteUser($id)
    {
        $del = User::find($id);

        $archive = new UsersArchives;

        $archive->user_id = $del->id;
        $archive->lname = $del->lname;
        $archive->fname = $del->fname;
        $archive->email = $del->email;
        $archive->password = str_random(10);
        $archive->mobile = $del->mobile;
        $archive->address = $del->address;
        $archive->access = $del->access;
        $archive->token = $del->token;
        $archive->remember_token = $del->remember_token;
        $archive->last_login = $del->last_login;
        $archive->user_created = $del->created_at;
        $archive->disabled_by = Auth::user()->email;
        $archive->status = "Disabled";

        $archive->save();

        $changes = new UserChanges;

        $changes->activity = 'Disabled Account';
        $changes->user_email = $del->email;
        $changes->remarks = 'Disabled Account of ' . $del->fname . ' ' . $del->lname;
        $changes->user = Auth::user()->email;
        $changes->changed_at = Carbon::now()->toDateTimeString();

        $changes->save();

        $act = new Activity;

        $act->user_id = Auth::user()->id;
        $act->email = Auth::user()->email;
        $act->module = 'Users';
        $act->activity = 'Disabled Account: ' . $del->email;
        $act->ref_id = $changes->id;
        $act->date_time = Carbon::now();

        $act->save();

        $del->delete();


        return response()->json($del);
    }

    public function archivesUser()
    {
        $arc = UsersArchives::all();

        return view('admin.userarchives', ['arc' => $arc, 'user' => Auth::user()]);
    }

    public function changePass(Request $request, $id)
    {
        $validator = Validator::make(Input::all(), ['password' => 'required|string|min:4']);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $user = User::find($id);

            $user->password = bcrypt($request->password);

            $user->update();

            $changes = new UserChanges;

            $changes->activity = 'Change Password';
            $changes->user_email = $user->email;
            $changes->remarks = 'Changed own password';
            $changes->user = Auth::user()->email;
            $changes->changed_at = Carbon::now()->toDateTimeString();

            $changes->save();

            $act = new Activity;

            $act->user_id = Auth::user()->id;
            $act->email = Auth::user()->email;
            $act->module = 'Users';
            $act->activity = 'Changed own password';
            $act->ref_id = $changes->id;
            $act->date_time = Carbon::now();

            $act->save();

            return response()->json($user);
        }

    }

	// Dashboard

    public function index()
    {

        $today = Carbon::now();
        $lastWk = Carbon::now()->subWeek();
        $newcust = Customers::whereBetween('created_at', [$lastWk->toDateTimeString(), $today->toDateTimeString()])->count('id');
        $orders = Orders::where('trans_date', 'like', Carbon::now()->toDateString() . '%')->where('status', '=', 'Successful')->take(5)->get();
        $dead = DeadChickens::sum('quantity');
        $feeds = Feeds::sum('quantity');
        $reorder = Feeds::sum('reorder_level');
        $act = Activity::orderBy('date_time', 'desc')->take(5)->get();
        $sales = Sales::where('trans_date', '=', Carbon::now()->toDateString())->sum('total_cost');
        $meds = Medicines::all();
        $chickens = InventoryChanges::where('type', '=', 'Chickens')->get();
        $vet = Vet::orderBy('id', 'desc')->first();

    	return view('admin.index')->with(['user' => Auth::user(), 'date' => Carbon::now()->format('l, j F Y'), 'orders' => $orders, 'dead' => $dead, 'newcust' => $newcust, 'feeds' => $feeds, 'reorder' => $reorder, 'act' => $act, 'sales' => $sales, 'meds' => $meds, 'chickens' => $chickens, 'prescription' => $vet->prescription, 'diagnosis' => $vet->diagnosis, 'acknowledge' => $vet->acknowledge]);
    }

}
