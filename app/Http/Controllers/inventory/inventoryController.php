<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class InventoryController extends Controller
{
    //
    public function fetch()
    {
        $result = DB::select('SELECT * FROM inventory');
        return response()->json(['success' => true, 'responsedata' => (array)$result[0]]);
    }
    public function add(Request $request)
    {
        $result = DB::insert('INSERT INTO inventory (item_name,item_quantity,merchant_id,category_id) VALUES (?,?,?,?)', [$request->input('item_name'), $request->input('item_quantity'), $request->input('merchant_id'), $request->input('category_id')]);
        if ($result) {
            return response()->json(['success' => true, 'responsedata' => 'successfully added into inventory']);
        }
    }
}
