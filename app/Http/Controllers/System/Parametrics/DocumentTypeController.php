<?php

namespace App\Http\Controllers;

use App\Models\System\Parametrics\DocumentType;
use phpDocumentor\Reflection\Types\Parent_;

class DocumentTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct(DocumentType::class);
    }

}
