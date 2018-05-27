<?php

namespace DLG\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use DLG\User;
use DLG\Sales;
use DLG\Orders;
use DLG\OrderDetails;
use DLG\Products;
use DLG\TotalChickens;
use DLG\Cull;
use DLG\Customers;
use DLG\Feeds;
use DLG\DeadChickens;
use DLG\UsersArchives;
use DLG\Activity;
use DLG\SoldEggs;
use Carbon\Carbon;
use PDF;

class SalesController extends Controller
{

	public function __construct()
	{
		$this->middleware('admin');
	}

    // Sales History

    public function history()
    {
        $sales = Sales::orderBy('id', 'desc')->get();
        $soldeggs = SoldEggs::all();

        return view('admin.allsales')->with(['sales' => $sales, 'soldeggs' => $soldeggs, 'user' => Auth::user()]);
    }

    // Show

    public function show()
    {
    	return view('admin.sales')->with('user', Auth::user());
    }

    public function salesStats()
    {
        $yesterday = Carbon::now()->subDay(1);
        $yesterday = Sales::where('trans_id', 'like', $yesterday->format('Ymd') . '%')->sum('total_cost');
        $today = Sales::where('trans_id', 'like', Carbon::now()->format('Ymd') . '%')->sum('total_cost');

        return response()->json([$yesterday, $today]);
    }

    //Generate Report

    public function SalesReport(request $request)
    {
        $today = Carbon::today()->toDateString();
        $orders = Sales::where('trans_date', 'like', '%'.Carbon::now()->toDateString().'%')->get();
        $orderdetails=OrderDetails::where('created_at', 'like', '%'.Carbon::now()->toDateString().'%')->get(); 
        $customers=Customers::all();
        $products=Products::all();
        $maxOrder=count($orders);

        view()->share('salesPDForder',$orders);
        view()->share('salesPDFdetail',$orderdetails);
        view()->share('salesPDFcust',$customers);
        view()->share('salesPDFprod',$products);
        view()->share('salesPDFmaxorder',$maxOrder);


        $pdf = PDF::loadView('admin/salesPDF'); $pdf->setPaper('Legal', 'landscape'); 
        return $pdf->stream('sales/pdf.pdf');

        $salesPDForder=PDF::loadView('admin/salesPDF', compact('orders'));
        return $salesPDForder->stream('sales/pdf.pdf');

        $salesPDFdetail=PDF::loadView('admin/salesPDF', compact('orderdetails'));
        return $salesPDFdetail->stream('sales/pdf.pdf');

        $salesPDFcust=PDF::loadView('admin/salesPDF', compact('customers'));
        return $salesPDFcust->stream('sales/pdf.pdf');

        $salesPDFprod=PDF::loadView('admin/salesPDF', compact('products'));
        return $salesPDFprod->stream('sales/pdf.pdf');

        $salesPDFmaxorder=PDF::loadView('admin/salesPDF', compact('maxOrder'));
        return $salesPDFmaxorder->stream('sales/pdf.pdf');



        // $data = Entry::find($id);
        // $pdf = PDF::loadView('posts.pdfview', compact('data'));
        // return $pdf->stream();
    }

    public function SalesReport2(request $request)
    {
        $today = Carbon::today()->toDateString();
        $orders = Sales::where('trans_date', 'like', '%'.Carbon::now()->toDateString().'%')->get();
        $orderdetails=OrderDetails::where('created_at', 'like', '%'.Carbon::now()->toDateString().'%')->get(); 
        $customers=Customers::all();
        $products=Products::all();
        $maxOrder=count($orders);

        view()->share('salesPDForder',$orders);
        view()->share('salesPDFdetail',$orderdetails);
        view()->share('salesPDFcust',$customers);
        view()->share('salesPDFprod',$products);
        view()->share('salesPDFmaxorder',$maxOrder);


        $pdf = PDF::loadView('admin/salesPDF2'); $pdf->setPaper('Legal', 'landscape'); 
        return $pdf->stream('sales/pdf2.pdf');

        $salesPDForder=PDF::loadView('admin/salesPDF2', compact('orders'));
        return $salesPDForder->stream('sales/pdf2.pdf');

        $salesPDFdetail=PDF::loadView('admin/salesPDF2', compact('orderdetails'));
        return $salesPDFdetail->stream('sales/pdf2.pdf');

        $salesPDFcust=PDF::loadView('admin/salesPDF2', compact('customers'));
        return $salesPDFcust->stream('sales/pdf2.pdf');

        $salesPDFprod=PDF::loadView('admin/salesPDF2', compact('products'));
        return $salesPDFprod->stream('sales/pdf2.pdf');

        $salesPDFmaxorder=PDF::loadView('admin/salesPDF2', compact('maxOrder'));
        return $salesPDFmaxorder->stream('sales/pdf2.pdf');



        // $data = Entry::find($id);
        // $pdf = PDF::loadView('posts.pdfview', compact('data'));
        // return $pdf->stream();
    }
}
