<?php

namespace Okorpheus\DocumentLibrary\Http\Controllers;

use Illuminate\Routing\Controller;

class DocumentLibraryController extends Controller
{
    public function public()
    {
        return view('document-library::public');
    }
}
