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
Route::get('/', function () {
    return view('auth/login');
});

Route::get('dashboard', function () {
    return view('home.index');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user', 'HomeController@user')->name('user')->middleware('role:superadmin,sub_management');
Route::post('/register_user', 'HomeController@register_user')->name('register_user')->middleware('role:superadmin,management');
Route::get('/view_users', 'HomeController@view_users')->name('view_users')->middleware('role:superadmin,management,sub_management');

Auth::routes();

Route::get('product_type', 'ProductController@type');
Route::get('findProductName','ProductController@findProductName');
Route::get('findProductNameForInventory','ProductController@findProductNameForInventory');
Route::get('findName','ProductController@findName');
Route::get('findNameForInventory','ProductController@findNameForInventory');

// ------------------------------------------Management Approval--------------------------------------------------

Route::get('product_management_approval/{id}', 'ProductController@management_approval')->name('products.management.approval');
Route::get('product_type_management_approval/{id}', 'ProductTypeController@management_approval')->name('product_type.management.approval');
Route::get('inventory_management_approval/{id}', 'InventoryController@management_approval')->name('inventories.management.approval');
Route::get('party_type_management_approval/{id}', 'PartyTypeController@management_approval')->name('party_type.management.approval');

Route::get('parties_management_approval/{id}', 'PartyController@management_approval')->name('parties.management.approval');
Route::get('hr_management_approval/{id}', 'HRController@management_approval')->name('hrs.management.approval');
Route::get('zone_management_approval/{id}', 'ZoneController@management_approval')->name('zones.management.approval');
Route::get('sale_management_approval/{id}', 'SaleController@management_approval')->name('sales.management.approval');
Route::get('sale_return_management_approval/{id}', 'SalesReturnController@management_approval')->name('sales_return.management.approval');
Route::get('distribution_management_approval/{id}', 'DistributorInventoryUpdateController@management_approval')->name('distribution.management.approval');
Route::get('payment_received_management_approval/{id}', 'PaymentReceivedController@management_approval')->name('payment_received.management.approval');
Route::get('payment_method_management_approval/{id}', 'PaymentMethodController@management_approval')->name('payment_methods.management.approval');

Route::get('commission_management_approval/{id_party}/{id_product}', 'CommissionController@management_approval')->name('commissions.management.approval');

// -----------------------------------------Audit Approval-------------------------------------------------------

Route::get('product_audit_approval/{id}', 'ProductController@audit_approval')->name('products.audit.approval');
Route::get('product_type_audit_approval/{id}', 'ProductTypeController@audit_approval')->name('product_type.audit.approval');
Route::get('inventory_audit_approval/{id}', 'InventoryController@audit_approval')->name('inventories.audit.approval');
Route::get('party_type_audit_approval/{id}', 'PartyTypeController@audit_approval')->name('party_type.audit.approval');

Route::get('parties_audit_approval/{id}', 'PartyController@audit_approval')->name('parties.audit.approval');
Route::get('hr_audit_approval/{id}', 'HRController@audit_approval')->name('hrs.audit.approval');
Route::get('zone_audit_approval/{id}', 'ZoneController@audit_approval')->name('zones.audit.approval');
Route::get('sale_audit_approval/{id}', 'SaleController@audit_approval')->name('sales.audit.approval');
Route::get('sale_return_audit_approval/{id}', 'SalesReturnController@audit_approval')->name('sales_return.audit.approval');
Route::get('distribution_audit_approval/{id}', 'DistributorInventoryUpdateController@audit_approval')->name('distribution.audit.approval');

Route::get('commission_audit_approval/{id_party}/{id_product}', 'CommissionController@audit_approval')->name('commissions.audit.approval');

// -----------------------------------------Management Dissapproval-----------------------------------------------

Route::get('product_management_dissapproval/{id}', 'ProductController@management_dissapproval')->name('products.management.dissapproval');
Route::get('product_type_management_dissapproval/{id}', 'ProductTypeController@management_dissapproval')->name('product_type.management.dissapproval');
Route::get('inventory_management_dissapproval/{id}', 'InventoryController@management_dissapproval')->name('inventories.management.dissapproval');
Route::get('party_type_management_dissapproval/{id}', 'PartyTypeController@management_dissapproval')->name('party_type.management.dissapproval');

Route::get('parties_management_dissapproval/{id}', 'PartyController@management_dissapproval')->name('parties.management.dissapproval');
Route::get('hr_management_dissapproval/{id}', 'HRController@management_dissapproval')->name('hrs.management.dissapproval');
Route::get('zone_management_dissapproval/{id}', 'ZoneController@management_dissapproval')->name('zones.management.dissapproval');
Route::get('sale_management_dissapproval/{id}', 'SaleController@management_dissapproval')->name('sales.management.dissapproval');
Route::get('sale_return_management_dissapproval/{id}', 'SalesReturnController@management_dissapproval')->name('sales_return.management.dissapproval');
Route::get('distribution_management_dissapproval/{id}', 'DistributorInventoryUpdateController@management_dissapproval')->name('distribution.management.dissapproval');
Route::get('payment_received_management_dissapproval/{id}', 'PaymentReceivedController@management_dissapproval')->name('payment_received.management.dissapproval');
Route::get('payment_method_management_dissapproval/{id}', 'PaymentMethodController@management_dissapproval')->name('payment_methods.management.dissapproval');

Route::get('commission_management_dissapproval/{id_party}/{id_product}', 'CommissionController@management_dissapproval')->name('commissions.management.dissapproval');

// ----------------------------------------Audit Disspproval------------------------------------------------------

Route::get('product_audit_dissapproval/{id}', 'ProductController@audit_dissapproval')->name('products.audit.dissapproval');
Route::get('product_type_audit_dissapproval/{id}', 'ProductTypeController@audit_dissapproval')->name('product_type.audit.dissapproval');
Route::get('inventory_audit_dissapproval/{id}', 'InventoryController@audit_dissapproval')->name('inventories.audit.dissapproval');
Route::get('party_type_audit_dissapproval/{id}', 'PartyTypeController@audit_dissapproval')->name('party_type.audit.dissapproval');

Route::get('parties_audit_dissapproval/{id}', 'PartyController@audit_dissapproval')->name('parties.audit.dissapproval');
Route::get('hr_audit_dissapproval/{id}', 'HRController@audit_dissapproval')->name('hrs.audit.dissapproval');
Route::get('zone_audit_dissapproval/{id}', 'ZoneController@audit_dissapproval')->name('zones.audit.dissapproval');
Route::get('sale_audit_dissapproval/{id}', 'SaleController@audit_dissapproval')->name('sales.audit.dissapproval');
Route::get('sale_return_audit_dissapproval/{id}', 'SalesReturnController@audit_dissapproval')->name('sales_return.audit.dissapproval');
Route::get('distribution_audit_dissapproval/{id}', 'DistributorInventoryUpdateController@audit_dissapproval')->name('distribution.audit.dissapproval');

Route::get('commission_audit_dissapproval/{id_party}/{id_product}', 'CommissionController@audit_dissapproval')->name('commissions.audit.dissapproval');

// ----------------------------------Sales Approval----------------------------------------------------------------

Route::get('hr_sales_approval/{id}', 'HRController@sales_approval')->name('hrs.sales.approval');
Route::get('payment_received_sales_approval/{id}', 'PaymentReceivedController@sales_approval')->name('payment_received.sales.approval');
// ----------------------------------Sales Disspproval-------------------------------------------------------------

Route::get('hr_sales_dissapproval/{id}', 'HRController@sales_dissapproval')->name('hrs.sales.dissapproval');
Route::get('payment_received_sales_dissapproval/{id}', 'PaymentReceivedController@sales_dissapproval')->name('payment_received.sales.dissapproval');

// ---------------------------------------------------------------------------------------------------------------------

Route::get('commission_edit/{id_party}/{id_product}', 'CommissionController@edit_active')->name('commissions.edit.active')->middleware('role:superadmin,sub_management');

Route::get('commission_delete/{id_party}/{id_product}', 'CommissionController@delete_active')->name('commissions.delete.active')->middleware('role:superadmin,sub_management');

// ----------------------------------------------------------------------------------------------------------------

Route::post('commissions_create_second', 'CommissionController@create_second')->name('create_second');
Route::post('commissions_create_third', 'CommissionController@create_third')->name('create_third');
Route::post('update_commission', 'CommissionController@update_commission')->name('commission.update2');

Route::post('return_products', 'SalesReturnController@return_products')->name('sales_return.products');

Route::get('findClientName','PartyController@findClientName');
Route::get('findClientCode','PartyController@findClientCode');
Route::get('findCommission','CommissionController@findCommission');
Route::get('findGatewayCharge','PaymentReceivedController@findGatewayCharge');
Route::get('findSalesInvoices','SaleController@findSalesInvoices');
Route::get('findClientAdjustments','AdjustBalanceController@getClientAdjustments');

Route::resources([
    'products' => 'ProductController',
    'sales' => 'SaleController',
    'product_type' => 'ProductTypeController',
    'party_type' => 'PartyTypeController',
    'parties' => 'PartyController',
    'inventories' => 'InventoryController',
    'hrs' => 'HRController',
    'zones' => 'ZoneController',
    'sales_return' => 'SalesReturnController',
    'distribution' => 'DistributorInventoryUpdateController',
    'payment_received' => 'PaymentReceivedController',
    'payment_methods' => 'PaymentMethodController',
    'commissions' => 'CommissionController',
    'adjust-balance' => 'AdjustBalanceController',
    'distributors' => 'DistributorController',

]);


// Reports route

Route::get('reports', function () {
    return view('reports.show');
})->name('reports');

// daily reports
Route::get('daily_report', 'ReportController@dailyReport')->name('reports.daily');
Route::post('daily_report', 'ReportController@dailyReportGenerator')->name('reports.daily.generate');

// monthly reports
Route::get('monthly_report', 'ReportController@monthlyReport')->name('reports.monthly');
Route::post('monthly_report', 'ReportController@monthlyReportGenerator')->name('reports.monthly.generate');

// monthly statement
Route::get('monthly_statement', 'ReportController@monthlyStatement')->name('statement.monthly');
Route::post('monthly_statement', 'ReportController@monthlyStatementGenerator')->name('statement.monthly.generate');
Route::post('monthly_statement/all-clients', 'ReportController@monthlyStatementAllClients')->name('statement.monthly.all_clients');

Route::get('inventory_report', 'ReportController@inventoryReportGenerator')->name('inventory.report');
Route::get('due_report', 'ReportController@dueReportGenerator')->name('due.report');

// new sales invoice path
Route::get('sales_date/{id}', 'SaleController@date')->name('sales.date');
Route::get('sales_preview/{sale}', 'SaleController@preview')->name('sales.preview');
Route::post('show_sales_invoice/{sale}', 'SaleController@show_invoice')->name('sales.show.invoice');


// new sales_return invoice path
Route::get('sales_return_date/{id}', 'SalesReturnController@date')->name('sales_return.date');
Route::post('show_sales_return_invoice/{sales_return}', 'SalesReturnController@show_invoice')->name('sales_return.show.invoice');



Route::get('adjust-balance/history/{id}', 'AdjustBalanceController@history')->name('adjust-balance.history');
Route::get('adjust-balance/download/{id}', 'AdjustBalanceController@download')->name('adjust-balance.download');
Route::get('adjust-balance/approval/{status}/{adjustment_id}', 'AdjustBalanceController@approval')->name('adjust-balance.approval');


Route::get('test', 'TestController@index');