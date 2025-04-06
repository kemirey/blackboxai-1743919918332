<?php
require_once 'server/auth.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Surat Kecamatan Masama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .stat-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .stat-icon {
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-blue-600 text-white shadow">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-envelope mr-2"></i>
                    Agenda Surat Kec. Masama
                </h1>
                <div>
                    <span class="mr-4">Kabupaten Banggai</span>
                    <a href="server/logout.php" class="text-white hover:text-blue-200">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow stat-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <i class="fas fa-envelope-open-text text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm">Surat Masuk</h3>
                            <p class="text-2xl font-bold" id="incoming-count">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow stat-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <i class="fas fa-paper-plane text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm">Surat Keluar</h3>
                            <p class="text-2xl font-bold" id="outgoing-count">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow stat-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm">Bulan Ini</h3>
                            <p class="text-2xl font-bold" id="monthly-incoming">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow stat-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm">Bulan Ini</h3>
                            <p class="text-2xl font-bold" id="monthly-outgoing">0</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Upload, Search and Add Button -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="flex items-center">
                    <form id="uploadForm" class="mr-4">
                        <label class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer">
                            <i class="fas fa-upload mr-2"></i> Upload Logo
                            <input type="file" name="image" id="imageUpload" class="hidden" accept="image/*">
                        </label>
                    </form>
                    <div id="uploadStatus" class="text-sm hidden"></div>
                </div>
                <div class="relative w-64">
                    <input type="text" id="searchInput" placeholder="Cari surat..." 
                           class="w-full pl-10 pr-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex space-x-2">
                    <a href="add_incoming.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Surat Masuk
                    </a>
                    <a href="add_outgoing.php" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Surat Keluar
                    </a>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px" id="myTab" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block py-2 px-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active" 
                                id="incoming-tab" data-tab="incoming" type="button" role="tab">Surat Masuk</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block py-2 px-4 text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 rounded-t-lg" 
                                id="outgoing-tab" data-tab="outgoing" type="button" role="tab">Surat Keluar</button>
                    </li>
                </ul>
            </div>

            <!-- Table Content -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="letterTable" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('[data-tab]').forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Update active tab styling
                document.querySelectorAll('[data-tab]').forEach(t => {
                    t.classList.remove('text-blue-600', 'border-blue-600');
                    t.classList.add('text-gray-500', 'border-transparent');
                });
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('text-gray-500', 'border-transparent');
                
                // Load data for selected tab
                loadLetters(tabId);
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#letterTable tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Load stats function
        function loadStats() {
            fetch('server/stats.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('incoming-count').textContent = data.data.incoming;
                        document.getElementById('outgoing-count').textContent = data.data.outgoing;
                        document.getElementById('monthly-incoming').textContent = data.data.monthly_incoming;
                        document.getElementById('monthly-outgoing').textContent = data.data.monthly_outgoing;
                    }
                });
        }

        // Initial load
        loadLetters('incoming');
        loadStats();
        
        // Refresh stats every 30 seconds
        setInterval(loadStats, 30000);

        let currentTab = 'incoming';
        let currentPage = 1;

        function loadLetters(type, page = 1, search = '') {
            currentTab = type;
            currentPage = page;
            
            document.getElementById('letterTable').innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        Memuat data...
                    </td>
                </tr>`;

            fetch(`server/search.php?type=${type}&page=${page}&search=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderLetters(data.data);
                        renderPagination(data.pagination);
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => showError(error.message));
        }

        function renderLetters(letters) {
            const tableBody = document.getElementById('letterTable');
            tableBody.innerHTML = '';

            if (letters.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data surat
                        </td>
                    </tr>`;
                return;
            }

            letters.forEach(letter => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${letter.letter_number}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${letter.date}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">${currentTab === 'incoming' ? letter.subject : letter.recipient}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                    </td>`;
                tableBody.appendChild(row);
            });
        }

        function renderPagination(pagination) {
            const paginationDiv = document.createElement('div');
            paginationDiv.className = 'flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6';
            
            let html = `
                <div class="flex-1 flex justify-between sm:hidden">
                    <button onclick="loadLetters('${currentTab}', ${currentPage - 1})" 
                            ${currentPage === 1 ? 'disabled' : ''}
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Sebelumnya
                    </button>
                    <button onclick="loadLetters('${currentTab}', ${currentPage + 1})" 
                            ${currentPage === pagination.last_page ? 'disabled' : ''}
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Selanjutnya
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Menampilkan <span class="font-medium">${(currentPage - 1) * pagination.per_page + 1}</span>
                            sampai <span class="font-medium">${Math.min(currentPage * pagination.per_page, pagination.total)}</span>
                            dari <span class="font-medium">${pagination.total}</span> hasil
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <button onclick="loadLetters('${currentTab}', ${currentPage - 1})" 
                                    ${currentPage === 1 ? 'disabled' : ''}
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Sebelumnya</span>
                                <i class="fas fa-chevron-left"></i>
                            </button>`;

            // Page numbers
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `
                    <button onclick="loadLetters('${currentTab}', ${i})"
                            ${currentPage === i ? 'aria-current="page"' : ''}
                            class="${currentPage === i ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'} relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        ${i}
                    </button>`;
            }

            html += `
                            <button onclick="loadLetters('${currentTab}', ${currentPage + 1})"
                                    ${currentPage === pagination.last_page ? 'disabled' : ''}
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Selanjutnya</span>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </nav>
                    </div>
                </div>`;

            // Remove existing pagination if any
            const existingPagination = document.querySelector('.pagination-container');
            if (existingPagination) {
                existingPagination.remove();
            }

            paginationDiv.innerHTML = html;
            paginationDiv.classList.add('pagination-container');
            document.querySelector('main').appendChild(paginationDiv);
        }

        function showError(message) {
            document.getElementById('letterTable').innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-red-500">
                        ${message}
                    </td>
                </tr>`;
        }

        // Search functionality with debounce
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadLetters(currentTab, 1, this.value);
            }, 500);
        });
    </script>
</body>
</html>