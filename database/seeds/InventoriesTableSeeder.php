<?php

use Illuminate\Database\Seeder;
use DLG\Eggs;
use DLG\Feeds;
use DLG\Supplies;
use DLG\Products;
use DLG\Medicines;
use DLG\Equipment;
use DLG\Chickens;
use DLG\Pullets;
use DLG\BrokenEggs;
use DLG\RejectEggs;
use DLG\DeadChickens;
use DLG\TotalChickens;
use DLG\TotalPullets;
use DLG\DeadPullets;
use DLG\Cull;
use DLG\Activity;
use DLG\Vet;
use Carbon\Carbon;

class InventoriesTableSeeder extends Seeder
{

    public function run()
    {

      $date = Carbon::now();
      $culldays = Carbon::now();
      $culldays->addDays(548);
      $maturity = Carbon::now();
      $maturity->addDays(182);
      $life = Carbon::now();
      $life->addDays(7);

      $eggs = [
        ['batch_id' => Carbon::now()->format('YmdA') . '-1', 'jumbo' => '1', 'xlarge' => '2', 'large' => '3', 'medium' => '4', 'small' => '5', 'peewee' => '6', 'softshell' => '7', 'total_jumbo' => '1', 'total_xlarge' => '2', 'total_large' => '3', 'total_medium' => '4', 'total_small' => '5', 'total_peewee' => '6', 'total_softshell' => '7', 'added_by' => 'SEEDER', 'lifetime' => $life->toDateString(), 'created_at' => $date->toDateString(), 'time_added' => $date->toTimeString()],
        ['batch_id' => Carbon::now()->format('YmdA') . '-2', 'jumbo' => '10', 'xlarge' => '9', 'large' => '8', 'medium' => '7', 'small' => '6', 'peewee' => '5', 'softshell' => '4', 'total_jumbo' => '11', 'total_xlarge' => '11', 'total_large' => '11', 'total_medium' => '11', 'total_small' => '11', 'total_peewee' => '11', 'total_softshell' => '11', 'added_by' => 'SEEDER', 'lifetime' => $life->toDateString(), 'created_at' => $date->toDateString(), 'time_added' => $date->toTimeString()],
        ['batch_id' => Carbon::now()->format('YmdA') . '-3', 'jumbo' => '11', 'xlarge' => '12', 'large' => '13', 'medium' => '14', 'small' => '15', 'peewee' => '14', 'softshell' => '13', 'total_jumbo' => '22', 'total_xlarge' => '23', 'total_large' => '24', 'total_medium' => '25', 'total_small' => '26', 'total_peewee' => '25', 'total_softshell' => '24', 'added_by' => 'SEEDER', 'lifetime' => $life->toDateString(), 'created_at' => $date->toDateString(), 'time_added' => $date->toTimeString()]
      ];

      $reject = [
        ['batch_id' => Carbon::now()->format('YmdA') . '-1', 'quantity' => '5', 'total' => '5', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['batch_id' => Carbon::now()->format('YmdA') . '-2', 'quantity' => '10', 'total' => '15', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['batch_id' => Carbon::now()->format('YmdA') . '-3', 'quantity' => '15', 'total' => '30', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER']
      ];

      $broken = [
        ['quantity' => '5', 'total' => '5', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['quantity' => '10', 'total' => '15', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['quantity' => '15', 'total' => '30', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER']
      ];

      $chickens = [
        ['batch' => '1', 'batch_id' => Carbon::now()->format('YmdA') . '-1', 'quantity' => '50', 'to_cull' => $culldays->toDateString(), 'added_by' => 'SEEDER', 'created_at' => $date->toDateTimeString(), 'remarks' => 'Initial batch'],
        ['batch' => '2', 'batch_id' => Carbon::now()->format('YmdA') . '-2', 'quantity' => '48', 'to_cull' => $culldays->toDateString(), 'added_by' => 'SEEDER', 'created_at' => $date->toDateTimeString(), 'remarks' => 'Initial batch'],
        ['batch' => '3', 'batch_id' => Carbon::now()->format('YmdA') . '-3', 'quantity' => '50', 'to_cull' => $culldays->toDateString(),'added_by' => 'SEEDER', 'created_at' => $date->toDateTimeString(), 'remarks' => 'Initial batch']
      ];

      $totalchix = [
        ['batch' => '1', 'quantity' => '50', 'total' => '50', 'updated_by' => 'SEEDER'],
        ['batch' => '2', 'quantity' => '48', 'total' => '98', 'updated_by' => 'SEEDER'],
        ['batch' => '3', 'quantity' => '50', 'total' => '148', 'updated_by' => 'SEEDER']
      ];

      $cull = [
        ['batch_id' => '1', 'quantity' => '5', 'total' => '5', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['batch_id' => '2', 'quantity' => '7', 'total' => '12', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['batch_id' => '3', 'quantity' => '10', 'total' => '22', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER']
      ];

      $deadchix = [
        ['batch_id' => '1', 'quantity' => '2', 'total' => '2', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['batch_id' => '2', 'quantity' => '3', 'total' => '5', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['batch_id' => '3', 'quantity' => '4', 'total' => '9', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER']
      ];

      $deadpulls = [
        ['batch_id' => '1', 'quantity' => '5', 'total' => '5', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['batch_id' => '2', 'quantity' => '6', 'total' => '11', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER'],
        ['batch_id' => '3', 'quantity' => '7', 'total' => '18', 'remarks' => 'Initial count from batch', 'added_by' => 'SEEDER']
      ];

      $pullets = [
        ['batch' => '1', 'batch_id' => Carbon::now()->format('YmdA') . '-' . '1', 'quantity' => '50', 'date_added' => $date->toDateString(), 'maturity' => $maturity->toDateString(), 'remarks' => 'Growing', 'added_by' => 'SEEDER'],
        ['batch' => '2', 'batch_id' => Carbon::now()->format('YmdA') . '-' . '2', 'quantity' => '50', 'date_added' => $date->toDateString(), 'maturity' => $maturity->toDateString(), 'remarks' => 'Growing', 'added_by' => 'SEEDER'],
        ['batch' => '3', 'batch_id' => Carbon::now()->format('YmdA') . '-' . '3', 'quantity' => '47', 'date_added' => $date->toDateString(), 'maturity' => $maturity->toDateString(), 'remarks' => 'Growing', 'added_by' => 'SEEDER']
      ];

      $totalpulls = [
        ['batch' => '1', 'quantity' => '50', 'total' => '50', 'updated_by' => 'SEEDER'],
        ['batch' => '2', 'quantity' => '50', 'total' => '100', 'updated_by' => 'SEEDER'],
        ['batch' => '3', 'quantity' => '47', 'total' => '147', 'updated_by' => 'SEEDER']
      ];

      $feeds = [
        ['name' => 'Feed Mix 1', 'price' => '200', 'quantity' => '50', 'unit' => 'sacks', 'reorder_level' => '15', 'added_by' => 'SEEDER'],
        ['name' => 'Feed Mix 2', 'price' => '210', 'quantity' => '50', 'unit' => 'sacks', 'reorder_level' => '15', 'added_by' => 'SEEDER'],
        ['name' => 'Feed Mix 3', 'price' => '220', 'quantity' => '50', 'unit' => 'sacks', 'reorder_level' => '15', 'added_by' => 'SEEDER']
      ];

      $medicines = [
        ['name' => 'Triple V', 'price' => '200', 'quantity' => '30', 'unit' => 'grams', 'reorder_level' => '20', 'expiry' => Carbon::now()->addYears(3)->toDateString(), 'added_by' => 'SEEDER'],
        ['name' => 'Rivoflex Vitamin B', 'price' => '300', 'quantity' => '35', 'unit' => 'grams', 'reorder_level' => '25', 'expiry' => Carbon::now()->addYears(3)->toDateString(), 'added_by' => 'SEEDER'],
        ['name' => 'Gallistat', 'price' => '500', 'quantity' => '45', 'unit' => 'grams', 'reorder_level' => '30', 'expiry' => Carbon::now()->addYears(3)->toDateString(), 'added_by' => 'SEEDER'],
        ['name' => 'Liquiphos', 'price' => '500', 'quantity' => '45', 'unit' => 'grams', 'reorder_level' => '30', 'expiry' => Carbon::now()->addYears(3)->toDateString(), 'added_by' => 'SEEDER']
      ];

      $supplies = [
        ['name' => 'Sacks', 'price' => '20', 'quantity' => '100', 'reorder_level' => '20', 'added_by' => 'SEEDER'],
        ['name' => 'Trays', 'price' => '50', 'quantity' => '200', 'reorder_level' => '100', 'added_by' => 'SEEDER'],
        ['name' => 'Plastics', 'price' => '100', 'quantity' => '100', 'reorder_level' => '30', 'added_by' => 'SEEDER']
      ];

      $equip = [
        ['name' => 'Shovels', 'price' => '200', 'quantity' => '20', 'reorder_level' => '10', 'added_by' => 'SEEDER'],
        ['name' => 'Cages', 'price' => '200', 'quantity' => '300', 'reorder_level' => '150', 'added_by' => 'SEEDER'],
        ['name' => 'Wheel Barrow', 'price' => '2000', 'quantity' => '10', 'reorder_level' => '3', 'added_by' => 'SEEDER']
      ];

      Vet::create([
        'user_id' => '5',
        'email' => 'janesmith@maildrop.cc',
        'fname' => 'Dr. Jane',
        'lname' => 'Smith',
        'diagnosis' => 'Healthy',
        'prescription' => 'Feed twice a day',
        'notes' => 'Keep track of chicken production.',
        'acknowledge' => 'done',
        'created_at' => Carbon::now()->toDateString()
      ]);

      foreach ($feeds as $feed)
      {
        Feeds::create($feed);
      }

      foreach ($medicines as $meds)
      {
        Medicines::create($meds);
      }

      foreach ($supplies as $supp)
      {
        Supplies::create($supp);
      }

      foreach ($equip as $equips)
      {
        Equipment::create($equips);
      }

      foreach ($eggs as $egg)
      {
        Eggs::create($egg);
      }

      foreach ($reject as $rejects)
      {
        RejectEggs::create($rejects);
      }

      foreach ($broken as $item)
      {
        BrokenEggs::create($item);
      }

      foreach ($chickens as $chicken)
      {
        Chickens::create($chicken);
      }

      foreach ($pullets as $pullet)
      {
        Pullets::create($pullet);
      }

      foreach ($cull as $culls)
      {
        Cull::create($culls);
      }

      foreach ($totalchix as $tchix)
      {
        TotalChickens::create($tchix);
      }

      foreach ($totalpulls as $tpulls)
      {
        TotalPullets::create($tpulls);
      }

      foreach ($deadchix as $chix)
      {
        DeadChickens::create($chix);
      }

      foreach ($deadpulls as $pulls)
      {
        DeadPullets::create($pulls);
      }

      $cull = Cull::orderBy('id', 'desc')->first();

      $eggs = Eggs::orderBy('id', 'desc')->first();

      $broken = BrokenEggs::orderBy('id', 'desc')->first();

      $prods = [
        ['name' => 'Manure', 'retail_price' => '100', 'wholesale_price' => '80', 'stocks' => '200', 'added_by' => 'SEEDER'],
        ['name' => 'Sacks', 'retail_price' => '8', 'wholesale_price' => '6', 'stocks' => '100', 'added_by' => 'SEEDER'],
        ['name' => 'Cull', 'retail_price' => '200', 'wholesale_price' => '180', 'stocks' => $cull->total, 'added_by' => 'SEEDER'],
        ['name' => 'Jumbo Eggs', 'retail_price' => '8', 'wholesale_price' => '6', 'stocks' => $eggs->total_jumbo, 'added_by' => 'SEEDER'],
        ['name' => 'Extra Large Eggs', 'retail_price' => '7.5', 'wholesale_price' => '5.5', 'stocks' => $eggs->total_xlarge, 'added_by' => 'SEEDER'],
        ['name' => 'Large Eggs', 'retail_price' => '7', 'wholesale_price' => '5', 'stocks' => $eggs->total_large, 'added_by' => 'SEEDER'],
        ['name' => 'Medium Eggs', 'retail_price' => '6.5', 'wholesale_price' => '4.5', 'stocks' => $eggs->total_medium, 'added_by' => 'SEEDER'],
        ['name' => 'Small Eggs', 'retail_price' => '6', 'wholesale_price' => '4', 'stocks' => $eggs->total_small, 'added_by' => 'SEEDER'],
        ['name' => 'Peewee Eggs', 'retail_price' => '5', 'wholesale_price' => '3.5', 'stocks' => $eggs->total_peewee, 'added_by' => 'SEEDER'],
        ['name' => 'Broken Eggs', 'retail_price' => '4', 'wholesale_price' => '3', 'stocks' => $broken->total, 'added_by' => 'SEEDER']
      ];

      foreach ($prods as $prod)
      {
        Products::create($prod);
      }

    }
}
