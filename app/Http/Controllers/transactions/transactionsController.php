<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    //
    public function fetch()
    {
        $results =  DB::select('SELECT * FROM transactions');
        return response()->json(['success' => true, 'responsedata' => (array) $results]);
    }

    public function add(Request $request)
    {
        DB::insert('INSERT INTO transactions (transaction,items_array,transaction_total,merchant_id) VALUES(?,?,?,?)', [$request->input('transaction'), $request->input('items_array'), $request->input('transaction_total'), $request->input('merchant_id')]);
        return response()->json([DB::getPdo()->lastInsertId()]);
    }

    public function edit()
    {
    }

    public function delete()
    {
    }
}
