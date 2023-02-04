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

    public function add()
    {
        DB::insert('INSERT INTO () VALUES(?,?,?)', ['']);
        return response()->json([DB::getPdo()->lastInsertId()]);
    }

    public function edit()
    {
    }

    public function delete()
    {
    }
}
