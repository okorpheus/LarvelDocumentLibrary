<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document Library - Public View</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
<div class="py-10">
    <header>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Document Library</h1>
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
                                <th scope="col"
                                    class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                    Visibility
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                    Size
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                    Owner
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                    Created
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-sm font-normal text-left text-gray-800 uppercase bg-white border-b border-gray-200">
                                    Modified
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($parentLink)
                                <tr>
                                    <x-document-library::file-list-td colspan="6">
                                        <a href="{{ $parentLink }}">
                                            Parent Directory
                                        </a>
                                    </x-document-library::file-list-td>
                                </tr>
                            @endif
                            @foreach($directories as $directory)
                                <tr>
                                    <x-document-library::file-list-td>
                                        <a href="{{ route('document-library.directory', $directory) }}">
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


                            </tbody>
                        </table>
                        {{--                        <div class="flex flex-col items-center px-5 py-5 bg-white xs:flex-row xs:justify-between">--}}
                        {{--                            <div class="flex items-center">--}}
                        {{--                                {{ $diretories->links() }}--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>
</body>
</html>
