<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function show()
    {
        $data_order = order::join('customers', 'order.id_customers', 'customers.id_customers')->join('product', 'order.id_product', 'product.id_product')->get();
        return Response()->json($data_order);
    }
    public function detail($id)
    {
        if(order::where('id_order', $id)->exists()){
            $data_order = order::join('customers', 'order.id_customers', 'customers.id_customers')->join('product', 'order.id_product', 'product.id_product')
                                        ->where('order.id_order', '=', $id)
                                        ->get();
            return Response()->json($data_order);
    }
    else{
        return Response()->(['message'=>'Tidak ditemukan']);
    }
    }
    public function store(Request $request){
    	$validator=Validator::make($request->all(),
    		[
    			'id_customers' => 'required',
    			'id_product' => 'required'
    		]
    );

    	if ($validator->fails()) {
    		return Response()->json($validator->errors());
    	}

    	$simpan = Orders::create([
    		'id_customers' => $request->id_customers,
    		'id_product' => $request->id_product
    	]);

    	if ($simpan) {
    		return Response()->json(['status'=>1]);
    	}
    	else {
    		return Response()->json(['status'=>0]);
    	}
    }
}
