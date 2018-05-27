<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// This is to check the current view, refer to nav
View::composer('*', function($view){

    View::share('view_name', $view->getName());

});

// UNAUTHENTICATED - ENDUSER

Route::get('/', 'HomeController@index');
Route::get('register', 'HomeController@register');
Route::post('register/add', 'HomeController@newCustomer');

//cart
Route::get('menu', 'HomeController@show');
Route::post('menu', 'HomeController@show');

//remove
Route::get('menu/remove', 'HomeController@remove');

//order
Route::post('checkout', 'HomeController@cart');
Route::post('confirm','HomeController@checkDetails');
Route::post('reserve', 'HomeController@Reserve');

// Forgot Password
Route::get('user/request-token', 'Auth\ForgotPasswordController@tokenUser');
Route::post('user/send-fpw', 'Auth\ForgotPasswordController@forgotUser');
Route::get('user/reset-pw/{token}', 'Auth\ForgotPasswordController@resetUserPw');
Route::post('user/reset-pw/confirm', 'Auth\ForgotPasswordController@confirmUser');

// THESE ROUTES BELOW CAN ONLY BE ACCESSED IF LOGGED IN

// CHECKS IF CUSTOMER, ALL CUSTOMER ROUTES
Route::group(['middleware' => 'customer'], function() {
	
	// Logout
	Route::get('logout', 'HomeController@logout');

	// Account
	Route::get('account', 'HomeController@viewAccount');

	// Reservations
	Route::get('cancel-reservation/{id}', 'HomeController@cancelReservation');

	// Edit Details
	Route::get('account/edit/{id}', 'HomeController@editAccount');
	Route::post('account/edit/{id}/insert', 'HomeController@insertEdit');

	// Change Password
	Route::get('account/change-password/{id}', 'HomeController@resetPassword');
	Route::post('account/change-password/insert', 'HomeController@confirmReset');

	// Disable Account
	Route::get('account/disable-account/{id}', 'HomeController@disableView');
	Route::post('account/disable-account/confirm', 'HomeController@disable');	

});

// CHECKS IF ADMIN, ALL ADMIN ROUTES
Route::group(['middleware' => 'admin'], function() {

	// Notifications
	Route::get('/markAsRead', function() {
		Auth::user()->unreadNotifications->markAsRead();
	});

	// Logout
	Route::get('admin/logout', 'Auth\LoginController@logout');

	// Admin Panel
	Route::get('admin/create', 'AdminController@createNew');
		// Current Logged In User
		Route::get('admin/details', 'AdminController@details');
		Route::get('admin/edit/{id}', 'AdminController@editInfo');
      	Route::post('admin/edit/{id}/pass', 'AdminController@changePass');
		Route::post('admin/new', 'Auth\RegisterController@create');
		Route::post('admin/edit/{id}/insert', 'AdminController@insertEdit'); // has bugs
		// Manage Other Users
		Route::get('admin/{id}/delete', 'AdminController@deleteUser');
		Route::get('admin/archives', 'AdminController@archivesUser');

  	// Dashboard
	Route::get('admin/dash', 'AdminController@index');

	// POS
	Route::get('pos', 'POSController@index');
	Route::post('pos/add', 'POSController@currentOrder');
	Route::post('pos/confirm', 'POSController@confirmOrder');
	Route::get('pos/cancel', 'POSController@cancelOrder');
	Route::get('pos/cancel/{id}', 'POSController@cancelItem');

   	// Orders
   	Route::get('orders', 'OrdersController@show');
   	Route::get('orders/details/{id}', 'OrdersController@orderDetails');
   	Route::get('orders/confirm-reservation/{id}', 'OrdersController@confirmReserve');
   	Route::get('orders/cancel-reservation/{id}', 'OrdersController@cancelReserve');

   	// Sales
   	Route::get('current-sales', 'SalesController@history');

	// Inventory
	Route::get('inventory', 'InventoryController@show');
	Route::post('inventory/update-price', 'InventoryController@updatePrice');
	Route::post('inventory/update-reorder', 'InventoryController@updateReorder');
	Route::post('inventory/add', 'InventoryController@add');
	Route::post('inventory/add-quantity', 'InventoryController@addQuantity');
	Route::post('inventory/use-quantity', 'InventoryController@useQuantity');
		// Inventory Navigation
		Route::get('inventory/eggs', 'InventoryController@showEggs');
			Route::post('inventory/eggs/add', 'InventoryController@addEggs');
			Route::post('inventory/eggs/update', 'InventoryController@updateEggs');
			Route::post('inventory/eggs/edit', 'InventoryController@editEggs');
			Route::post('inventory/eggs/edit-other', 'InventoryController@editOther');
		Route::get('inventory/chickens', 'InventoryController@showChickens');
			Route::post('inventory/chickens/add', 'InventoryController@addChickens');
			Route::post('inventory/chickens/update', 'InventoryController@updateChickens');
			Route::post('inventory/chickens/edit', 'InventoryController@editChickens');
		Route::get('inventory/pullets', 'InventoryController@showPullets');
			Route::post('inventory/pullets/add', 'InventoryController@addPullets');
			Route::post('inventory/pullets/update', 'InventoryController@updatePullets');
			Route::post('inventory/pullets/edit', 'InventoryController@editPullets');

	// Customers
	Route::get('customers', 'CustomersController@ViewCustomers');
		// Create Customer
		Route::get('customers/create', 'CustomersController@createCustomer');
		Route::post('customers/add', 'CustomersController@addCustomer');
		// Edit Customer
		Route::get('customers/{id}/edit', 'CustomersController@editCustomer');
		Route::post('customers/{id}/update', 'CustomersController@updateCustomer');
		// Delete Customer
		Route::get('customers/{id}/delete', 'CustomersController@delCustomer');
	Route::get('customers/archives', 'CustomersController@custArchives');

	// Production
	Route::get('production', 'ProductionController@show');
	Route::get('production/production-stats', 'ProductionController@prodStats');
	Route::get('prod/pdf', 'ProductionController@ProdReport');

	// Population
	Route::get('population', 'PopulationController@show');
	Route::get('population/population-stats', 'PopulationController@popStats');
	Route::get('population/cull-stats', 'PopulationController@cullStats');
	Route::get('population/dead-stats', 'PopulationController@deadStats');
	Route::get('population/pdf', 'PopulationController@ChickenReport');

	// Sales
	Route::get('sales', 'SalesController@show');
	Route::get('sales/sales-stats', 'SalesController@salesStats');
	Route::get('sales/pdf', 'SalesController@SalesReport');
	Route::get('sales/pdf2', 'SalesController@SalesReport2');

	// Approvals
	Route::get('approvals/approve/{id}', 'ApprovalsController@approve');
	Route::get('approvals/disapprove/{id}', 'ApprovalsController@disapprove');

	// Vet
	Route::get('vet/medicines', 'VetController@vetMedicines');
	Route::post('vet/add', 'VetController@addUpdate');
	Route::get('vet/acknowledge/{id}', 'VetController@acknowledgeUpdate');
	Route::get('vet/administer/{id}', 'VetController@administerUpdate');

});

// Forgot Password
Route::get('admin/request-token', 'Auth\ForgotPasswordController@requestToken');
Route::post('admin/send-fpw', 'Auth\ForgotPasswordController@forgotPassword');
Route::get('admin/reset-pw/{token}', 'Auth\ForgotPasswordController@resetPwView');
Route::post('admin/reset-pw/confirm', 'Auth\ForgotPasswordController@confirmReset');

// Admin Login
Route::get('admin', 'Auth\LoginController@loginform');
Route::post('admin/login', 'Auth\LoginController@login');

// Customer Login
Route::post('login', 'HomeController@login');

// Unauthorized Access
Route::get('unauthorized', function () {
	return view('unauthorized');
});