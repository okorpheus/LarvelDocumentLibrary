<div x-show="showFileUploadForm">
    <backdrop
        class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in dark:bg-gray-900/50"
    />
    <div tabindex="0"
         class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
        <el-dialog-panel
            @click.outside="showFileUploadForm = false"
            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-sm sm:p-6 data-closed:sm:translate-y-0 data-closed:sm:scale-95 dark:bg-gray-800 dark:outline dark:-outline-offset-1 dark:outline-white/10"
        >
            <form method="POST" action="{{ route('document-library.file.store') }}" enctype="multipart/form-data">
                @csrf

                @if($currentDirectory)
                    <input type="hidden" name="parent_id" value="{{ $currentDirectory->id }}">
                @endif
                <div>
                    <div
                        class="mx-auto flex size-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-500/10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>

                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 id="dialog-title" class="text-base font-semibold text-gray-900 dark:text-white">Upload File</h3>
                        <div class="mt-2 text-left">


                            <div class=" relative ">
                                <label for="uploaded-file" class="text-gray-700">
                                    Upload New File
                                </label>
                                <input type="file"
                                       class=" rounded-lg  flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                       name="uploaded-file" id="uploaded-file" placeholder="Select File to Upload"/>
                            </div>

                            <div class="mt-3">
                                <label class="text-gray-700" for="description">Description (optional)</label>
                                <textarea
                                    class="flex-1 w-full px-2 py-2 text-base text-gray-700 placeholder-gray-400 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                    id="description" placeholder="Directory Description (optional)" name="description"
                                    rows="5" cols="40">
    </textarea>


                            </div>

                            <div class="mt-3">

                                <label class="text-gray-700" for="visibility">
                                    Visibility
                                </label>
                                <select id="visibility"
                                        class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                        name="visibility">
                                    @foreach(\Okorpheus\DocumentLibrary\Enums\VisibilityValues::cases() as $visibility)
                                        <option
                                            value="{{ $visibility->value }}">{{ ucfirst($visibility->value) }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                        Upload File
                    </button>
                </div>
            </form>
        </el-dialog-panel>
    </div>
</div>
