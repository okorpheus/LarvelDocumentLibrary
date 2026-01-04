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
            $fullPath = $this->pathWithLinks($directory);
        } else {
            $directories = Directory::whereNull('parent_id')->orderBy('sort_order')->orderBy('name')->get();
            $parentLink = false;
            $fullPath = false;
        }

        return view('document-library::index', compact('directories', 'parentLink', 'fullPath'));
    }

    private function pathWithLinks(Directory $directory): array
    {
        $breadcrumbs = [];

        // Add current directory
        $breadcrumbs[] = [
            'name' => $directory->name,
            'link' => route('document-library.directory', $directory)
        ];

        // Walk up the tree, adding parents to the beginning
        $current = $directory;
        while ($current->parent) {
            array_unshift($breadcrumbs, [
                'name' => $current->parent->name,
                'link' => route('document-library.directory', $current->parent)
            ]);
            $current = $current->parent;
        }

        // Add root "Document Library" link at the beginning
        array_unshift($breadcrumbs, [
            'name' => 'Document Library',
            'link' => route('document-library.index'),
        ]);

        return $breadcrumbs;
    }
}
