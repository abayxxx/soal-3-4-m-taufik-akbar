<!-- Modal -->
<div id="itemModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">
        <div class="border-b p-4">
            <h2 class="text-lg font-bold" id="modalTitle">Tambah Barang</h2>
        </div>
        <form id="itemForm" method="POST" enctype="multipart/form-data" class="p-4">
            @csrf
            <!-- Gambar -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                <input type="file" id="image" name="image" required accept=".jpg,.jpeg,.png"
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <small class="text-gray-500">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
                @error('image')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- code Barang -->
            <div class="mb-4">
                <label for="kode" class="block text-sm font-medium text-gray-700">Kode Barang</label>
                <input type="text" id="code" name="code" required
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('code')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" required minlength="3" maxlength="255"
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <small class="text-gray-500">Minimal 3 karakter, maksimal 255 karakter.</small>
                @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="category_id" name="category_id" required
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled>Pilih Kategori</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                </select>
                @error('category_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Stok -->
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" id="stock" name="stock" required
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('stock')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Harga -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" id="price" name="price" required
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('price')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <input type="hidden" id="id" name="id">

            <!-- Buttons -->
            <div class="flex justify-end mt-6">
                <button type="button" onclick="toggleModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Batal
                </button>


                <button type="button"
                    data-type="add"
                    class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring focus:ring-indigo-300"
                    id="modalButton">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('itemModal');
        modal.classList.toggle('hidden');
    }
</script>