<?php

namespace App\Http\Controllers;

use App\Models\Model;
use App\Models\Store\Category;
use App\Models\Store\CategoryFeacture;
use App\Models\Store\Plan;
use App\Models\Store\Product;
use App\Models\Store\ProductFeacture;
use App\Models\System\Binnacle;
use App\Models\System\CustomData;
use App\Models\System\Parameter;
use App\Models\System\Parametrics\DocumentType;
use App\Models\System\User;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Model $model
     */
    protected $model;

    /**
     * Controller constructor.
     * @param Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        check_permission($this->model::prefix() . '_INDEX');

        $sort = json_decode($request->get('sort', '{}'), true);
        $search = $request->get('search', null);

        /** @var Builder $query */
        $query = $this->model::ls($search, $sort, $request->get('show_deleted', false));

        // TODO: change for complex queries, implement compatibility with front.
        $wheres = json_decode($request->get('wheres', '[]'), true);
        $this->applyWhere($query, $wheres);

        $pagination = null;
        if ($request->has('paginator')) {
            $paginator = json_decode($request->get('paginator', '{"page":0}'), true);
            if (!isset($paginator['per_page']))
                $paginator['per_page'] = intval(Parameter::byCode('LIST__PER_PAGE') ?: '15');
            $data_paginated = $query->paginate($paginator['per_page'], null, null, $paginator['page']);
            $data = $data_paginated->items();
            $pagination = collect($data_paginated)->except(['data']);
        } else
            $data = $query->get();

        if (count($data) === 0)
            jsend_success($data, 204, '', [], $pagination);
        return jsend_success($data, 200, '', [], $pagination);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        check_permission($this->model::prefix() . '_SHOW');
        $query = $this->model::withAll();
        $item = $query->findOrFail($id);
        return jsend_success($item);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        check_permission($this->model::prefix() . '_STORE');
        /** Rules model fields compounds*/
        if ($this->model::basename()=='Category'){
            if ($count = Category::where([['name', $request->name],['category_id', $request->category_id]])->count())
                return jsend_fail(['The name and category have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='DocumentType'){
            if ($count = DocumentType::where([['name', $request->name],['country_id', $request->category_id]])->count())
                return jsend_fail(['The name and country have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='User'){
            if ($count = User::where([['document_type_id', $request->document_type_id],['document_number', $request->document_number]])->count())
                return jsend_fail(['The number and type document have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='Product'){
            if ($count = Product::where([['name', $request->name],['category_id', $request->category_id]])->count())
                return jsend_fail(['The name and category have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='Plan'){
            if ($count = Plan::where([['value', $request->value],['country_id', $request->country_id]])->count())
                return jsend_fail(['The value and country have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='ProductFeacture'){
            if ($count = ProductFeacture::where([['key', $request->key],['product_id', $request->product_id]])->count())
                return jsend_fail(['The key and product have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='CategoryFeacture'){
            if ($count = CategoryFeacture::where([['key', $request->key],['category_id', $request->category_id]])->count())
                return jsend_fail(['The key and category have already been registered.'], 402, trans("The given data was invalid."));
        }

        $request = $this->saveOrUpdateRequestFiles($request);
        $data = $request->except('__custom_data');
        /** @var Model $record */
        $record = new $this->model($data);
        $record->saveOrFail();
        if ($request->has('__custom_data')) {
            /** @var CustomData $custom_data */
            $custom_data = new CustomData([
                'target_type' => $this->model::basename(),
                'target_id' => $record->id,
                'data' => $request->get('__custom_data', '{}')
            ]);
        }
        Binnacle::write(
            "Store",
            $this->binnacle_messages('store', $record),
            'store',
            $this->model,
            $record->toArray()
        );
        return jsend_success($record->toArray(), 200, trans("messages.models.store", ["model" => $this->model::basename()]));


    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        check_permission($this->model::prefix() . '_UPDATE');
        /** Rules model fields compounds*/
        if ($this->model::basename()=='Category'){
            if ($count = Category::where([['name', $request->name],['category_id', $request->category_id],['id', '<>', $id]])->count())
                return jsend_fail(['The name and category have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='DocumentType'){
            if ($count = DocumentType::where([['name', $request->name],['country_id', $request->category_id],['id', '<>', $id]])->count())
                return jsend_fail(['The name and country have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='User'){
            if ($count = User::where([['document_type_id', $request->document_type_id],['document_number', $request->document_number],['id', '<>', $id]])->count())
                return jsend_fail(['The number and type document have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='Product'){
            if ($count = Product::where([['name', $request->name],['category_id', $request->category_id],['id', '<>', $id]])->count())
                return jsend_fail(['The name and category have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='Plan'){
            if ($count = Plan::where([['value', $request->value],['country_id', $request->country_id],['id', '<>', $id]])->count())
                return jsend_fail(['The value and country have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='ProductFeacture'){
            if ($count = ProductFeacture::where([['key', $request->key],['product_id', $request->product_id],['id', '<>', $id]])->count())
                return jsend_fail(['The key and product have already been registered.'], 402, trans("The given data was invalid."));
        }
        if ($this->model::basename()=='CategoryFeacture'){
            if ($count = CategoryFeacture::where([['key', $request->key],['category_id', $request->category_id],['id', '<>', $id]])->count())
                return jsend_fail(['The key and category have already been registered.'], 402, trans("The given data was invalid."));
        }

        $record = $this->model::findOrFail($id);
        $request = $this->saveOrUpdateRequestFiles($request, $record);
        $record->fill($request->all());
        $record->saveOrFail();
        if ($request->has('__custom_data')) {
            $existing = CustomData::query()
                ->where('target_type', '=', $this->model::basename())
                ->where('target_id', '=', $record->id)
                ->first();
            if (!$existing)
                $existing = new CustomData([
                    'target_type' => $this->model::basename(),
                    'target_id' => $id,
                ]);
            $existing->data = $request->get('__custom_data', '{}');
            $existing->save();
        }
        Binnacle::write(
            "Update",
            $this->binnacle_messages('update', $record),
            'update',
            $this->model,
            $record->toArray()
        );
        return jsend_success($record, 202, trans("messages.models.update", ["model" => $this->model::basename()]));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, $id)
    {
        check_permission($this->model::prefix() . '_DESTROY');
        /** @var Model $record */
        $record = $this->model::findOrFail($id);
        Binnacle::write(
            "Destroy",
            $this->binnacle_messages('destroy', $record),
            'destroy',
            $this->model,
            $record->toArray()
        );
        $record->delete();
        return jsend_success($record, 202, trans("messages.models.destroy", ["model" => $this->model::basename()]));
    }

    /**
     * @param Request $request
     * @return Request
     */
    public function saveOrUpdateRequestFiles(Request $request, $record = null)
    {
        $body = $request->all() ?: [];
        $files = $request->allFiles() ?: [];

        foreach ($files as $key => $file) {
            if (!is_null($record)) {
                $old_filename = $record->getAttribute($key);
                \Storage::disk('public')->delete($old_filename);
            }
            $filename = save_file($file, $this->model::basename() . '-' . $key);
            $body[$key] = $filename ? "/storage/$filename" : null;
        }
        foreach ($body as $key => $value) {
            if (!is_string($value))
                continue;
            if (is_base64_file($value)) {
                $filename = save_base64_file($value, $this->model::basename() . '-' . $key);
                if (!is_null($record)) {
                    $old_filename = $record->getAttribute($key);
                    \Storage::disk('public')->delete($old_filename);
                }
                $body[$key] = $filename ? "/storage/$filename" : null;
            }
        }
        $newRequest = new Request($body);
        return $newRequest;
    }

    private function applyWhere($query, $wheres, $eval_scope = true)
    {
        $permission = SpatiePermission::query()->where('name', 'SYSTEM_OVER_SCOPE')->first();
        if ($eval_scope && !Auth::user()->hasPermissionTo($permission))
            $wheres = array_merge($wheres, $this->wheres_scope());
        $andWheres = [];
        $orWheres = [];
        foreach ($wheres as $where)
            if (isset($where['or']) && $where['or'] === true) $orWheres[] = $where;
            else $andWheres[] = $where;

        foreach ($andWheres as $where)
            $query->where($where['column'], $where['op'], $where['value']);

        if (count($orWheres) > 0)
            $query->where(function ($q) use ($orWheres) {
                foreach ($orWheres as $i => $where) {
                    if ($i === 0) $q->where($where['column'], $where['op'], $where['value']);
                    else $q->orWhere($where['column'], $where['op'], $where['value']);
                }
            });
    }

    protected function wheres_scope(): array
    {
        return [];
    }

    protected function binnacle_messages($action, $object)
    {
        $message = '';
        $model_name = strtolower($this->model::basename());
        $display = $object[$this->model::displayKey()];
        switch ($action) {
            case 'store':
                $message = "The $model_name $display was created.";
                break;
            case 'update':
                $message = "The $model_name $display was updated.";
                break;
            case 'destroy':
                $message = "$model_name $display was removed.";
                break;

        }
        return $message;
    }
}
