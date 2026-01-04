<?php

namespace Okorpheus\DocumentLibrary\Http\Controllers;

use Illuminate\Routing\Controller;
use Okorpheus\DocumentLibrary\Models\Directory;

class DocumentLibraryController extends Controller
{
    public function index(?Directory $directory)
    {

        if ($directory->exists === true) {
            $directories = Directory::where('parent_id',$directory->id)->orderBy('sort_order')->orderBy('name')->get();
            $parentLink = $directory->parent ?
                route('document-library.directory', $directory->parent) :
                route('document-library.index');
        } else {
            $directories = Directory::whereNull('parent_id')->orderBy('sort_order')->orderBy('name')->get();
            $parentLink = false;
        }

        return view('document-library::index', compact('directories', 'parentLink'));
    }
}
