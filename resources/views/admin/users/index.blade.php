@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6 px-4 sm:px-0 flex justify-between items-center">
            <div>
                <a href="/admin/dashboard" class="text-gray-500 hover:text-gray-700 mb-2 inline-block">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
                <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
            </div>
            <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fa-solid fa-plus"></i> Add New User
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="user-list">
                    <tr><td colspan="5" class="text-center py-4">Loading...</td></tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="user-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h3 id="modal-title" class="text-lg font-bold mb-4">Add User</h3>
        <form id="user-form">
            <input type="hidden" id="user-id">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
             <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                <select id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Min. 8 characters">
                <p class="text-xs text-gray-500 mt-1" id="password-hint">Leave blank to keep current password (when editing).</p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" onclick="closeModal()" class="mr-2 text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Cancel</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let token = localStorage.getItem('token');
    
    document.addEventListener('DOMContentLoaded', () => {
        if (!token) window.location.href = '/login';
        fetchUsers();
    });

    async function fetchUsers() {
        try {
            const res = await fetch('/api/admin/users', {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            const users = await res.json();
            const tbody = document.getElementById('user-list');
            tbody.innerHTML = '';
            
            users.forEach(user => {
                const createdAt = new Date(user.created_at).toLocaleDateString();
                const roleBadge = user.role === 'admin' 
                    ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>' 
                    : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Staff</span>';

                tbody.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${user.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${roleBadge}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${createdAt}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick="editUser(${user.id})" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                            <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                `;
            });
        } catch (e) {
            console.error(e);
        }
    }

    const modal = document.getElementById('user-modal');
    const form = document.getElementById('user-form');

    window.openModal = () => {
        form.reset();
        document.getElementById('user-id').value = '';
        document.getElementById('modal-title').innerText = 'Add User';
        document.getElementById('password').required = true;
        document.getElementById('password-hint').classList.add('hidden');
        modal.classList.remove('hidden');
    }

    window.closeModal = () => {
        modal.classList.add('hidden');
    }

    window.editUser = async (id) => {
        const res = await fetch(`/api/admin/users/${id}`, {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const user = await res.json();
        
        document.getElementById('user-id').value = user.id;
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('role').value = user.role;
        
        document.getElementById('password').required = false;
        document.getElementById('password-hint').classList.remove('hidden');
        
        document.getElementById('modal-title').innerText = 'Edit User';
        modal.classList.remove('hidden');
    }

    window.deleteUser = async (id) => {
        if(!confirm('Are you sure?')) return;
        
        const res = await fetch(`/api/admin/users/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': 'Bearer ' + token }
        });

        if (res.ok) {
            fetchUsers();
        } else {
             const data = await res.json();
             alert(data.message || 'Error deleting user');
        }
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('user-id').value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/api/admin/users/${id}` : '/api/admin/users';

        const body = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            role: document.getElementById('role').value,
            password: document.getElementById('password').value
        };

        // Remove empty password if updating
        if (id && !body.password) {
            delete body.password;
        }

        const res = await fetch(url, {
            method: method,
            headers: { 
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
             },
            body: JSON.stringify(body)
        });

        if(res.ok) {
            closeModal();
            fetchUsers();
        } else {
            const data = await res.json();
            alert(data.message || 'Error saving user');
        }
    });
</script>
@endpush
@endsection
