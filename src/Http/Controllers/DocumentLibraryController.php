<?php

namespace Okorpheus\DocumentLibrary\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Okorpheus\DocumentLibrary\Actions\CreateDirectory;
use Okorpheus\DocumentLibrary\Enums\VisibilityValues;
use Okorpheus\DocumentLibrary\Http\Requests\StoreDirectoryRequest;
use Okorpheus\DocumentLibrary\Models\Directory;
use Okorpheus\DocumentLibrary\Models\Document;

class DocumentLibraryController extends Controller
{
    use AuthorizesRequests;

    public function index(?Directory $directory)
    {

        if ($directory->exists === true) {
            $directories = Directory::where('parent_id',$directory->id)->orderBy('sort_order')->orderBy('name')->get();
            $documents = Document::where('parent_id', $directory->id)->orderBy('sort_order')->orderBy('name')->get();
            $parentLink = $directory->parent ?
                route('document-library.directory', $directory->parent) :
                route('document-library.index');
            $fullPath = $this->pathWithLinks($directory);
            $currentDirectory = $directory;
            $canCreateDocumentsWithinDirectory = auth()->user()->can('create', [Document::class, $directory]);
            $canCreateDirectoriesWithinDirectory = auth()->user()->can('create', [Directory::class, $directory]);
        } else {
            $directories = Directory::whereNull('parent_id')->orderBy('sort_order')->orderBy('name')->get();
            $documents = Document::whereNull('parent_id')->orderBy('sort_order')->orderBy('name')->get();
            $parentLink = false;
            $fullPath = false;
            $currentDirectory = false;
            $canCreateDocumentsWithinDirectory = auth()->user()->can('create', [Document::class]);
            $canCreateDirectoriesWithinDirectory = auth()->user()->can('create', [Directory::class]);
        }

        return view('document-library::index', compact('directories', 'parentLink', 'fullPath', 'currentDirectory', 'documents', 'canCreateDocumentsWithinDirectory', 'canCreateDirectoriesWithinDirectory'));
    }

    public function storeDirectory(StoreDirectoryRequest $request)
    {
        app(CreateDirectory::class)(
            name: $request->validated('name'),
            description: $request->validated('description'),
            visibility: $request->validated('visibility'),
            parentId: $request->validated('parent_id'),
        );

        return redirect()->back();
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

    public function storeFile(Request $request)
    {
        $validated = $request->validate([
            'uploaded-file' => ['required', 'file', 'mimetypes:text/plain,application/pdf'],
            'description' => 'nullable|string',
            'visibility' => ['required', Rule::enum(VisibilityValues::class)],
            'parent_id' => ['nullable', Rule::exists(Directory::class, 'id')],
        ]);
        $name = $validated['uploaded-file']->getClientOriginalName();
        $parent_id = $validated['parent_id'] ?? null;
        $size = $validated['uploaded-file']->getSize();
        $mime_type = $validated['uploaded-file']->getMimeType();
        $user_id = auth()->id();
        $disk = config('documentlibrary.storage_disk');
        $path = $validated['uploaded-file']->store(
            config('documentlibrary.storage_path'),
            $disk
        );

        Document::create([
            'name' => $name,
            'description' => $validated['description'],
            'sort_order' => 1,
            'visibility' => $validated['visibility'],
            'disk' => $disk,
            'disk_path' => $path,
            'parent_id' => $parent_id,
            'size' => $size,
            'mime_type' => $mime_type,
            'user_id' => $user_id,
        ]);

        return redirect()->back();

    }

    public function destroyDirectory(Directory $directory)
    {
        $this->authorize('delete', $directory);

        $directory->delete();
        return redirect()->back()->with('success', 'Directory deleted successfully.');
    }
}
