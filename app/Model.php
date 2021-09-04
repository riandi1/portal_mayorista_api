<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Watson\Validating\ValidatingTrait;

class Model extends BaseModel
{
    use SoftDeletes, SearchableTrait, ValidatingTrait;

    protected $relationships = [];

    private $searchable = [];
    protected $merge_fillable_searchables = true;

    protected $searchables_columns = [
        'id' => 1
    ];
    protected $searchables_joins = [];

    protected $rules = [];
    protected $dates = [];

    protected static $prefix = null;
    protected static $display_key = null;

    public function __construct(array $attributes = [])
    {
        $this->dates[] = 'deleted_at';
        if ($this->merge_fillable_searchables) {
            $filable_parsed = [];
            foreach ($this->fillable as $fillable)
                $filable_parsed[$fillable] = 10;
            $this->searchables_columns = array_merge($filable_parsed, $this->searchables_columns);
        }
        $this->searchable = [
            "columns" => $this->searchables_columns,
            "joins" => $this->searchables_joins
        ];
        parent::__construct($attributes);
    }

    public static function primaryKey()
    {
        return (new static)->getKeyName();
    }

    public static function basename()
    {
        return class_basename(static::class);
    }

    public static function prefix()
    {
        return static::$prefix ?: static::basename();
    }


    public static function displayKey()
    {
        return static::$display_key ?: static::primaryKey();
    }


    public static function withAll()
    {
        return parent::with((new static)->relationships);
    }

    public static function ls($search = null, $sort = null, $show_deleted = false)
    {
        $query = static::withAll();

        if (!is_null($search))
            $query = $query->search($search);

//        if ($show_deleted) // TODO fix!
//            $query = $query->withTrashed();

        if (!is_null($sort) && is_array($sort) && array_has($sort, ['column', 'direction']))
            $query = $query->orderBy($sort['column'], $sort['direction']);

        return $query;
    }

    public function binnacle()
    {
        return $this->morphMany('App\Models\System\Binnacle', 'target');
    }

//    public static function validate($input)
//    {
//        $validator = Validator::make($input, self::$rules);
//        if ($validator->fails())
//            return $validator->errors();
//        return true;
//    }
//
//    public static function validateOrFail($input)
//    {
//        $validator = Validator::make($input, self::$rules);
//        if ($validator->fails())
//            throw new ValidationException($validator, jsend_fail($validator->errors()->toArray()));
//        return true;
//    }
}
