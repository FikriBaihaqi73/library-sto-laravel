@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Admin Dashboard</h2>
                <p class="text-gray-600">Overview of Library Stock Opname</p>
            </div>
            <div class="flex flex-wrap gap-2">
                 <a href="/admin/users" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 rounded shadow text-sm inline-flex items-center">
                    <i class="fa-solid fa-users mr-2"></i> Manage Users
                </a>
                <a href="/admin/books" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-3 rounded shadow text-sm inline-flex items-center">
                    <i class="fa-solid fa-book mr-2"></i> Manage Books
                </a>
                <button onclick="openCommissionModal()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-3 rounded shadow text-sm inline-flex items-center">
                    <i class="fa-solid fa-coins mr-2"></i> Setting Komisi
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8 px-4 sm:px-0">
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                <p class="text-sm font-medium text-gray-500">Total Komisi</p>
                <p class="text-2xl font-bold text-gray-900" id="admin-total-commission">-</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                <p class="text-sm font-medium text-gray-500">Komisi per STO</p>
                <div class="flex items-baseline">
                    <p class="text-2xl font-bold text-gray-900" id="admin-per-sto-commission">-</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-0">
            <!-- Condition Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Book Conditions</h3>
                <ul id="condition-list" class="divide-y divide-gray-200">
                    <li class="py-2 text-center text-gray-500">Loading...</li>
                </ul>
            </div>

            <!-- Commission per User -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Komisi per User</h3>
                <ul id="user-commission-list" class="divide-y divide-gray-200">
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

<!-- Commission Modal -->
<div id="commission-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h3 class="text-lg font-bold mb-4">Setting Komisi per STO</h3>
        <form id="commission-form">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nilai Komisi (IDR)</label>
                <input type="text" id="commission-value" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Contoh: 1.000">
                <p class="text-xs text-gray-500 mt-1">Komisi yang didapatkan staff setiap melakukan verifikasi 1 buku.</p>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCommissionModal()" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded border">Batal</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const fetchStats = async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

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
            document.getElementById('admin-total-commission').innerText = 'Rp ' + data.overview.total_commission.toLocaleString('id-ID');
            document.getElementById('admin-per-sto-commission').innerText = 'Rp ' + data.overview.current_commission.toLocaleString('id-ID');

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

            // Commission per User List
            const commissionList = document.getElementById('user-commission-list');
            commissionList.innerHTML = '';
            [...data.contributors].sort((a, b) => b.total_commission - a.total_commission).forEach(user => {
                const li = document.createElement('li');
                li.className = 'py-3 flex justify-between items-center';
                li.innerHTML = `
                    <div class="flex items-center">
                         <div class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center text-xs font-bold text-yellow-700">
                            ${user.name.charAt(0)}
                        </div>
                        <span class="ml-3 text-gray-700 font-medium">${user.name}</span>
                    </div>
                    <span class="text-orange-600 font-bold">Rp ${(user.total_commission || 0).toLocaleString('id-ID')}</span>
                `;
                commissionList.appendChild(li);
            });

        } catch (error) {
            console.error('Error fetching admin stats:', error);
        }
    };

    document.addEventListener('DOMContentLoaded', fetchStats);

    const commissionModal = document.getElementById('commission-modal');
    const commissionForm = document.getElementById('commission-form');
    const commissionInput = document.getElementById('commission-value');

    const formatRupiah = (value) => {
        if (!value) return '';
        const numberString = value.toString().replace(/[^0-9]/g, '');
        const split = numberString.split('');
        const sisa = split.length % 3;
        let rupiah = split.slice(0, sisa).join('');
        const ribuan = split.slice(sisa).join('').match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }

    commissionInput.addEventListener('input', (e) => {
        e.target.value = formatRupiah(e.target.value);
    });

    window.openCommissionModal = async () => {
        try {
            const res = await fetch('/api/admin/settings', {
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
            });
            const data = await res.json();
            commissionInput.value = formatRupiah(data.commission);
            commissionModal.classList.remove('hidden');
        } catch (e) {
            alert('Gagal mengambil data setting');
        }
    }

    window.closeCommissionModal = () => {
        commissionModal.classList.add('hidden');
    }

    commissionForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const rawValue = commissionInput.value.replace(/\./g, '');
        try {
            const res = await fetch('/api/admin/settings', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ commission: rawValue })
            });
            if (res.ok) {
                alert('Setting berhasil disimpan!');
                closeCommissionModal();
                fetchStats(); // Update dashboard immediately without page refresh
            } else {
                alert('Gagal menyimpan setting');
            }
        } catch (e) {
            alert('Terjadi kesalahan');
        }
    });
</script>
@endpush
@endsection
