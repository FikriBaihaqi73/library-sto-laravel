@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800">Library STO</h1>
            <p class="text-gray-500">Sign in to start Stock Opname</p>
        </div>

        <form id="login-form">
            <div id="error-msg" class="mb-4 text-red-500 text-sm text-center hidden"></div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 p-2 border" type="email" name="email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                <input id="password" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 p-2 border" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-600 active:bg-orange-700 focus:outline-none focus:border-orange-700 focus:ring ring-orange-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Log in
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('login-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorMsg = document.getElementById('error-msg');
        
        errorMsg.classList.add('hidden');
        errorMsg.textContent = '';

        try {
            const response = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem('token', data.access_token);
                localStorage.setItem('user', JSON.stringify(data.user));
                window.location.href = '/dashboard';
            } else {
                errorMsg.textContent = data.error || 'Login failed. Please check your credentials.';
                errorMsg.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            errorMsg.textContent = 'An error occurred. Please try again.';
            errorMsg.classList.remove('hidden');
        }
    });

    // Redirect if already logged in
    if (localStorage.getItem('token')) {
        window.location.href = '/dashboard';
    }
</script>
@endpush
@endsection
