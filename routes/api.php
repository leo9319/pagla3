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

// Route::middleware('auth:api')->get('/sales', function (Request $request) {
//     $sales = DB::table('sales as S')
//     		->select('S.id', 'S.date', 'S.invoice_no', 'P.party_id', 'PT.type')
//     		->join('parties AS P', 'S.client_id', 'P.id')
//     		->join('party_types AS PT', 'P.party_type_id', 'PT.id')
//     		->whereIn('PT.id', [1,2,3])
//     		->where('S.audit_approval', 1)
//     		->where('S.management_approval', 1)
//     		->get();

// 	// foreach ($sales as $sale) {
// 	// 	$sale_products = DB::table('sale_products AS SP')
// 	// 					->where('SP.invoice_no', $sale->invoice_no)
// 	// 					->get();

		
// 	// }

// 	return $sales;
// });

// Route::middleware('auth:api')->get('/sales_products', function (Request $request) {
//     return $sale_products = SaleProduct::limit(100)->get();
// });
