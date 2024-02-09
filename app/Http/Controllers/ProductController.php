<?php

namespace App\Http\Controllers;

use App\Jobs\ProductLiked;
use App\Models\Product;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function like($productId,Request $request)
    {
        $response = \Http::get('http://host.docker.internal:8000/api/get-user-random');
        $user =  $response->json();

        try {
            $productUser = ProductUser::query()->create([
                'user_id' => $user['id'],
                'product_id' => $productId,
            ]);

            ProductLiked::dispatch($productUser->toArray())->onQueue('admin_queue');

            return response([
                'message' => 'success'
            ]);
        }catch (\Exception $e){
            return response([
                'error' => 'You already liked this product'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
