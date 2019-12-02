<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\DailyReportExport;
use App\Exports\DailyReportExportSaleRet;
use App\Exports\DailyReportExportDetailSales;
use App\Exports\DailyReportExportDetailSalesReturn;
use App\Exports\DailyReportExportDetailPay;
use App\Exports\DailyReportExportDetailInv;
use App\Exports\MonthlyReportExportDetailSales;
use App\Exports\MonthlyReportExportAllClients;
use App\Exports\MonthlyReportExportDetailSalesReturns;
use App\Exports\MonthlyReportExportDetailPayment;
use App\Exports\MonthlyStatementExport;
use App\Exports\MonthlyReportExportDetailInv;
use App\Exports\InventoryReportExport;
use App\Exports\DueReportExport;
use App\Exports\DailyReportExportDetailDiscount;
use App\Party;
use DB;
use App\Sale;
use App\Sales_return;
use DateTime;
use DateInterval;
use DatePeriod;


class ReportController extends Controller
{
    public function dailyReport() 
    {
        return view('reports.daily');
    }

    public function monthlyReport() 
    {
        return view('reports.monthly');
    }

    public function dailyReportGenerator(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $table_id = $request->table_id;
        $report_name = $request->report_name;

        // We are now dealing with Client Report
        if ($report_name == 1) {
            if ($table_id == 1) { //  'Sales'
                $all_sales = Sale::where('date', '>=', $start_date)
                    ->where('date', '<=', $end_date)
                    ->where('audit_approval', '=', 1)
                    ->where('management_approval', '=', 1)
                    ->get();

                    return Excel::download(new DailyReportExport($all_sales, $start_date, $end_date), 'Client Sales (Daily).xlsx');
            }
            else if ($table_id == 2){ // 'Sales Return'
                $all_sales_return = Sales_return::where('date', '>=', $start_date)
                    ->where('date', '<=', $end_date)
                    ->where('audit_approval', '=', 1)
                    ->where('management_approval', '=', 1)
                    ->get();

                    return Excel::download(new DailyReportExportSaleRet($all_sales_return, $start_date, $end_date), 'Client Sales Return (Daily).xlsx');
            }
        }
        // Detailed report
        else if($report_name == 5) {
            // Sales
            if ($table_id == 1) {
                
                $detailed_sales = Sale::whereBetween('date', [$start_date, $end_date])
                                      ->where('audit_approval', 1)
                                      ->where('management_approval', 1)
                                      ->get();
                    
                return Excel::download(new DailyReportExportDetailSales($detailed_sales, $start_date, $end_date), 'Detailed Sales Report (Daily).xlsx');
            }
            // Sales Return
            else if ($table_id == 2) {
                $detailed_sales_returns = DB::table('sales_returns_products AS SRP')
                 ->select('SR.date', 'C.party_name', 'PT.type AS party_type', 'P.product_name', 'P.product_code', 'PDT.type AS product_type', 'SRP.commission_percentage', 'SRP.price_per_unit AS price', 'SRP.quantity AS quantity', 'SR.amount_after_discount', 'Z.zone')
                 ->join('sales_returns AS SR', 'SR.invoice_no', 'SRP.invoice_no')
                 ->join('parties AS C', 'C.id', 'SR.client_id')
                 ->join('party_types AS PT', 'PT.id', 'C.party_type_id' )
                 ->join('products AS P', 'P.id', 'SRP.product_id')
                 ->join('product_types AS PDT', 'PDT.id', 'P.product_type')
                 ->join('zones AS Z', 'Z.id', 'C.zone')
                 ->where('SR.date', '>=', $start_date)
                 ->where('SR.date', '<=', $end_date)
                 ->where('SR.audit_approval', 1)
                 ->where('SR.management_approval', 1)
                 ->orderBy('SRP.product_id', 'asc')
                 ->orderBy('C.id', 'asc')
                 ->get();

                 return Excel::download(new DailyReportExportDetailSalesReturn($detailed_sales_returns, $start_date, $end_date), 'Detailed Sales Return Report (Daily).xlsx');

            }
            // Payment
            else if ($table_id == 3) {
                $detailed_payment_received = DB::table('payment_receiveds AS PR')
                 ->select('PR.date', 'C.party_name', 'PT.type AS party_type', 'PM.method', 'PR.paid_amount', 'PR.collector', 'PR.cheque_clearing_status')
                 ->join('parties AS C', 'C.id', 'PR.client_code')
                 ->join('party_types AS PT', 'PT.id', 'C.party_type_id')
                 ->join('payment_methods AS PM', 'PM.id', 'PR.payment_mode')
                 ->where('PR.date', '>=', $start_date)
                 ->where('PR.date', '<=', $end_date)
                 ->where('PR.sales_approval', 1)
                 ->where('PR.management_approval', 1)
                 ->orderBy('C.id', 'asc')
                 ->get();

                 return Excel::download(new DailyReportExportDetailPay($detailed_payment_received, $start_date, $end_date), 'Detailed Payment Received Report (Daily).xlsx');

            }
            else if ($table_id == 4) {

                echo "<script type='text/javascript'>alert('No detailed report for commission!');</script>";
            }
            else if ($table_id == 5) {
                $number_of_invoices = DB::table('sales AS S')
                    ->select(DB::raw('DAY(S.date) as day'), DB::raw('MONTH(S.date) as month'), DB::raw('YEAR(S.date) as year'), DB::raw('count(*) as count'))
                    ->whereDate('S.date', '>=', $start_date)
                    ->whereDate('S.date', '<=', $end_date)
                    ->where('audit_approval', 1)
                    ->where('management_approval', 1)
                    ->groupBy('day', 'month', 'year')
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->orderBy('day', 'asc')
                    ->get();

                return Excel::download(new DailyReportExportDetailInv($number_of_invoices, $start_date, $end_date), 'Detailed Invoices (Daily).xlsx');

                
            }
            // Collection
            else if ($table_id == 6) {
                $detailed_payment_received = DB::table('payment_receiveds AS PR')
                 ->select('PR.date', 'C.party_name', 'PT.type AS party_type', 'PM.method', 'PR.paid_amount', 'PR.collector', 'PR.cheque_clearing_status')
                 ->join('parties AS C', 'C.id', 'PR.client_code')
                 ->join('party_types AS PT', 'PT.id', 'C.party_type_id')
                 ->join('payment_methods AS PM', 'PM.id', 'PR.payment_mode')
                 ->where('PR.date', '>=', $start_date)
                 ->where('PR.date', '<=', $end_date)
                 ->where('PR.sales_approval', 1)
                 ->where('PR.management_approval', 1)
                 ->orderBy('C.id', 'asc')
                 ->get();

                 return Excel::download(new DailyReportExportDetailPay($detailed_payment_received, $start_date, $end_date), 'Detailed Collection Report (Daily).xlsx');
            }
            // Discount
            else if ($table_id == 7) {
                $detailed_discount = Sale::select('date', 'client_id', 'invoice_no', 'total_sales', 'amount_after_discount')
                 ->where('date', '>=', $start_date)
                 ->where('date', '<=', $end_date)
                 ->where('audit_approval', 1)
                 ->where('management_approval', 1)
                 ->orderBy('date', 'asc')
                 ->get();

                 return Excel::download(new DailyReportExportDetailDiscount($detailed_discount, $start_date, $end_date), 'Detailed Discount Report (Daily).xlsx');
            }
            else {
                // Do nothing
            }
        }
        else {
            // Do nothing
        }
    }

    public function monthlyReportGenerator(Request $request)
    {
        $start_month = $request->start_month;
        $start_year = $request->start_year;

        $end_month = $request->end_month;
        $end_year = $request->end_year;

        $start_date = $start_year . '-' . $start_month . '-01';
        $end_date = $end_year . '-' . $end_month . '-01';
        
        $table_id = $request->table_id; // Report Category
        $report_name = $request->report_name; // Report Name

        if ($report_name == 1) {
            echo 'Client Report';

            if ($table_id == 1) {
                echo '->Sales';
            }
            else if ($table_id == 2) {
                echo '->Sales Return';
            }
            else if ($table_id == 3) {
                echo '->Payment';
            }
            else if ($table_id == 4) {
                echo '->Commission';
            }
            else if ($table_id == 5) {
                echo '->Number of invoices';
            }
            else if ($table_id == 6) {
                echo '->Collection';
            }
            else {
                // Do nothing
            }
        }
        else if($report_name == 2) {
            echo 'Sales Person Report';

            if ($table_id == 1) {
                echo '->Sales';
            }
            else if ($table_id == 2) {
                echo '->Sales Return';
            }
            else if ($table_id == 3) {
                echo '->Payment';
            }
            else if ($table_id == 4) {
                echo '->Commission';
            }
            else if ($table_id == 5) {
                echo '->Number of invoices';
            }
            else if ($table_id == 6) {
                echo '->Collection';
            }
            else {
                // Do nothing
            }
        }
        else if($report_name == 3) {
            echo 'Collection Person Report';

            if ($table_id == 1) {
                echo '->Sales';
            }
            else if ($table_id == 2) {
                echo '->Sales Return';
            }
            else if ($table_id == 3) {
                echo '->Payment';
            }
            else if ($table_id == 4) {
                echo '->Commission';
            }
            else if ($table_id == 5) {
                echo '->Number of invoices';
            }
            else if ($table_id == 6) {
                echo '->Collection';
            }
            else {
                // Do nothing
            }
        }
        else if($report_name == 4) {
            echo 'Due Report';

            if ($table_id == 1) {
                echo '->Sales';
            }
            else if ($table_id == 2) {
                echo '->Sales Return';
            }
            else if ($table_id == 3) {
                echo '->Payment';
            }
            else if ($table_id == 4) {
                echo '->Commission';
            }
            else if ($table_id == 5) {
                echo '->Number of invoices';
            }
            else if ($table_id == 6) {
                echo '->Collection';
            }
            else {
                // Do nothing
            }
        }
        else if($report_name == 5) {
            // echo 'Detailed Report';

            if ($table_id == 1) {
                // echo '->Sales';

                $detailed_sales_monthly = DB::table('sales_products AS SP')
                 ->selectRaw('C.party_name, PT.type AS party_type, P.product_code, P.product_name, P.brand, PDT.type AS product_type, SP.commission_percentage, Z.zone, SP.quantity, SP.price_per_unit, MONTH(S.date) AS month_number, YEAR(S.date) AS year, (SP.quantity * SP.price_per_unit) AS amount, S.date, S.invoice_no, S.present_sr_id')
                 ->join('sales AS S', 'SP.invoice_no', 'S.invoice_no')
                 ->join('parties AS C', 'C.id', 'S.client_id')
                 ->join('party_types AS PT', 'C.party_type_id', 'PT.id' )
                 ->join('products AS P', 'P.id' ,  'SP.product_id')
                 ->join('product_types AS PDT', 'PDT.id',  'P.product_type')
                 ->join('zones AS Z', 'Z.id', 'C.zone')
                 ->where('S.audit_approval', 1)
                 ->where('S.management_approval', 1)
                 ->whereMonth('S.date', '>=', $start_month)
                 ->whereMonth('S.date', '<=', $end_month)
                 ->whereYear('S.date', '>=', $start_year)
                 ->whereYear('S.date', '<=', $end_year)
                 ->orderBy('C.id', 'asc')
                 ->orderBy('SP.product_id', 'asc')
                 ->get();

                 return Excel::download(new MonthlyReportExportDetailSales($detailed_sales_monthly, $start_month, $start_year, $end_month, $end_year, $start_date, $end_date), 'Detailed Sales Report(Monthly).xlsx');

            }
            else if ($table_id == 2) {
                // echo '->Sales Return';

                $detailed_sales_return_monthly = DB::table('sales_returns_products AS SRP')
                 ->selectRaw('C.party_name, PT.type AS party_type, P.product_code, P.product_name, PDT.type AS product_type, SRP.commission_percentage, Z.zone, SRP.quantity, SRP.price_per_unit, MONTH(SR.date) AS month_number, (SRP.quantity * SRP.price_per_unit) AS amount')
                 ->join('sales_returns AS SR', 'SRP.invoice_no', 'SR.invoice_no')
                 ->join('parties AS C', 'C.id', 'SR.client_id')
                 ->join('party_types AS PT', 'C.party_type_id', 'PT.id')
                 ->join('products AS P', 'P.id' ,  'SRP.product_id')
                 ->join('product_types AS PDT', 'PDT.id', 'P.product_type')
                 ->join('zones AS Z', 'Z.id', 'C.zone')
                 ->where('SR.audit_approval', 1)
                 ->where('SR.management_approval', 1)
                 ->whereMonth('SR.date', '>=', $start_month)
                 ->whereMonth('SR.date', '<=', $end_month)
                 ->whereYear('SR.date', '>=', $start_year)
                 ->whereYear('SR.date', '<=', $end_year)
                 ->orderBy('C.id', 'asc')
                 ->orderBy('SRP.product_id', 'asc')
                 ->get();

                 return Excel::download(new MonthlyReportExportDetailSalesReturns($detailed_sales_return_monthly, $start_month, $start_year, $end_month, $end_year, $start_date, $end_date), 'Detailed Sales Returns Report(Monthly).xlsx');
            }
            else if ($table_id == 3) {
                // echo '->Payment';

                $detailed_payment_monthly = DB::table('payment_receiveds AS PR')
                 ->selectRaw('PR.date, PR.total_received, C.party_name, PT.type AS party_type, PR.collector, Z.zone, MONTH(PR.date) AS month_number')
                 ->join('parties AS C', 'C.id', 'PR.client_code')
                 ->join('party_types AS PT', 'C.party_type_id', 'PT.id')
                 ->join('zones AS Z', 'Z.id', 'C.zone')
                 ->where('PR.sales_approval', 1)
                 ->where('PR.management_approval', 1)
                 ->whereMonth('PR.date', '>=', $start_month)
                 ->whereMonth('PR.date', '<=', $end_month)
                 ->whereYear('PR.date', '>=', $start_year)
                 ->whereYear('PR.date', '<=', $end_year)
                 ->get();

                 return Excel::download(new MonthlyReportExportDetailPayment($detailed_payment_monthly, $start_month, $start_year, $end_month, $end_year, $start_date, $end_date), 'Detailed Payment Report(Monthly).xlsx');
            }
            else if ($table_id == 4) {
                echo '->Commission';
            }
            else if ($table_id == 5) {
                $number_of_invoices = DB::table('sales AS S')
                    ->select(DB::raw('MONTH(S.date) as month'), DB::raw('YEAR(S.date) as year'), DB::raw('count(*) as count'))
                    ->whereDate('S.date', '>=', $start_date)
                    ->whereDate('S.date', '<=', $end_date)
                    ->where('audit_approval', 1)
                    ->where('management_approval', 1)
                    ->groupBy('month', 'year')
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->get();


                return Excel::download(new MonthlyReportExportDetailInv($number_of_invoices, $start_month, $start_year, $end_month, $end_year, $start_date, $end_date), 'Detailed Invoices (Monthly).xlsx');
            }
            else if ($table_id == 6) {
                // echo '->Collection';

                $detailed_payment_monthly = DB::table('payment_receiveds AS PR')
                 ->selectRaw('PR.date, PR.total_received, C.party_name, PT.type AS party_type, PR.collector, Z.zone, MONTH(PR.date) AS month_number')
                 ->join('parties AS C', 'C.id', 'PR.client_code')
                 ->join('party_types AS PT', 'C.party_type_id', 'PT.id')
                 ->join('zones AS Z', 'Z.id', 'C.zone')
                 ->where('PR.sales_approval', 1)
                 ->where('PR.management_approval', 1)
                 ->whereMonth('PR.date', '>=', $start_month)
                 ->whereMonth('PR.date', '<=', $end_month)
                 ->whereYear('PR.date', '>=', $start_year)
                 ->whereYear('PR.date', '<=', $end_year)
                 ->get();

                 return Excel::download(new MonthlyReportExportDetailPayment($detailed_payment_monthly, $start_month, $start_year, $end_month, $end_year, $start_date, $end_date), 'Detailed Collection Report(Monthly).xlsx');
            }
            else {
                // Do nothing
            }
        }
        else {
            // Do nothing
        }
    }

    public function monthlyStatement()
    {
        $clients = Party::all();

        return view('reports.excel.statement.index')
            ->with('clients', $clients);
    }

    public function monthlyStatementGenerator(Request $request)
    {
        $start_date = $request->start_date;
        $end_date   = $request->end_date;
        $party_id   = $request->party_id;

        $client_profile = Party::find($party_id);
        $client_name    = $client_profile->party_name;
        $client_code    = $client_profile->party_id;
        $statement_id   = 'ODS_' . \Carbon\Carbon::now()->format('ymdHis');

        $sales = DB::table('sales AS S')
                    ->where('S.client_id', $party_id)
                    ->where('S.date', '>=', $start_date)
                    ->where('S.date', '<=', $end_date)
                    ->where('S.audit_approval', 1)
                    ->where('S.management_approval', 1)
                    ->get();

        $returns = DB::table('sales_returns AS SR')
                    ->where('SR.client_id', $party_id)
                    ->where('SR.date', '>=', $start_date)
                    ->where('SR.date', '<=', $end_date)
                    ->where('SR.audit_approval', 1)
                    ->where('SR.management_approval', 1)
                    ->get();

        $collections = DB::table('payment_receiveds AS PR')
                        ->where('PR.client_code', $party_id)
                        ->where('PR.cheque_clearing_status', '!=', 'Due')
                        ->where('PR.date', '>=', $start_date)
                        ->where('PR.date', '<=', $end_date)
                        ->where('PR.sales_approval', 1)
                        ->where('PR.management_approval', 1)
                        ->get();

        $adjustments = DB::table('adjusted_balances')
                        ->where('client_id', $party_id)
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->where('sales_approval', 1)
                        ->where('management_approval', 1)
                        ->where('warehouse_approval', 1)
                        ->get();

        $balance =  $returns->sum('amount_after_discount') + 
                    $collections->sum('paid_amount') - 
                    $sales->sum('amount_after_discount') - 
                    (float)$sales->sum('amount_after_vat_and_discount') + 
                    $adjustments->sum('amount');

        $overall_balance = $client_profile->getOverallBalance();

        return view('reports.excel.statement.showMonthlyStatement')
            ->with('sales', $sales)
            ->with('returns', $returns)
            ->with('collections', $collections)
            ->with('adjustments', $adjustments)
            ->with('client_name', $client_name)
            ->with('client_code', $client_code)
            ->with('client_profile', $client_profile)
            ->with('statement_id', $statement_id)
            ->with('balance', $balance)
            ->with('overall_balance', $overall_balance);
    }

    public function monthlyStatementAllClients(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $begin = new DateTime(''.$year.'-'.$month.'-01');
        $end = new DateTime(''.$year.'-'.$month.'-'.$days.'');
        $end = $end->modify( '+1 day' ); 
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($begin, $interval, $end);  

        $clients = Party::all();

        return Excel::download(new MonthlyReportExportAllClients($clients, $period), 'Monthly Report All Clients.xlsx');
    }

    public function inventoryReportGenerator()
    {
        $inventories = DB::table('inventories AS I')
                        ->select('P.product_code', 'P.product_name', 'P.brand', 'P.product_type', 'I.expiry_date', 'I.batch_code', 'P.case_size', 'I.quantity', 'I.cost', 'I.wholesale_rate', 'I.mrp')
                        ->join('products AS P', 'P.id', 'I.product_id')
                        ->where('I.audit_approval', 1)
                        ->where('I.management_approval', 1)
                        ->get();

        return Excel::download(new InventoryReportExport($inventories), 'Inventory Report.xlsx');
    }

    public function dueReportGenerator()
    {
        $parties = Party::all();

        return Excel::download(new DueReportExport($parties), 'Due Report.xlsx');
    }
}