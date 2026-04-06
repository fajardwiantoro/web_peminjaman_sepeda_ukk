<?php
session_start();
require_once __DIR__ . '/backend/app.php';

if (!isset($_SESSION['login'])) {
    header("Location: backend/auth/login.php");
    exit;
}

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$id'");
$b = mysqli_fetch_assoc($query);

if (!$b) {
    echo "<script>alert('Barang tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// ✅ PENTING: Cek apakah kolom harga ada, jika tidak set default 0
$harga_barang = 0;
if (isset($b['harga'])) {
    $harga_barang = $b['harga'];
}

$my_id = $_SESSION['id_user'];
$my_nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa <?= $b['nama_barang'] ?> - JuraganSepeda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-['Plus_Jakarta_Sans'] text-slate-800">

    <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="index.php" class="text-emerald-600 font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Kembali
            </a>
            <span class="font-bold text-slate-900">Form Penyewaan</span>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <img src="storage/barang/<?= $b['foto'] ?>" class="w-full h-64 object-cover bg-slate-100">
                    <div class="p-6">
                        <h1 class="text-2xl font-extrabold text-slate-900 mb-2"><?= $b['nama_barang'] ?></h1>
                        
                        <!-- ✅ MENAMPILKAN HARGA DENGAN PENGECEKAN -->
                        <div class="mb-4">
                            <?php if($harga_barang > 0): ?>
                                <div class="inline-flex items-center gap-2 bg-emerald-100 px-4 py-2 rounded-xl">
                                    <span class="text-emerald-600 font-bold text-xl">Rp <?= number_format($harga_barang, 0, ',', '.') ?></span>
                                    <span class="text-slate-500 text-sm">/hari</span>
                                </div>
                            <?php else: ?>
                                <div class="inline-flex items-center gap-2 bg-slate-100 px-4 py-2 rounded-xl">
                                    <span class="text-slate-500">Harga belum ditentukan</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-slate-600 text-sm"><?= nl2br($b['keterangan']) ?></p>
                        
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-2 text-sm">
                                <span class="font-medium">Stok:</span>
                                <span class="text-emerald-600 font-bold"><?= $b['jumlah'] ?> Unit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-8">
                    <form action="backend/peminjaman/proses_tambah.php" method="POST" class="space-y-5">
                        <input type="hidden" name="id_barang" value="<?= $b['id_barang'] ?>">

                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-500">Peminjam Atas Nama</label>
                            <input type="text" 
                                   value="<?= $my_nama ?>" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed outline-none" 
                                   readonly>
                            <input type="hidden" name="id_user" value="<?= $my_id ?>">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold mb-2">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tgl_pinjam" value="<?= date('Y-m-d') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Tanggal Kembali</label>
                                <input type="date" name="tanggal_kembali" id="tgl_kembali" class="w-full px-4 py-3 rounded-xl border border-slate-200" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Jumlah Unit</label>
                            <input type="number" name="jumlah" id="jumlah" min="1" max="<?= $b['jumlah'] ?>" value="1" class="w-full px-4 py-3 rounded-xl border border-slate-200" required>
                        </div>

                        <!-- ✅ MENAMPILKAN TOTAL BIAYA -->
                        <?php if($harga_barang > 0): ?>
                        <div class="bg-emerald-50 rounded-2xl p-5">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-slate-600">Harga per hari</span>
                                <span class="font-semibold">Rp <?= number_format($harga_barang, 0, ',', '.') ?></span>
                            </div>
                            <div class="flex justify-between items-center mb-2" id="total_hari_row">
                                <span class="text-slate-600">Total hari</span>
                                <span class="font-semibold" id="total_hari">0</span>
                            </div>
                            <div class="flex justify-between items-center mb-2" id="total_unit_row">
                                <span class="text-slate-600">Jumlah unit</span>
                                <span class="font-semibold" id="total_unit">0</span>
                            </div>
                            <div class="border-t border-emerald-200 my-3"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">Total Biaya</span>
                                <span class="text-2xl font-extrabold text-emerald-600" id="total_biaya">Rp 0</span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl transition">
                            Konfirmasi Pinjaman Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        const tglPinjam = document.getElementById('tgl_pinjam');
        const tglKembali = document.getElementById('tgl_kembali');
        const jumlah = document.getElementById('jumlah');
        const hargaPerHari = <?= $harga_barang ?>;
        
        const totalHariSpan = document.getElementById('total_hari');
        const totalUnitSpan = document.getElementById('total_unit');
        const totalBiayaSpan = document.getElementById('total_biaya');
        
        function hitungTotal() {
            if (tglPinjam.value && tglKembali.value && jumlah.value && hargaPerHari > 0) {
                const date1 = new Date(tglPinjam.value);
                const date2 = new Date(tglKembali.value);
                const diffTime = Math.abs(date2 - date1);
                const totalHari = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                const totalUnit = parseInt(jumlah.value);
                const total = totalHari * totalUnit * hargaPerHari;
                
                totalHariSpan.textContent = totalHari;
                totalUnitSpan.textContent = totalUnit;
                totalBiayaSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        }
        
        tglPinjam.addEventListener('change', function() {
            tglKembali.min = this.value;
            if (tglKembali.value < this.value) tglKembali.value = this.value;
            hitungTotal();
        });
        
        tglKembali.addEventListener('change', hitungTotal);
        jumlah.addEventListener('input', function() {
            if (this.value > <?= $b['jumlah'] ?>) {
                this.value = <?= $b['jumlah'] ?>;
                alert('Stok hanya <?= $b['jumlah'] ?> unit');
            }
            hitungTotal();
        });
        
        // Set default tanggal kembali
        if (!tglKembali.value) {
            const defaultTgl = new Date(tglPinjam.value);
            defaultTgl.setDate(defaultTgl.getDate() + 1);
            tglKembali.value = defaultTgl.toISOString().split('T')[0];
        }
        
        hitungTotal();
    </script>
</body>
</html>