<?php

namespace App\Http\Controllers;

use App\Models\Cms\Page;
use App\Models\Cms\PageVar;
use Illuminate\Routing\Controller as BaseController;


class CmsController extends BaseController
{
    public function __construct()
    {
    }

    public function globals()
    {
        $globals = PageVar::query()->whereNull('page_id')->get();
        return jsend_success($globals);
    }

    public function pages($page_name = null)
    {
        if (!is_null($page_name)) {
            $result = Page::with('vars')->where('name', '=', $page_name)->first();
            if (is_null($result))
                return jsend_error("Page '$page_name' not exist!");
        } else $result = Page::with('vars')->get();
        return jsend_success($result);
    }

    public function var($page_name, $var_name)
    {
        $page = Page::query()->where('name', '=', $page_name)->first();
        if (!$page)
            return jsend_error("Page '$page_name' not exist!", 404);

        $var = PageVar::query()
            ->where('page_id', '=', $page->id)
            ->where('name', '=', $var_name)
            ->first();
        if (is_null($var))
            return jsend_error("Variable '$var_name' not exist in page '$page_name'", 404);
        return jsend_success($var);
    }
}
