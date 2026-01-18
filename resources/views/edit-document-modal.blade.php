<div x-show="showEditDocumentForm" x-cloak>
    <backdrop
        class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in dark:bg-gray-900/50"
    />
    <div tabindex="0"
         class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
        <el-dialog-panel
            @click.outside="showEditDocumentForm = false"
            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-sm sm:p-6 data-closed:sm:translate-y-0 data-closed:sm:scale-95 dark:bg-gray-800 dark:outline dark:-outline-offset-1 dark:outline-white/10"
        >
            <form method="POST" :action="editDocumentAction">
                @csrf
                @method('PATCH')

                <div>
                    <div
                        class="mx-auto flex size-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-500/10">
                        <x-heroicon-o-pencil-square class="size-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 id="dialog-title" class="text-base font-semibold text-gray-900 dark:text-white">Edit Document</h3>
                        <div class="mt-2 text-left">

                            <div class="relative">
                                <label for="edit-document-name" class="text-gray-700">
                                    Document Name
                                </label>
                                <input type="text"
                                       x-model="editDocument.name"
                                       class="rounded-lg flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                       name="name" id="edit-document-name" placeholder="Document Name"/>
                            </div>

                            <div class="mt-3">
                                <label class="text-gray-700" for="edit-document-description">Description (optional)</label>
                                <textarea
                                    x-model="editDocument.description"
                                    class="flex-1 w-full px-2 py-2 text-base text-gray-700 placeholder-gray-400 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                    id="edit-document-description" placeholder="Document Description (optional)" name="description"
                                    rows="5" cols="40"></textarea>
                            </div>

                            <div class="mt-3">
                                <label class="text-gray-700" for="edit-document-visibility">
                                    Visibility
                                </label>
                                <select id="edit-document-visibility"
                                        x-model="editDocument.visibility"
                                        class="block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm w-52 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                        name="visibility">
                                    @foreach(\Okorpheus\DocumentLibrary\Enums\VisibilityValues::cases() as $visibility)
                                        <option value="{{ $visibility->value }}">{{ ucfirst($visibility->value) }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 flex gap-3">
                    <button type="button"
                            @click="showEditDocumentForm = false"
                            class="inline-flex w-full justify-center rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                        Update Document
                    </button>
                </div>
            </form>
        </el-dialog-panel>
    </div>
</div>