<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    //
    public function fetch()
    {
        $result = DB::select('SELECT * FROM inventory');
        return response()->json(['success' => true, 'responsedata' => (array)$result[0]]);
    }
}
