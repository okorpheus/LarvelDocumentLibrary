<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full">

@if($errors->any())
    @foreach($errors->all() as $error)

        <div class="bg-red-200 border-red-600 text-red-600 border-l-4 p-4" role="alert">
            <p class="font-bold">
                Form Error
            </p>
            <p>
                {{ $error }}
            </p>
        </div>

    @endforeach
@endif

<div x-data="{
    showAddDirectoryForm: false,
    showFileUploadForm: false,
    showEditDirectoryForm: false,
    editDirectory: { id: null, name: '', description: '', visibility: '' },
    editDirectoryAction: '',
    openEditDirectory(id, name, description, visibility) {
        this.editDirectory = { id, name, description: description || '', visibility };
        this.editDirectoryAction = '{{ url('document-library/directory') }}/' + id;
        this.showEditDirectoryForm = true;
    }
}">
    @include('document-library::add-directory-modal')
    @include('document-library::upload-file-modal')
    @include('document-library::edit-directory-modal')
    <div class="py-10">
        <header>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Document Library</h1>
                    @auth
                        <div class="flex gap-3">
                            @if($canCreateDirectoriesWithinDirectory)

                                <button
                                    type="button"
                                    @click="showAddDirectoryForm = true"
                                    class="py-2 px-4 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">
                                    Add Directory
                                </button>
                            @endif
                            @if($canCreateDocumentsWithinDirectory)
                                <button
                                    type="button"
                                    @click="showFileUploadForm = true"
                                    class="py-2 px-4 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">
                                    Upload File
                                </button>
                            @endif
                        </div>
                    @endauth
                </div>
                @if($fullPath)
                    <div class="mt-3">
                        @foreach($fullPath as $pathItem)
                            <a href="{{$pathItem['link']}}" class="underline hover:text-blue-600">
                                {{ $pathItem['name'] }}
                            </a>
                            @unless($loop->last)
                                ->
                            @endunless
                        @endforeach
                    </div>
                @endif
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="py-2">
                    <div class="px-4 py-4 -mx-4 overflow-x-auto sm:-mx-8 sm:px-8">
                        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
                            <table class="min-w-full leading-normal">
                                <thead>
                                <tr>
                                    <x-document-library::file-list-th>

                                    </x-document-library::file-list-th>
                                    <x-document-library::file-list-th>
                                        Name
                                    </x-document-library::file-list-th>
                                    <x-document-library::file-list-th>
                                        Visibility
                                    </x-document-library::file-list-th>
                                    <x-document-library::file-list-th>
                                        Size
                                    </x-document-library::file-list-th>
                                    <x-document-library::file-list-th>
                                        Owner
                                    </x-document-library::file-list-th>
                                    <x-document-library::file-list-th>
                                        Created
                                    </x-document-library::file-list-th>
                                    <x-document-library::file-list-th>
                                        Modified
                                    </x-document-library::file-list-th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($parentLink)
                                    <tr>
                                        <x-document-library::file-list-td colspan="7">
                                            <a href="{{ $parentLink }}" class="flex items-center gap-2">
                                                <x-heroicon-o-folder class="w-5 h-5 text-blue-500"/>
                                                Parent Directory
                                            </a>
                                        </x-document-library::file-list-td>
                                    </tr>
                                @endif
                                @foreach($directories as $directory)
                                    <tr>
                                        <x-document-library::file-list-td>
                                            <div class="flex gap-2">
                                                @can('delete', $directory)
                                                    <form method="POST"
                                                          action="{{ route('document-library.directory.destroy', $directory) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">
                                                            <x-heroicon-o-trash
                                                                class="w-5 h-5 text-red-500 cursor-pointer"/>
                                                        </button>
                                                    </form>
                                                @endcan

                                                @can('update', $directory)
                                                    <button type="button"
                                                            @click="openEditDirectory({{ $directory->id }}, '{{ addslashes($directory->name) }}', '{{ addslashes($directory->description) }}', '{{ $directory->visibility->value }}')">
                                                        <x-heroicon-o-pencil-square
                                                            class="w-5 h-5 text-blue-500 cursor-pointer"/>
                                                    </button>
                                                @endcan
                                            </div>
                                        </x-document-library::file-list-td>
                                        <x-document-library::file-list-td>

                                            <a href="{{ route('document-library.directory', $directory) }}"
                                               class="underline hover:text-blue-600 flex items-center gap-2">
                                                <x-heroicon-o-folder class="w-5 h-5 text-blue-500"/>
                                                {{ $directory->name }}
                                            </a>
                                        </x-document-library::file-list-td>

                                        <x-document-library::file-list-td>
                                            {{ $directory->visibility }}
                                        </x-document-library::file-list-td>

                                        <x-document-library::file-list-td>
                                            ---
                                        </x-document-library::file-list-td>

                                        <x-document-library::file-list-td>
                                            {{ $directory->user->email ?? '' }}
                                        </x-document-library::file-list-td>

                                        <x-document-library::file-list-td>
                                            {{ $directory->created_at->format('m/d/Y H:i:s') }}
                                        </x-document-library::file-list-td>

                                        <x-document-library::file-list-td>
                                            {{ $directory->updated_at->format('m/d/Y H:i:s') }}
                                        </x-document-library::file-list-td>

                                    </tr>
                                @endforeach
                                @foreach($documents as $document)
                                    <tr>
                                        <x-document-library::file-list-td>
                                            @can('delete', $document)
                                                <form method="POST"
                                                      action="{{ route('document-library.document.destroy', $document) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">
                                                        <x-heroicon-o-trash
                                                            class="w-5 h-5 text-red-500 cursor-pointer"/>
                                                    </button>
                                                </form>
                                            @endcan
                                        </x-document-library::file-list-td>
                                        <x-document-library::file-list-td>
                                            <a href="{{ $document->downloadUrl() }}" download="{{ $document->name }}"
                                               class="underline hover:text-blue-600">
                                                {{ $document->name }}
                                            </a>
                                        </x-document-library::file-list-td>
                                        <x-document-library::file-list-td>
                                            {{ $document->visibility }}
                                        </x-document-library::file-list-td>
                                        <x-document-library::file-list-td>
                                            {{ $document->readableSize() }}
                                        </x-document-library::file-list-td>
                                        <x-document-library::file-list-td>
                                            {{ $document->user->email ?? '' }}
                                        </x-document-library::file-list-td>
                                        <x-document-library::file-list-td>
                                            {{ $document->created_at->format('m/d/Y H:i:s') }}
                                        </x-document-library::file-list-td>

                                        <x-document-library::file-list-td>
                                            {{ $document->updated_at->format('m/d/Y H:i:s') }}
                                        </x-document-library::file-list-td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
