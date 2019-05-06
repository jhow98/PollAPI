<?php

namespace Api\Http\Controllers\Api;

use Illuminate\Http\Request;
use Api\Http\Controllers\Controller;
use Api\API\ApiError;
use Api\Product;

class ProductController extends Controller
{
    private $product;


    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function index()
    {

        return response()->json($this->product->paginate(5));
    }

    public function show($id)
    {
        $product = $this->product->find($id);

        if(! $product) return response()->json(ApiError::errorMessage('Produto não encontrado!', 4040), 404);
        $data = ['data' => $product];
        return response()->json($data);
    }


    public function store(Request $request)
    {

        try {
            $productData = $request->all();
            $p = $this->product->create($productData);

            $return = ['data' => ['msg' => 'Produto criado com sucesso!']];
            return response()->json($return, 201)->header('Location', 'product/' . $p->id);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 500));
            }
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar a operação!', 500));
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $productData = $request->all();
            $product = $this->product->find($id);
            $product->update($productData);

            $return = ['data' => ['msg' => 'Produto atualizado com sucesso!']];
            return response()->json($return, 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 500));
            }
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar a operação!', 500));
        }
    }

    public function delete(Product $id)
    {

        try {
            $id->delete();
            return response()->json(['data' => ['msg' => 'Produto ' . $id->name . ' excluído.']], 200);
         } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 500));
            }
            return response()->json(ApiError::errorMessage('Houve um erro ao excluir!', 500));
        }
    }
}