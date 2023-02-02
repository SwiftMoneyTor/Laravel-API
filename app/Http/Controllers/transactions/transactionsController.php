<?php

namespace App\Http\Controllers\transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class transactionsController extends Controller
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
