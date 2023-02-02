<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class inventoryController extends Controller
{
    //
    public function fetch()
    {
        $result = DB::select('SELECT * FROM inventory');
        return response()->json(['success' => true, 'responsedata' => (array)$result[0]]);
    }
}
