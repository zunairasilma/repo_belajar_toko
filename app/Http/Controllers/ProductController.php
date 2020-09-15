<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function show()
    {
        return product::all();
    }
    public function store(Request $request) {
    	$validator=Validator::make($request->all(),
    		[
    			'nama_product' => 'required'
    		]
    );

    	if ($validator->fails()) {
    		return Response()->json($validator->errors());
    	}

    	$simpan = Product::create([
    		'nama_product' => $request->nama_product
    	]);

    	if ($simpan) {
    		return Response()->json(['status'=>1]);
    	}
    	else {
    		return Response()->json(['status'=>0]);
    	}
    }
    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nama_produk' => 'required'
            ]
        );

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = product::where('id_product', $id)->update([
            'nama_produk' => $request->nama_produk
        ]);

        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    public function destroy($id){
        $hapus = Product::where('id',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>1]);
        }
        else{
            return Response()->json(['status'=>0]);
        }
    }
    }
}

