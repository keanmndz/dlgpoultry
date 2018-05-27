<?php

namespace DLG\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DLG\Eggs;
use DLG\BrokenEggs;
use DLG\RejectEggs;
use DLG\InventoryChanges;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use DLG\User;
use DLG\Orders;
use DLG\OrderDetails;
use DLG\Products;
use DLG\Chickens;
use DLG\Cull;
use DLG\Customers;
use DLG\Feeds;
use DLG\DeadChickens;
use DLG\UsersArchives;
use DLG\Activity;
use PDF;

class ProductionController extends Controller
{

	public function __construct()
	{
		$this->middleware('admin');
	}

    // Show

    public function show()
    {
        $eggs = Eggs::orderBy('id', 'desc')->first();

    	return view('admin.production', ['user' => Auth::user(), 'inv' => $eggs]);
    }

    // Load Chart Data

    public function prodStats()
    {
        $weekly = Eggs::orderBy('created_at', 'desc')->take(6)->get();

        return response()->json($weekly);
    } 

    public function ProdReport(request $request)
    {
        $eggs = Eggs::where('created_at', 'like', '%'.Carbon::now()->toDateString().'%')->get();
        $broken = BrokenEggs::where('created_at', 'like', '%'.Carbon::now()->toDateString().'%')->get();
        $reject = RejectEggs::where('created_at', 'like', '%'.Carbon::now()->toDateString().'%')->get();
        $returns = InventoryChanges::where('changed_at', 'like', '%'.Carbon::now()->toDateString().'%')->get()->where('remarks', '=', 'Returned Eggs.');
        $return = count($returns);
        $count = count($eggs);
        $countrjk = count($reject);


        view()->share('prodPDFeggs',$eggs);
        view()->share('prodPDFbroken',$broken);
        view()->share('prodPDFreject',$reject);
        view()->share('prodPDFcount',$count);
        view()->share('prodPDFcountrjk',$countrjk);
        view()->share('prodPDFreturn',$return);

        $pdf = PDF::loadView('admin/prodPDF'); 
        $pdf->setPaper('Legal', 'landscape');
        return $pdf->stream('prod/pdf.pdf');

        $prodPDFeggs=PDF::loadView('admin/prodPDF', compact('eggs'));
        return $prodPDFeggs->stream('prod/pdf.pdf');

        $prodPDFbroken=PDF::loadView('admin/prodPDF', compact('broken'));
        return $prodPDFbroken->stream('prod/pdf.pdf');

        $prodPDFreject=PDF::loadView('admin/prodPDF', compact('reject'));
        return $prodPDFreject->stream('prod/pdf.pdf');

        $prodPDFcount=PDF::loadView('admin/prodPDF', compact('count'));
        return $prodPDFcount->stream('prod/pdf.pdf');

        $prodPDFcountrjk=PDF::loadView('admin/prodPDF', compact('countrjk'));
        return $prodPDFcountrjk->stream('prod/pdf.pdf');

        $prodPDFreturn=PDF::loadView('admin/prodPDF', compact('return'));
        return $prodPDFreturn->stream('prod/pdf.pdf');




        // $data = Entry::find($id);
        // $pdf = PDF::loadView('posts.pdfview', compact('data'));
        // return $pdf->stream();
    }

    
    // // Generate Reports, highlight selection then press Ctrl+/ to remove/add comments

    // public function pdfview(Request $request, $id)
    // {
    //     $today = Carbon::now();
    //     $eggs = Eggs::where('created_at', '=', $today->toDateString())->get();

    //     view()->share('eggs', $eggs);

    //     $pdf=PDF::loadView('pdfview');
    //     return $pdf->stream('pdfview.pdf');
    // }

    

}
