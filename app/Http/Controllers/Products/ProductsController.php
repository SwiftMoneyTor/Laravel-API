<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
class ProductsController extends Controller
{
    //
    public function add(Request $request)
    {
        if ($request->hasFile(key: 'product_image')) {
            $file = $request->file(key: 'product_image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('product_images', $filename, 's3');
        }
        DB::insert('INSERT INTO products (product_name,category_id,product_image) VALUES (?,?,?)', [$request->input('product_name'), $request->input('category_id'), Storage::disk('s3')->url('product_images/' . $filename)]);
        return 'success';
    }
}
