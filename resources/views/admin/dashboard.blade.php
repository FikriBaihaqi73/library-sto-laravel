@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Admin Dashboard</h2>
                <p class="text-gray-600">Overview of Library Stock Opname</p>
            </div>
            <div class="space-x-2">
                 <a href="/admin/users" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
                    <i class="fa-solid fa-users"></i> Manage Users
                </a>
                <a href="/admin/books" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded shadow">
                    <i class="fa-solid fa-book"></i> Manage Books
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 px-4 sm:px-0">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-500">Total Books</p>
                <p class="text-3xl font-bold text-gray-900" id="admin-total-books">-</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                <p class="text-sm font-medium text-gray-500">Verified</p>
                <p class="text-3xl font-bold text-gray-900" id="admin-verified-books">-</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-gray-500">
                <p class="text-sm font-medium text-gray-500">Progress</p>
                <p class="text-3xl font-bold text-gray-900" id="admin-progress">-</p>
            </div>
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Issues (Not Good)</p>
                <p class="text-3xl font-bold text-gray-900" id="admin-issues">-</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 sm:px-0">
            <!-- Condition Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Book Conditions</h3>
                <ul id="condition-list" class="divide-y divide-gray-200">
                    <li class="py-2 text-center text-gray-500">Loading...</li>
                </ul>
            </div>

            <!-- Contributors -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Top Contributors</h3>
                <ul id="contributor-list" class="divide-y divide-gray-200">
                     <li class="py-2 text-center text-gray-500">Loading...</li>
                </ul>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/login';

        // Fetch Stats
        try {
            const response = await fetch('/api/admin/stats', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            if (response.status === 403 || response.status === 401) {
                alert('Access Denied');
                window.location.href = '/dashboard';
                return;
            }

            const data = await response.json();

            // Overview
            document.getElementById('admin-total-books').innerText = data.overview.total_books;
            document.getElementById('admin-verified-books').innerText = data.overview.verified;
            document.getElementById('admin-progress').innerText = data.overview.progress_percentage + '%';

            // Calculate issues (conditions other than 'Baik')
            const issues = data.conditions.reduce((acc, curr) => {
                return curr.condition !== 'Baik' ? acc + curr.total : acc;
            }, 0);
            document.getElementById('admin-issues').innerText = issues;

            // Conditions List
            const conditionList = document.getElementById('condition-list');
            conditionList.innerHTML = '';
            data.conditions.forEach(item => {
                const li = document.createElement('li');
                li.className = 'py-3 flex justify-between items-center';
                li.innerHTML = `
                    <span class="text-gray-700 font-medium">${item.condition}</span>
                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded-full">${item.total}</span>
                `;
                conditionList.appendChild(li);
            });

            // Contributors List
            const contributorList = document.getElementById('contributor-list');
            contributorList.innerHTML = '';
            data.contributors.forEach(user => {
                const li = document.createElement('li');
                li.className = 'py-3 flex justify-between items-center';
                li.innerHTML = `
                    <div class="flex items-center">
                         <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                            ${user.name.charAt(0)}
                        </div>
                        <span class="ml-3 text-gray-700 font-medium">${user.name}</span>
                    </div>
                    <span class="text-green-600 font-bold">${user.stock_opnames_count} verified</span>
                `;
                contributorList.appendChild(li);
            });

        } catch (error) {
            console.error('Error fetching admin stats:', error);
        }
    });
</script>
@endpush
@endsection
