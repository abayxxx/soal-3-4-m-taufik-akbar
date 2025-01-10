@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800">Register</h2>
        <form method="POST" action="" class="mt-6">
            @csrf

            <!-- EERROR MESSAGE -->
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input id="name" type="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Hp</label>
                <input id="phone_number" type="number"
                    name="phone_number"
                    value="{{ old('phone_number') }}"
                    required
                    autofocus
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('phone_number')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password"
                    name="password"
                    required
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>


            <!-- Password Confirmation Field -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Password Confirmation</label>
                <input id="password_confirmation" type="password"
                    name="password_confirmation"
                    required
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password_confirmation')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>




            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Register
            </button>
        </form>
    </div>
</div>
@endsection

<script>
    // make ajax request to register
    document.addEventListener('DOMContentLoaded', () => {

        const form = document.querySelector('form');
        form.addEventListener('submit', async (e) => {
            // 
            const formData = new FormData(form);
            const response = await fetch('/register', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (response.ok) {
                window.location.href = '/login';
            } else {
                alert(data.message);
            }
        });


        // validation for phone number
        const phone_number = document.getElementById('phone_number');
        phone_number.addEventListener('keyup', (e) => {
            console.log(e.target.value);
            const value = e.target.value;
            if (value.length < 8) {
                phone_number.setCustomValidity('Nomor Hp harus minimal 8 digit');
            } else if (value.length > 15) {
                phone_number.setCustomValidity('Nomor Hp harus maksimal 15 digit');
            } else {
                phone_number.setCustomValidity('');
            }

            // check first 2 digit is 08
            if (value.length >= 2) {
                if (value.slice(0, 2) !== '08') {
                    phone_number.setCustomValidity('Nomor Hp harus diawali dengan 08');
                }
            }

            //check if value not number
            if (isNaN(value) || value.includes('.')) {
                phone_number.setCustomValidity('Nomor Hp harus berupa angka');
            }

        });


        // validation for password
        const password = document.getElementById('password');
        password.addEventListener('keyup', (e) => {
            const value = e.target.value;
            if (value.length < 8) {
                password.setCustomValidity('Password harus minimal 8 karakter');
            } else {
                password.setCustomValidity('');
            }

            //check if password contain space
            if (value.includes(' ')) {
                password.setCustomValidity('Password tidak boleh mengandung spasi');
            }
        });

        // validation for password confirmation
        const password_confirmation = document.getElementById('password_confirmation');
        password_confirmation.addEventListener('keyup', (e) => {
            const value = e.target.value;
            if (value !== password.value) {
                password_confirmation.setCustomValidity('Password confirmation harus sama dengan password');
            } else {
                password_confirmation.setCustomValidity('');
            }
        });


        //check validation on submit
        form.addEventListener('submit', (e) => {

        });

    })
</script>