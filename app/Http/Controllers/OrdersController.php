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
        if(Orders::where('id_orders', $id)->exists()){
            $data_orders = Orders::join('customers', 'orders.id_customers', 'customers.id_customers')->join('product', 'orders.id_product', 'product.id_product')
                                        ->where('orders.id_orders', '=', $id)
                                        ->get();
            return Response()->json($data_orders);
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
        public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
            [                
                'id_customers' => 'required',
                'id_product' => 'required',
            ]
        );

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = order::where('id_order', $id)->update([            
            'id_customers' => $request->id_customers,
            'id_product' => $request->id_product,
        ]);

        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
        public function destroy($id){
        $hapus = Orders::where('id',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>1]);
        }
        else{
            return Response()->json(['status'=>0]);
        }
    }
    }
}
