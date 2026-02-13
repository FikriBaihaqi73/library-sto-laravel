@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-md mx-auto px-4 sm:px-0">
        
        <div class="mb-4">
            <a href="/dashboard" class="text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8 mb-6 text-center">
            <div class="mb-6">
                 <i class="fa-solid fa-barcode text-6xl text-gray-800"></i>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Scan Book Barcode</h2>
            <p class="text-gray-500 mb-6">Enter ISBN or setup a barcode scanner</p>

            <form id="scan-form" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-search text-gray-400"></i>
                </div>
                <input type="text" id="isbn-input" 
                    class="block w-full pl-10 pr-3 py-4 border border-gray-300 rounded-full leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 sm:text-lg" 
                    placeholder="Enter ISBN..." autofocus>
                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <i class="fa-solid fa-arrow-right text-orange-500 hover:text-orange-700 font-bold text-xl"></i>
                </button>
            </form>
            <p id="scan-error" class="text-red-500 text-sm mt-2 hidden"></p>
        </div>

        <!-- Result Card (Hidden by default) -->
        <div id="book-result" class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 hidden">
            <div class="flex flex-col items-center text-center">
                <div class="h-32 w-24 bg-gray-200 mb-4 rounded shadow-sm flex items-center justify-center overflow-hidden">
                    <img id="book-cover" src="" alt="Book Cover" class="h-full w-full object-cover hidden">
                    <i id="default-cover" class="fa-solid fa-book text-4xl text-gray-400"></i>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-1" id="book-title">Title</h3>
                <p class="text-sm text-gray-500 mb-4" id="book-author">Author</p>

                <div class="w-full bg-gray-50 rounded-lg p-4 mb-4 text-left">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-xs uppercase">Category</span>
                        <span class="font-bold text-sm" id="book-category">-</span>
                    </div>
                </div>

                <div id="action-area" class="w-full">
                    <div id="condition-form" class="text-left mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="condition">
                            Kondisi Buku
                        </label>
                        <select id="condition-input" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline mb-3">
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baik">Baik</option>
                            <option value="Barcode lepas">Barcode lepas</option>
                            <option value="Barcode rusak">Barcode rusak</option>
                            <option value="Barcode salah">Barcode salah</option>
                            <option value="Barcode tidak ada">Barcode tidak ada</option>
                            <option value="Label lepas">Label lepas</option>
                            <option value="Label salah">Label salah</option>
                            <option value="Halaman sobek">Halaman sobek</option>
                            <option value="Halaman rusak">Halaman rusak</option>
                            <option value="Halaman lepas">Halaman lepas</option>
                            <option value="Halaman hilang">Halaman hilang</option>
                            <option value="Sampul sobek">Sampul sobek</option>
                            <option value="Sampul rusak">Sampul rusak</option>
                            <option value="Sampul lepas">Sampul lepas</option>
                            <option value="Sampul tidak ada">Sampul tidak ada</option>
                            <option value="Sampul rusak kena air">Sampul rusak kena air</option>
                            <option value="sampul rusak dimakan kutu">Sampul rusak dimakan kutu</option>
                            <option value="Sampul rusak dimakan rayap">Sampul rusak dimakan rayap</option>
                            <option value="Sampul rusak kena debu">Sampul rusak kena debu</option>
                        </select>
                        
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
                            Keterangan Tambahan (Opsional)
                        </label>
                        <textarea id="notes-input" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Catatan tambahan..."></textarea>
                    </div>

                    <p id="status-badge" class="hidden mb-4 px-3 py-1 rounded-full text-sm font-bold inline-block"></p>
                    
                    <button id="confirm-btn" class="w-full bg-orange-500 text-white font-bold py-3 px-4 rounded-full shadow hover:bg-orange-600 transition duration-150">
                        <i class="fa-solid fa-check"></i> Verifikasi Stok
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 text-center transform transition-all scale-100">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
            <i class="fa-solid fa-check text-3xl text-green-500"></i>
        </div>
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Data Tersimpan!</h3>
        <p class="text-sm text-gray-500 mb-6">
            Stok opname untuk buku ini telah berhasil diverifikasi.
        </p>
        <button id="close-modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-200 text-base font-medium text-gray-700 hover:bg-gray-300 focus:outline-none sm:text-sm">
            Tutup & Scan Lagi
        </button>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/login';

        const form = document.getElementById('scan-form');
        const input = document.getElementById('isbn-input');
        const errorMsg = document.getElementById('scan-error');
        
        const resultCard = document.getElementById('book-result');
        const bookTitle = document.getElementById('book-title');
        const bookAuthor = document.getElementById('book-author');
        const bookCategory = document.getElementById('book-category');
        const bookStock = document.getElementById('book-stock');
        const bookCover = document.getElementById('book-cover');
        const defaultCover = document.getElementById('default-cover');
        
        const confirmBtn = document.getElementById('confirm-btn');
        const statusBadge = document.getElementById('status-badge');
        
        const successModal = document.getElementById('success-modal');
        const closeModal = document.getElementById('close-modal');

        let currentBookId = null;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const isbn = input.value.trim();
            if(!isbn) return;

            errorMsg.classList.add('hidden');
            resultCard.classList.add('hidden');

            try {
                const response = await fetch(`/api/books/${isbn}`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    showBook(data.book);
                    updateStatus(data.status, data.verified_by);
                    currentBookId = data.book.id;
                } else {
                    errorMsg.innerText = data.message || 'Book not found';
                    errorMsg.classList.remove('hidden');
                }
            } catch (error) {
                console.error(error);
                errorMsg.innerText = 'Error searching book';
                errorMsg.classList.remove('hidden');
            }
        });

        function showBook(book) {
            bookTitle.innerText = book.title;
            bookAuthor.innerText = book.author;
            bookCategory.innerText = book.category;
            
            if (book.cover_url) {
                bookCover.src = book.cover_url;
                bookCover.classList.remove('hidden');
                defaultCover.classList.add('hidden');
            } else {
                bookCover.classList.add('hidden');
                defaultCover.classList.remove('hidden');
            }

            resultCard.classList.remove('hidden');
        }

        function updateStatus(status, verifiedBy = null) {
            // Reset state forcefully to remove inline-block and other conflicting classes
            statusBadge.className = 'hidden'; 
            confirmBtn.classList.add('hidden');
            const conditionForm = document.getElementById('condition-form');

            if (status === 'verified') {
                statusBadge.innerText = 'Sudah Diverifikasi oleh ' + (verifiedBy ? verifiedBy : 'Sistem');
                statusBadge.className = 'mb-4 px-3 py-1 rounded-full text-sm font-bold inline-block bg-green-100 text-green-800';
                conditionForm.classList.add('hidden'); // Hide form if already verified
            } else {
                confirmBtn.classList.remove('hidden');
                conditionForm.classList.remove('hidden'); // Show form if pending
                
                // Clear inputs
                document.getElementById('condition-input').value = '';
                document.getElementById('notes-input').value = '';
            }
        }


        confirmBtn.addEventListener('click', async () => {
            if (!currentBookId) return;
            
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

            try {
                const response = await fetch('/api/stock-opname', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        book_id: currentBookId,
                        status: 'verified',
                        condition: document.getElementById('condition-input').value,
                        notes: document.getElementById('notes-input').value
                    })
                });

                if (response.ok) {
                    successModal.classList.remove('hidden');
                } else {
                    alert('Failed to save data');
                }
            } catch (error) {
                console.error(error);
            } finally {
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = '<i class="fa-solid fa-check"></i> Verifikasi Stok';
            }
        });

        closeModal.addEventListener('click', () => {
            successModal.classList.add('hidden');
            input.value = '';
            resultCard.classList.add('hidden');
            input.focus();
        });
    });
</script>
@endpush
@endsection
