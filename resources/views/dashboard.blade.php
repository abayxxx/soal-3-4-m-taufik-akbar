@extends('layouts.app')

@section('content')
@include('modals._product')

<div class="container mx-auto my-10">
    <h2 class="text-2xl font-bold text-center mb-6">Produk</h2>

    <!-- BUTTON ADD -->
    <div class="text-right mb-5">
        <button type="button"
            id="addProduct"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Produk</button>
    </div>


    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Gambar</th>
                    <th class="py-3 px-6 text-left">Kode Produk</th>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Kategori</th>
                    <th class="py-3 px-6 text-left">Stok</th>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Harga</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <!-- Loop through table data -->
                @foreach ($products as $product)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-full">
                    </td>
                    <td class="py-3 px-6 text-left">{{ $product->code }}</td>
                    <td class="py-3 px-6 text-left">{{ $product->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $product->category->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $product->stock }}</td>
                    <td class="py-3 px-6 text-left">{{ $product->price }}</td>
                    <td class="py-3 px-6 text-left">
                        <button type="button" id="editProduct" data-product="{{ $product->id }}"
                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                        <button type="button" id="deleteProduct" data-product="{{ $product->id }}"
                            class="text-red-600 hover:text-red-900">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Add Product
        document.getElementById('addProduct').addEventListener('click', function() {
            document.getElementById('itemForm').reset();
            document.getElementById('itemModal').classList.remove('hidden');
        });

        // Close Modal
        function toggleModal() {
            document.getElementById('itemModal').classList.add('hidden');
        }


        // Save Product
        const form = document.querySelector('form');

        document.getElementById('modalButton').addEventListener('click', async (e) => {

            let formData = new FormData(form);

            let buttonTitle = document.getElementById('modalButton').innerHTML;

            let url = "{{ route('products.store') }}";
            let method = 'POST';

            if (buttonTitle === 'Edit') {
                method = 'POST';
                formData.append('_method', 'PUT');
                id = document.getElementById('id').value
                url = `/products/${id}`;
            }

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();
            if (response.ok) {
                alert(data.success);
                window.location.reload();
            } else {
                alert(data.message);
            }

        });

        // Edit Product
        document.querySelectorAll('#editProduct').forEach(item => {
            item.addEventListener('click', function() {

                //get data by id
                const id = this.getAttribute('data-product');

                fetch(`/products/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);

                        document.getElementById('modalTitle').innerHTML = 'Edit Produk';
                        document.getElementById('modalButton').innerHTML = 'Edit';

                        document.getElementById('id').value = data.id;

                        //remove required attribute in file input
                        document.getElementById('image').removeAttribute('required');

                        document.getElementById('name').value = data.name;
                        document.getElementById('category_id').value = data.category_id;
                        document.getElementById('stock').value = data.stock;
                        document.getElementById('price').value = data.price;
                        document.getElementById('code').value = data.code;
                    });

                document.getElementById('itemModal').classList.remove('hidden');
            });

        });

        // Delete Product
        document.querySelectorAll('#deleteProduct').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-product');

                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    fetch(`/products/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.success);
                            window.location.reload();
                        });
                }
            });
        });
    });
</script>