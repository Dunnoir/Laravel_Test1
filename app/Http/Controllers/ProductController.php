<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        if($products->count()>0){
            return response()->json([
                'status' => 200,
                'products' => $products
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No se encontraron productos'
            ], 404);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'brand_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 420,
                'message' => $validator->messages()
            ], 420);
        }else{

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'brand_id' => $request->brand_id,
            ]);
        }

        if($product){
            return response()->json([
                'status' => 200,
                'message' => '¡Producto registrado con éxito!'
            ], 200);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Ha ocurrido un error'
            ], 500);
        }
    }

    public function show($id){
        $product = Product::find($id);
        if($product){
            return response()->json([
                'status' => 200,
                'products' => $product
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No se encontraron productos'
            ], 404);
        }
    }
}
