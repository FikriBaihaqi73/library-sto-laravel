@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6 px-4 sm:px-0 flex justify-between items-center">
            <div>
                <a href="/admin/dashboard" class="text-gray-500 hover:text-gray-700 mb-2 inline-block">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Book Management</h2>
            </div>
            <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fa-solid fa-plus"></i> Add New Book
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="book-list">
                    <tr><td colspan="5" class="text-center py-4">Loading...</td></tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="book-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h3 id="modal-title" class="text-lg font-bold mb-4">Add Book</h3>
        <form id="book-form">
            <input type="hidden" id="book-id">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">ISBN</label>
                <input type="text" id="isbn" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Author</label>
                <input type="text" id="author" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <input type="text" id="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
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
        fetchBooks();
    });

    async function fetchBooks() {
        try {
            const res = await fetch('/api/admin/books', {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            const books = await res.json();
            const tbody = document.getElementById('book-list');
            tbody.innerHTML = '';
            
            books.forEach(book => {
                tbody.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${book.title}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">${book.isbn}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${book.author}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${book.category}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick="editBook(${book.id})" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                            <button onclick="deleteBook(${book.id})" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                `;
            });
        } catch (e) {
            console.error(e);
        }
    }

    const modal = document.getElementById('book-modal');
    const form = document.getElementById('book-form');

    window.openModal = () => {
        form.reset();
        document.getElementById('book-id').value = '';
        document.getElementById('modal-title').innerText = 'Add Book';
        modal.classList.remove('hidden');
    }

    window.closeModal = () => {
        modal.classList.add('hidden');
    }

    window.editBook = async (id) => {
        const res = await fetch(`/api/admin/books/${id}`, {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const book = await res.json();
        
        document.getElementById('book-id').value = book.id;
        document.getElementById('title').value = book.title;
        document.getElementById('isbn').value = book.isbn;
        document.getElementById('author').value = book.author;
        document.getElementById('category').value = book.category;
        
        document.getElementById('modal-title').innerText = 'Edit Book';
        modal.classList.remove('hidden');
    }

    window.deleteBook = async (id) => {
        if(!confirm('Are you sure?')) return;
        
        await fetch(`/api/admin/books/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': 'Bearer ' + token }
        });
        fetchBooks();
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('book-id').value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/api/admin/books/${id}` : '/api/admin/books';

        const body = {
            title: document.getElementById('title').value,
            isbn: document.getElementById('isbn').value,
            author: document.getElementById('author').value,
            category: document.getElementById('category').value
        };

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
            fetchBooks();
        } else {
            alert('Error saving book');
        }
    });
</script>
@endpush
@endsection
