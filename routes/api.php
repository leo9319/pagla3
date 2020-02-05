<?php

use App\Inventory;
use App\Product;
use App\Sale;
use App\SaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->get('/inventories', function (Request $request) {
//     return Inventory::where([
//     	'audit_approval' => 1,
//     	'management_approval' => 1,
//     ])->get();
// });

Route::middleware('auth:api')->get('/sales', function (Request $request) {
    $sales = DB::table('sales as S')
    		->select('S.id', 'S.date', 'S.invoice_no', 'P.party_id', 'PT.type')
    		->join('parties AS P', 'S.client_id', 'P.id')
    		->join('party_types AS PT', 'P.party_type_id', 'PT.id')
    		->whereIn('PT.id', [1,2,3])
    		->where('S.audit_approval', 1)
    		->where('S.management_approval', 1)
    		->get();

	return $sales;
});

Route::middleware('auth:api')->get('/sales_products', function (Request $request) {
    $sale_products = DB::table('sales_products AS SP')
    				->select('SP.id', 'SP.invoice_no', 'SP.price_per_unit', 'SP.quantity', 'P.product_code')
    				->join('products AS P', 'P.id', 'SP.product_id')
    				->get();

    return $sale_products;
});

Route::middleware('auth:api')->get('/return', function (Request $request) {
    $sales_returns = DB::table('sales_returns as SR')
    		->select('SR.id', 'SR.date', 'SR.invoice_no', 'P.party_id', 'PT.type')
    		->join('parties AS P', 'SR.client_id', 'P.id')
    		->join('party_types AS PT', 'P.party_type_id', 'PT.id')
    		->whereIn('PT.id', [1,2,3])
    		->where('SR.audit_approval', 1)
    		->where('SR.management_approval', 1)
    		->get();

	return $sales_returns;
});

Route::middleware('auth:api')->get('/return_products', function (Request $request) {
    $return_products = DB::table('sales_returns_products AS SRP')
    				->select('SRP.id', 'SRP.invoice_no', 'SRP.price_per_unit', 'SRP.quantity', 'P.product_code')
    				->join('sales_returns AS SR', 'SR.invoice_no', 'SRP.invoice_no')
    				->join('products AS P', 'P.id', 'SRP.product_id')
    				->where('SR.audit_approval', 1)
    				->where('SR.management_approval', 1)
    				->get();

    return $return_products;
});