<?php

namespace App\Http\Controllers;

use App\Models\System\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function __construct()
    {
        parent::__construct(Email::class);
    }
}
