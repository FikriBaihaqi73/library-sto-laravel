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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengarang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penerbit</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN/ISSN</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klasifikasi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Panggil</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eksemplar</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Unggulan</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="book-list">
                    <tr><td colspan="10" class="text-center py-4">Loading...</td></tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="book-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg w-full max-w-2xl p-6 max-h-screen overflow-y-auto">
        <h3 id="modal-title" class="text-lg font-bold mb-4">Tambah Buku</h3>
        <form id="book-form">
            <input type="hidden" id="book-id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" id="title" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- Pengarang -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Pengarang <span class="text-red-500">*</span></label>
                    <input type="text" id="author" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- Penerbit -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Penerbit <span class="text-red-500">*</span></label>
                    <input type="text" id="publisher" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- Tempat Terbit -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Tempat Terbit <span class="text-red-500">*</span></label>
                    <input type="text" id="place_of_publication" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- Tahun Terbit -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                    <input type="text" id="year_of_publication" maxlength="4" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- ISBN/ISSN -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">ISBN/ISSN</label>
                    <input type="text" id="isbn_issn" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Bahasa -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Bahasa</label>
                    <input type="text" id="language" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Kolasi -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Kolasi</label>
                    <input type="text" id="collation" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- GMD/Jenis -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">GMD/Jenis</label>
                    <input type="text" id="gmd_type" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Klasifikasi -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Klasifikasi</label>
                    <input type="text" id="classification" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Nomor Panggil -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Nomor Panggil</label>
                    <input type="text" id="call_number" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Tajuk Subjek -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1">Tajuk Subjek</label>
                    <input type="text" id="subject" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Abstrak -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1">Abstrak</label>
                    <textarea id="abstract" rows="3" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
                <!-- Gambar Sampul -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1">Gambar Sampul (URL)</label>
                    <input type="text" id="cover_image" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Item/Eksemplar -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Item/Eksemplar</label>
                    <input type="number" id="total_items" min="0" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Edisi -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Edisi</label>
                    <input type="text" id="edition" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Kala Terbit -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Kala Terbit</label>
                    <input type="text" id="frequency_of_publication" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Judul Seri -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Judul Seri</label>
                    <input type="text" id="series_title" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Lampiran -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Lampiran</label>
                    <input type="text" id="attachment" class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <!-- Buku Unggulan -->
                <div class="flex items-center gap-2 mt-2">
                    <input type="checkbox" id="is_featured" class="w-4 h-4">
                    <label class="text-gray-700 text-sm font-bold">Buku Unggulan</label>
                </div>
            </div>

            <div class="flex justify-end pt-6 gap-2">
                <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded border">Batal</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let token = localStorage.getItem('token');

    const fields = [
        'title', 'author', 'publisher', 'place_of_publication', 'year_of_publication',
        'isbn_issn', 'language', 'collation', 'gmd_type', 'classification',
        'call_number', 'subject', 'abstract', 'cover_image', 'total_items',
        'edition', 'frequency_of_publication', 'series_title', 'attachment'
    ];

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

            if (!books.length) {
                tbody.innerHTML = '<tr><td colspan="10" class="text-center py-4 text-gray-400">Belum ada data buku.</td></tr>';
                return;
            }

            books.forEach(book => {
                tbody.innerHTML += `
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">${book.title}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${book.author ?? '-'}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${book.publisher ?? '-'}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${book.year_of_publication ?? '-'}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 font-mono">${book.isbn_issn ?? '-'}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${book.classification ?? '-'}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">${book.call_number ?? '-'}</td>
                        <td class="px-4 py-3 text-sm text-center text-gray-500">${book.total_items ?? 0}</td>
                        <td class="px-4 py-3 text-sm text-center">
                            ${book.is_featured
                                ? '<span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-0.5 rounded">⭐ Unggulan</span>'
                                : '<span class="text-gray-300">-</span>'}
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-medium whitespace-nowrap">
                            <button onclick="editBook(${book.id})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                            <button onclick="deleteBook(${book.id})" class="text-red-600 hover:text-red-900">Hapus</button>
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
        document.getElementById('modal-title').innerText = 'Tambah Buku';
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
        fields.forEach(f => {
            const el = document.getElementById(f);
            if (el) el.value = book[f] ?? '';
        });
        document.getElementById('is_featured').checked = !!book.is_featured;

        document.getElementById('modal-title').innerText = 'Edit Buku';
        modal.classList.remove('hidden');
    }

    window.deleteBook = async (id) => {
        if (!confirm('Yakin ingin menghapus buku ini?')) return;

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

        const body = {};
        fields.forEach(f => {
            const el = document.getElementById(f);
            if (el) body[f] = el.value || null;
        });
        body['is_featured'] = document.getElementById('is_featured').checked;

        const res = await fetch(url, {
            method: method,
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (res.ok) {
            closeModal();
            fetchBooks();
        } else {
            const err = await res.json();
            alert('Error: ' + (err.message ?? JSON.stringify(err.errors)));
        }
    });
</script>
@endpush
@endsection
