@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Welcome Message -->
        <div class="mb-8 px-4 sm:px-0">
            <h2 class="text-2xl font-bold text-gray-800">
                Hello, <span id="user-name">User</span>! 👋
            </h2>
            <p class="text-gray-600">Here is the stock opname progress.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 px-4 sm:px-0">
            <!-- Total Books -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <i class="fa-solid fa-book text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Books</p>
                        <p class="text-3xl font-bold text-gray-900" id="stat-total-books">-</p>
                    </div>
                </div>
            </div>

            <!-- Verified Books -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                        <i class="fa-solid fa-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Verified System</p>
                        <p class="text-3xl font-bold text-gray-900" id="stat-verified-books">-</p>
                    </div>
                </div>
            </div>

            <!-- Your Contribution -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-500 mr-4">
                        <i class="fa-solid fa-user-check text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Your STO</p>
                        <p class="text-3xl font-bold text-gray-900" id="stat-user-verified">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-4 sm:px-6 py-6 mx-4 sm:mx-0">
            <h3 class="text-lg font-bold text-gray-800 mb-4">#Peringkat Stok Opname</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200" id="leaderboard-list">
                        <!-- Content loaded via JS -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/login';

        // Set User Name
        const user = JSON.parse(localStorage.getItem('user'));
        if (user) document.getElementById('user-name').innerText = user.name;

        // Fetch Dashboard Data
        try {
            const response = await fetch('/api/dashboard', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            if (response.status === 401) {
                // Token invalid
                localStorage.removeItem('token');
                window.location.href = '/login';
                return;
            }

            const data = await response.json();

            // Update Stats
            document.getElementById('stat-total-books').innerText = data.stats.total_books;
            document.getElementById('stat-verified-books').innerText = data.stats.verified_books;
            document.getElementById('stat-user-verified').innerText = data.stats.user_verified;

            // Update Leaderboard
            const leaderboardList = document.getElementById('leaderboard-list');
            leaderboardList.innerHTML = ''; // Clear loading

            data.leaderboard.forEach((user, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="${user.avatar_url}" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${user.name}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 font-bold">${user.count}</div>
                        <div class="text-xs text-gray-500">Verified</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        ${index === 0 ? '<i class="fa-solid fa-trophy text-yellow-500 text-xl"></i>' : ''}
                    </td>
                `;
                leaderboardList.appendChild(tr);
            });

        } catch (error) {
            console.error('Error fetching dashboard:', error);
        }
    });
</script>
@endpush
@endsection
