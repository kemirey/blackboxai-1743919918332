<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Surat Masuk/Keluar Kecamatan Masama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="public/images/banggai.png" alt="Logo Kabupaten Banggai" class="h-24 object-contain">
                </div>
                    <h1 class="text-2xl font-bold text-blue-600">
                        <i class="fas fa-envelope mr-2"></i>
                        Agenda Surat Kec. Masama
                    </h1>
                <p class="text-gray-600 mt-2">Kabupaten Banggai</p>
            </div>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    Password salah! Silakan coba lagi.
                </div>
            <?php endif; ?>

            <form action="server/login.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="password" name="password" type="password" placeholder="Masukkan password" required>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>