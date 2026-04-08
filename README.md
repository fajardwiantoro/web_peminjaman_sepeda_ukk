<?php 
// 1. Memulai session untuk mengecek login
session_start();

// 2. Memastikan path ke app.php benar
// Asumsi: app.php berada di folder 'backend/app.php'
require_once __DIR__ . '/backend/app.php';

// 3. Ambil data barang dari database
$data_barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang DESC");

// 4. Cek status login
$is_login = isset($_SESSION['id_user']); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Sepeda - UKK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Sistem Peminjaman Sepeda</h1>
        
        <?php if($is_login): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                Selamat datang, <?= $_SESSION['username'] ?? 'User' ?>!
                <a href="logout.php" class="float-right font-bold">Logout</a>
            </div>
        <?php else: ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                Silakan <a href="login.php" class="font-bold underline">login</a> untuk meminjam sepeda
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while($row = mysqli_fetch_assoc($data_barang)): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($row['nama_barang']) ?></h2>
                        <p class="text-gray-600 mb-2">Merk: <?= htmlspecialchars($row['merk']) ?></p>
                        <p class="text-gray-600 mb-2">Kondisi: <?= htmlspecialchars($row['kondisi']) ?></p>
                        <p class="text-blue-600 font-bold text-xl mb-2">
                            Rp <?= number_format($row['harga'], 0, ',', '.') ?> /hari
                        </p>
                        <p class="text-gray-600 mb-4">Stok: <?= $row['stok'] ?> unit</p>
                        
                        <?php if($is_login && $row['stok'] > 0): ?>
                            <a href="peminjaman.php?id=<?= $row['id_barang'] ?>" 
                               class="block text-center bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
                                Pinjam Sekarang
                            </a>
                        <?php elseif(!$is_login): ?>
                            <button disabled 
                                    class="block text-center bg-gray-400 text-white py-2 rounded cursor-not-allowed">
                                Login untuk Meminjam
                            </button>
                        <?php else: ?>
                            <button disabled 
                                    class="block text-center bg-red-400 text-white py-2 rounded cursor-not-allowed">
                                Stok Habis
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
