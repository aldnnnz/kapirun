<div>
    <button type="button" class="mt-1 px-3 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700" wire:click="addNew">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
    </button>

    <!-- Add Category Modal -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" x-show="$wire.id_kategori === 'add_new'" style="display: none;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Add New Category</h3>
                <form wire:submit="saveCategory" class="mt-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Category Name</label>
                        <input type="text" wire:model="new_category_name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('new_category_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300" wire:click="cancelAddCategory">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                            Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
