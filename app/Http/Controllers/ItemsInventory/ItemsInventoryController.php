<?php

namespace App\Http\Controllers\ItemsInventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Logs\LogsController;
use App\Http\Controllers\Products\ProductsController;

class ItemsInventoryController extends Controller
{
    //
    public function fetch()
    {
        $result = DB::select('SELECT * FROM inventory');

        foreach ($result as $res) {
            $res->item_name = (new ProductsController())->fetchSingleProduct($res->item_id)['product_name'];
        }
        return response()->json(['success' => true, 'responsedata' => (array)$result]);
    }
    public function add(Request $request)
    {
        $inventory = DB::select('SELECT * FROM inventory WHERE item_id = ?', [$request->input('item_id')]);
        
        if (count($inventory) > 0) {
            $query = DB::update('UPDATE inventory SET item_quantity=item_quantity + ? WHERE item_id = ?', [$request->input('item_quantity'), $request->input('item_id')]);
        } else {
            $query = DB::insert('INSERT INTO inventory (item_id,item_quantity,merchant_id,category_id) VALUES (?,?,?,?)', [$request->input('item_id'), $request->input('item_quantity'), $request->input('merchant_id'), $request->input('category_id')]);
        }

        if ($query) {
            $log_id = (new LogsController())->add(['user_id' => $request->input('merchant_id'), 'log_details' => 'added new inventory item', 'id' => DB::getPdo()->lastInsertId(), 'table' => 'inventory']);
            $array_response = ['success' => true, 'responsedata' => 'successfully updated inventory', 'log_id' => $log_id['log_id']];
            return response()->json($array_response);
        }
    }
    public function edit()
    {
    }
}
