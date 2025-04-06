<?php
require_once 'server/auth.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat Masuk - Kecamatan Masama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-blue-600 text-white shadow">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-envelope mr-2"></i>
                    Sistem Surat Kecamatan Masama
                </h1>
                <div>
                    <a href="dashboard.php" class="text-white hover:text-blue-200 mr-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="server/logout.php" class="text-white hover:text-blue-200">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-envelope-open-text mr-2 text-blue-500"></i>
                    Tambah Surat Masuk - Kec. Masama
                </h2>

                <?php if (isset($_GET['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <?php
                        switch($_GET['error']) {
                            case 'duplicate':
                                echo 'Nomor surat sudah ada!';
                                break;
                            case 'date':
                                echo 'Format tanggal harus dd/mm/yyyy!';
                                break;
                            default:
                                echo 'Terjadi kesalahan!';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <form action="server/save_incoming.php" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="letter_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat*</label>
                            <input type="text" id="letter_number" name="letter_number" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Contoh: 005/UM/MASAMA/VI/2023</p>
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat*</label>
                            <input type="text" id="date" name="date" placeholder="dd/mm/yyyy" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   pattern="\d{2}/\d{2}/\d{4}">
                            <p class="mt-1 text-sm text-gray-500">Format: dd/mm/yyyy</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Perihal*</label>
                        <input type="text" id="subject" name="subject" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>