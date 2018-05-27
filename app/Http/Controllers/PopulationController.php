<?php

namespace DLG\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use DLG\User;
use DLG\Orders;
use DLG\Chickens;
use DLG\TotalChickens;
use DLG\Cull;
use DLG\Customers;
use DLG\Feeds;
use DLG\DeadChickens;
use DLG\Pullets;
use DLG\TotalPullets;
use DLG\DeadPullets;
use DLG\UsersArchives;
use DLG\Activity;
use DLG\RejectEggs;
use Carbon\Carbon;
use PDF;

class PopulationController extends Controller
{

	// Show page only when authenticated

	public function __construct()
	{
		$this->middleware('admin');
	}

    // Show

    public function show()
    {
    	return view('admin.population')->with('user', Auth::user());
    }

    public function popStats()
    {
        $chickens = TotalChickens::all();

        return response()->json($chickens);
    }

    public function cullStats()
    {
        $cull = Cull::take(5)->get();

        return response()->json($cull);
    }

    public function deadStats()
    {
        $dead = DeadChickens::all();

        return response()->json($dead);
    }

    //Generate Report

    public function ChickenReport(request $request)
    {
    	$chickens=TotalChickens::all();
        $chic=Chickens::all();
        $culls=Cull::all();
        $deads=DeadChickens::where('created_at', 'like', '%'.Carbon::now()->toDateString().'%')->get();
        $reject=RejectEggs::all();
        $pullets=TotalPullets::all();
        $pul=Pullets::all();
        $deadpullets=DeadPullets::where('created_at', 'like', '%'.Carbon::now()->toDateString().'%')->get();
        $maxChicken=TotalChickens::max('id');
        $maxPullet=TotalPullets::max('id');

        view()->share('popPDFchicken',$chickens);
        view()->share('popPDFchic',$chic);
        view()->share('popPDFcull',$culls);
        view()->share('popPDFdead',$deads);
        view()->share('popPDFreject',$reject);
        view()->share('popPDFpullet',$pullets);
        view()->share('popPDFpul',$pul);
        view()->share('popPDFdeadpullet',$deadpullets);
        view()->share('popPDFmaxchicken',$maxChicken);
        view()->share('popPDFmaxpullet',$maxPullet);


        $pdf = PDF::loadView('admin/popPDF'); $pdf->setPaper('Legal', 'landscape'); 
        return $pdf->stream('population/pdf.pdf');

        $popPDFchicken=PDF::loadView('admin/popPDF', compact('chickens'));
        return $popPDFchicken->stream('population/pdf.pdf');

        $popPDFchic=PDF::loadView('admin/popPDF', compact('chic'));
        return $popPDFchic->stream('population/pdf.pdf');

        $popPDFcull=PDF::loadView('admin/popPDF', compact('culls'));
        return $popPDFcull->stream('population/pdf.pdf');

        $popPDFdead=PDF::loadView('admin/popPDF', compact('deads'));
        return $popPDFdead->stream('population/pdf.pdf');
    
        $popPDFreject=PDF::loadView('admin/popPDF', compact('reject'));
        return $popPDFreject->stream('population/pdf.pdf');

        $popPDFpullet=PDF::loadView('admin/popPDF', compact('pullets'));
        return $popPDFpullet->stream('population/pdf.pdf');

        $popPDFpul=PDF::loadView('admin/popPDF', compact('pul'));
        return $popPDFpul->stream('population/pdf.pdf');

        $popPDFdeadpullet=PDF::loadView('admin/popPDF', compact('deadpullets'));
        return $popPDFdeadpullet->stream('population/pdf.pdf');

        $popPDFmaxchicken=PDF::loadView('admin/popPDF', compact('maxChicken'));
        return $popPDFmaxchicken->stream('population/pdf.pdf');

        $popPDFmaxpullet=PDF::loadView('admin/popPDF', compact('maxPullet'));
        return $popPDFmaxpullet->stream('population/pdf.pdf');

        // $data = Entry::find($id);
        // $pdf = PDF::loadView('posts.pdfview', compact('data'));
        // return $pdf->stream();
    }
}
