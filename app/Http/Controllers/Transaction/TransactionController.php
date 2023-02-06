<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\LogsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //
    public function fetch()
    {
        $results =  DB::select('SELECT * FROM transactions');
        return response()->json(['success' => true, 'responsedata' => (array) $results]);
    }

    public function add(Request $request)
    {
        DB::insert('INSERT INTO transactions (transaction,items_array,transaction_total,merchant_id) VALUES(?,?,?,?)', [$request->input('transaction'), json_encode($request->input('items_array')), $request->input('transaction_total'), $request->input('merchant_id')]);
        (new LogsController())->add(['user_id' => 1, 'log_details' => 'added new transaction', 'id' => DB::getPdo()->lastInsertId(), 'table' => 'transactions']);
        return response()->json(['success' => true, 'response_row_id' => DB::getPdo()->lastInsertId()]);
    }

    public function edit()
    {
    }

    public function delete()
    {
    }
}
