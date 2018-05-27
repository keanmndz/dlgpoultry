<?php

namespace DLG\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DLG\Medicines;
use DLG\InventoryChanges;
use DLG\Vet;
use DLG\User;
use Carbon\Carbon;
use DLG\Notifications\HealthUpdate;

class VetController extends Controller
{
    // Medicines view for Veterinarian
    public function vetMedicines()
    {
      $meds = Medicines::all();
      $changes = InventoryChanges::where('type', '=', 'Medicines')->get();

      return view('admin.vetmeds')->with(['user' => Auth::user(), 'meds' => $meds, 'changes' => $changes]);
    }

    public function addUpdate()
    {
    	$this->validate(request(), [
            'diagnosis'     => 'required_without_all:prescription,notes',
            'prescription'  => 'required_without_all:diagnosis,notes',
            'notes'         => 'required_without_all:diagnosis,prescription',
        ]);

    	$diagnosis = request('diagnosis');
    	$prescription = request('prescription');
    	$notes = request('notes');

    	if ($diagnosis == '' || $diagnosis == null)
    		$diagnosis = 'None';

    	if ($prescription == '' || $prescription == null)
    		$prescription = 'None';

    	if ($notes == '' || $notes == null)
    		$notes = 'None';

    	$vet = new Vet;

    	$vet->user_id = Auth::user()->id;
    	$vet->email = Auth::user()->email;
    	$vet->fname = Auth::user()->fname;
    	$vet->lname = Auth::user()->lname;
    	$vet->diagnosis = $diagnosis;
    	$vet->prescription = $prescription;
    	$vet->notes = $notes;
    	$vet->acknowledge = 'false';
    	$vet->created_at = Carbon::now()->toDateString();

    	$vet->save();

        $update = Vet::orderBy('id', 'desc')->first();
        $manager = User::where('access', '=', 'Manager')->first();
        $admin = User::where('access', '=', 'System Administrator')->get();

        $manager->notify(new HealthUpdate($update));

        foreach ($admin as $x)
            $x->notify(new HealthUpdate($update));

    	return redirect('/admin/dash')->with('success', 'Successfully given a new update!');

    }

    public function acknowledgeUpdate($id)
    {
    	$update = Vet::find($id);

    	$update->acknowledge = 'true';

    	$update->update();

        $vet = User::where('access', '=', 'Veterinarian')->first();
        $farm = User::where('access', '=', 'Farm Hand')->get();
        $admin = User::where('access', '=', 'System Administrator')->get();

        $vet->notify(new HealthUpdate($update));

        foreach ($farm as $x)
            $x->notify(new HealthUpdate($update));

        foreach ($admin as $x)
            $x->notify(new HealthUpdate($update));

    	return redirect('/admin/details')->with('success', 'You have acknowledged the update!');
    }

        public function administerUpdate($id)
    {
        $update = Vet::find($id);

        $update->acknowledge = 'done';

        $update->update();

        $vet = User::where('access', '=', 'Veterinarian')->first();
        $farm = User::where('access', '=', 'Manager')->first();
        $admin = User::where('access', '=', 'SysAdmin')->get();

        $vet->notify(new HealthUpdate($update));

        $farm->notify(new HealthUpdate($update));

        foreach ($admin as $x)
            $x->notify(new HealthUpdate($update));

        return redirect('/admin/details')->with('success', 'You have administered this update!');
    }
}
