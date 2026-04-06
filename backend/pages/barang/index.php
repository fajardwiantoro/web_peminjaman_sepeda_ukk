<?php
require_once __DIR__ . '/../../app.php';
$data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang DESC");
?>

<?php include '../../partials/header.php'; ?>
<body>

<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand">
                <img src="../../template/assets/images/logo-full.png" class="logo logo-lg" />
                <img src="../../template/assets/images/logo-abbr.png" class="logo logo-sm" />
            </a>
        </div>
        <?php include '../../partials/sidebar.php'; ?>
    </div>
</nav>

<?php include '../../partials/navbar.php'; ?>

<style>
/* Custom CSS untuk Halaman Barang dengan Warna-warna Menarik */

/* Background Putih untuk Main Content */
.nxl-content {
    background: #f8fafc;
    min-height: 100vh;
    padding-left: 250px;
    padding-top: 100px;
    padding-right: 20px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

/* Efek Pattern Halus */
.nxl-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: radial-gradient(circle at 1px 1px, rgba(102, 126, 234, 0.05) 1px, transparent 0);
    background-size: 40px 40px;
    pointer-events: none;
}

/* Tombol Tambah Barang dengan Gradient */
.btn-primary {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.95rem;
    box-shadow: 0 5px 20px rgba(238, 90, 36, 0.4);
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
    overflow: hidden;
    margin-bottom: 25px;
    border: 2px solid rgba(255,255,255,0.2);
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
    z-index: -1;
}

.btn-primary:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 25px rgba(238, 90, 36, 0.5);
    background: linear-gradient(135deg, #ff8b8b 0%, #ff6a3a 100%);
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary i {
    margin-right: 8px;
    font-size: 1.1rem;
}

/* Modern Card Style */
.card {
    border: none;
    border-radius: 25px;
    background: white;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    animation: slideInUp 0.6s ease;
    overflow: hidden;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Card Body */
.card-body {
    padding: 2rem;
    background: white;
}

/* Modern Table Style */
.table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0 10px;
    width: 100%;
}

/* Table Header dengan Gradient */
.table thead {
    border-radius: 15px;
    overflow: hidden;
}

.table thead th {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
    padding: 15px 12px;
    border: none;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
    white-space: nowrap;
}

.table thead th::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255,255,255,0.1);
    transform: rotate(45deg);
    animation: headerShine 3s infinite;
}

@keyframes headerShine {
    0% {
        transform: translateX(-100%) rotate(45deg);
    }
    20%, 100% {
        transform: translateX(100%) rotate(45deg);
    }
}

.table thead th:first-child {
    border-radius: 15px 0 0 15px;
    padding-left: 20px;
}

.table thead th:last-child {
    border-radius: 0 15px 15px 0;
    padding-right: 20px;
}

/* Table Body Rows */
.table tbody tr {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    animation: fadeIn 0.5s ease;
    animation-fill-mode: both;
    position: relative;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Animation delay untuk setiap row */
.table tbody tr:nth-child(1) { animation-delay: 0.1s; }
.table tbody tr:nth-child(2) { animation-delay: 0.15s; }
.table tbody tr:nth-child(3) { animation-delay: 0.2s; }
.table tbody tr:nth-child(4) { animation-delay: 0.25s; }
.table tbody tr:nth-child(5) { animation-delay: 0.3s; }
.table tbody tr:nth-child(6) { animation-delay: 0.35s; }
.table tbody tr:nth-child(7) { animation-delay: 0.4s; }
.table tbody tr:nth-child(8) { animation-delay: 0.45s; }
.table tbody tr:nth-child(9) { animation-delay: 0.5s; }
.table tbody tr:nth-child(10) { animation-delay: 0.55s; }

.table tbody tr:hover {
    transform: translateY(-5px) scale(1.01);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.15);
    background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
    border-color: rgba(102, 126, 234, 0.3);
}

.table tbody td {
    padding: 15px 12px;
    vertical-align: middle;
    border: none;
    color: #2d3748;
    font-weight: 500;
    background: transparent;
}

.table tbody td:first-child {
    border-radius: 15px 0 0 15px;
    padding-left: 20px;
    font-weight: 700;
    color: #667eea;
    background: linear-gradient(135deg, rgba(102,126,234,0.05) 0%, transparent 100%);
}

.table tbody td:last-child {
    border-radius: 0 15px 15px 0;
    padding-right: 20px;
}

/* Styling untuk Foto */
.table tbody td img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 3px solid white;
}

.table tbody td img:hover {
    transform: scale(1.5);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    z-index: 100;
    position: relative;
}

/* Badge untuk Kondisi */
.condition-badge {
    display: inline-block;
    padding: 6px 15px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-size: 200% auto;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.condition-badge.baik {
    background: linear-gradient(45deg, #84fab0 0%, #8fd3f4 50%, #84fab0 100%);
    animation: gradientShift 3s ease infinite;
}

.condition-badge.rusak {
    background: linear-gradient(45deg, #f43b47 0%, #453a94 50%, #f43b47 100%);
    animation: gradientShift 3s ease infinite;
}

.condition-badge.hilang {
    background: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 50%, #ff9a9e 100%);
    animation: gradientShift 3s ease infinite;
}

.condition-badge.dipinjam {
    background: linear-gradient(45deg, #f6d365 0%, #fda085 50%, #f6d365 100%);
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

/* Styling untuk Jumlah */
.quantity-badge {
    display: inline-block;
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(102,126,234,0.3);
}

/* Gradient Buttons untuk Aksi */
.btn-warning {
    background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    border: none;
    color: white;
    border-radius: 20px;
    padding: 6px 15px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 3px 10px rgba(253, 160, 133, 0.3);
    transition: all 0.3s ease;
    margin-right: 5px;
    position: relative;
    overflow: hidden;
}

.btn-warning::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.5s, height 0.5s;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(253, 160, 133, 0.5);
    color: white;
}

.btn-warning:hover::before {
    width: 200px;
    height: 200px;
}

.btn-danger {
    background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
    border: none;
    color: white;
    border-radius: 20px;
    padding: 6px 15px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 3px 10px rgba(255, 154, 158, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-danger::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.5s, height 0.5s;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 154, 158, 0.5);
    color: white;
}

.btn-danger:hover::before {
    width: 200px;
    height: 200px;
}

/* Styling untuk Keterangan */
.keterangan-text {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 5px 10px;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 20px;
    color: #4a5568;
    font-size: 0.9rem;
    border-left: 3px solid #667eea;
}

/* Tooltip untuk Keterangan */
.keterangan-text:hover {
    white-space: normal;
    overflow: visible;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    position: absolute;
    max-width: 300px;
    z-index: 1000;
    padding: 10px;
    border-radius: 10px;
    margin-top: -10px;
}

/* Empty State */
.text-center.py-4 {
    padding: 40px !important;
    background: white;
    border-radius: 15px;
    border: 1px dashed #667eea;
}

.text-center.py-4 i {
    font-size: 64px;
    color: #667eea;
    opacity: 0.5;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    60% {
        transform: translateY(-10px);
    }
}

/* Floating Animation untuk Card */
@keyframes float {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-8px);
    }
    100% {
        transform: translateY(0px);
    }
}

.card:hover {
    animation: float 4s ease infinite;
}

/* Responsive Design */
@media (max-width: 768px) {
    .nxl-content {
        padding-left: 20px;
        padding-top: 80px;
    }
    
    .table thead {
        display: none;
    }
    
    .table tbody tr {
        display: block;
        margin-bottom: 20px;
        padding: 15px;
    }
    
    .table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: right;
        padding: 10px 15px;
        border-bottom: 1px solid rgba(102,126,234,0.1);
    }
    
    .table tbody td:last-child {
        border-bottom: none;
    }
    
    .table tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #667eea;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    
    .table tbody td img {
        margin-left: auto;
    }
    
    .btn-primary {
        width: 100%;
        margin-bottom: 15px;
    }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}

/* Tooltip Style */
[data-tooltip] {
    position: relative;
    cursor: pointer;
}

[data-tooltip]:before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    padding: 5px 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 5px;
    font-size: 0.75rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102,126,234,0.3);
    z-index: 1000;
}

[data-tooltip]:hover:before {
    opacity: 1;
    visibility: visible;
    bottom: 120%;
}

/* Header Section */
.page-header {
    margin-bottom: 25px;
}

.page-header h5 {
    color: #2d3748;
    font-weight: 700;
    margin: 0;
    font-size: 1.5rem;
}

.page-header p {
    color: #667eea;
    margin: 5px 0 0 0;
    font-size: 0.95rem;
}
</style>

<main class="container">
    <div class="nxl-content" style="padding-left: 230px; padding-top: 100px">

        <div class="page-header">
            <h5>Data Barang</h5>
            <p>Kelola data barang inventaris</p>
        </div>

        <a href="tambah.php" class="btn btn-primary mb-3">
            <i class="feather icon-plus-circle"></i> Tambah Barang
        </a>

        <div class="card">
            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>type</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(mysqli_num_rows($data) > 0): ?>
                            <?php $no=1; while($b=mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td data-label="No"><?= $no++ ?></td>

                                <!-- FOTO -->
                                <td data-label="Foto">
                                    <?php if(!empty($b['foto'])): ?>
                                        <img src="../../../storage/barang/<?= $b['foto'] ?>"
                                             width="60" height="60"
                                             style="object-fit:cover; border-radius:12px;"
                                             alt="Foto Barang"
                                             data-tooltip="Klik untuk memperbesar">
                                    <?php else: ?>
                                        <div style="width:60px; height:60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius:12px; display:flex; align-items:center; justify-content:center; color:white; font-size:20px;">
                                            <i class="feather icon-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td data-label="Nama Barang">
                                    <strong><?= htmlspecialchars($b['nama_barang']) ?></strong>
                                </td>
                                <td data-label="type">
                                    <strong><?= htmlspecialchars($b['type']) ?></strong>
                                </td>
                                

                                <td data-label="Jumlah">
                                    <span class="quantity-badge">
                                        <?= $b['jumlah'] ?>
                                    </span>
                                </td>

                                <td data-label="Kondisi">
                                    <?php 
                                    $kondisi = strtolower($b['kondisi']);
                                    $badgeClass = 'baik';
                                    if(strpos($kondisi, 'rusak') !== false) $badgeClass = 'rusak';
                                    elseif(strpos($kondisi, 'hilang') !== false) $badgeClass = 'hilang';
                                    elseif(strpos($kondisi, 'pinjam') !== false) $badgeClass = 'dipinjam';
                                    ?>
                                    <span class="condition-badge <?= $badgeClass ?>">
                                        <?= htmlspecialchars($b['kondisi']) ?>
                                    </span>
                                </td>

                                <td data-label="Keterangan">
                                    <?php if(!empty($b['keterangan'])): ?>
                                        <div class="keterangan-text" title="<?= htmlspecialchars($b['keterangan']) ?>">
                                            <?= htmlspecialchars($b['keterangan']) ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <td data-label="Aksi">
                                    <a href="edit.php?id=<?= $b['id_barang'] ?>"
                                       class="btn btn-warning btn-sm"
                                       data-tooltip="Edit Barang">
                                        <i class="feather icon-edit"></i> Edit
                                    </a>

                                    <a href="hapus.php?id=<?= $b['id_barang'] ?>"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')"
                                       class="btn btn-danger btn-sm"
                                       data-tooltip="Hapus Barang">
                                        <i class="feather icon-trash-2"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="feather icon-package"></i>
                                    <p class="mt-2">Belum ada data barang</p>
                                    <a href="tambah.php" class="btn btn-primary btn-sm mt-2">
                                        <i class="feather icon-plus-circle"></i> Tambah Barang
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</main>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>

<!-- Tambahkan Font Awesome untuk ikon tambahan -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</body>
</html>