<?php

namespace Okorpheus\DocumentLibrary\Http\Controllers;

use Illuminate\Routing\Controller;
use Okorpheus\DocumentLibrary\Models\Directory;

class DocumentLibraryController extends Controller
{
    public function index(?Directory $directory)
    {
        if ($directory->exists()) {
            $directories = Directory::where('parent_id',$directory->id)->orderBy('sort_order')->orderBy('name')->get();
        } else {
            $directories = Directory::whereNull('parent_id')->orderBy('sort_order')->orderBy('name')->get();
        }

        return view('document-library::index', compact('directories'));
    }
}
