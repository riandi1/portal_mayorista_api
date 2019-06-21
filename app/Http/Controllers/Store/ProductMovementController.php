<?php

namespace App\Http\Controllers;

use App\Models\Store\ProductMovement;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductMovementController extends Controller
{
    /**
     * ProductMovementController constructor.
     */
    public function __construct()
    {
        parent::__construct(ProductMovement::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        check_permission($this->model::prefix() . '_' . strtoupper($request->get('operation', 'OUTPUT')));
        if ($request->has('products'))
            return $this->store_mass($request);
        else
            return parent::store($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function store_mass(Request $request)
    {
        $products = $request->get('products');
        check_permission($this->model::prefix() . '_MASS');
        if (!is_array($products))
            throw new BadRequestHttpException(trans('messages.request.errors.bad'));

        $responses = [];
        $request->request->remove('products');
        foreach ($products as $product) {
            $request->merge([
                'operation' => strtoupper($request->get('operation', 'OUTPUT')),
                'product_id' => $product['id'],
                'quantity' => array_get($product, 'quantity', null),
                'details' => json_encode(array_get($product, 'details', null))
            ]);
            $responses[] = parent::store($request)->getData(true);
        }
        return jsend_success($responses, 201, trans('messages.models.mass', ['model' => $this->model::basename()]));
    }
}
