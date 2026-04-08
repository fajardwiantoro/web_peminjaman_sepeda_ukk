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
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Alat Sepeda Premium - Juragansepeda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Efek 3D untuk elemen tertentu */
        .shadow-3d {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
        }
        
        .btn-3d {
            transform: translateY(0);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-3d:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 30px -10px rgba(37, 99, 235, 0.5);
        }
        
        .card-3d {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card-3d:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 40px -15px rgba(37, 99, 235, 0.4), 0 0 0 2px rgba(59, 130, 246, 0.2) inset;
        }
        
        /* Animasi sepeda 3D berputar */
        @keyframes floatBicycle {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        
        @keyframes floatBicycleReverse {
            0% { transform: translateY(0px) rotate(0deg) scaleX(-1); }
            50% { transform: translateY(-15px) rotate(-2deg) scaleX(-1); }
            100% { transform: translateY(0px) rotate(0deg) scaleX(-1); }
        }
        
        .bicycle-3d {
            animation: floatBicycle 6s ease-in-out infinite;
            filter: drop-shadow(0 20px 15px rgba(0, 0, 0, 0.4));
        }
        
        .bicycle-3d-reverse {
            animation: floatBicycleReverse 7s ease-in-out infinite;
            filter: drop-shadow(0 20px 15px rgba(0, 0, 0, 0.4));
        }
        
        /* Efek siluet sepeda di background */
        .bicycle-silhouette {
            opacity: 0.1;
            transition: opacity 0.5s, transform 0.5s;
        }
        
        .bicycle-silhouette:hover {
            opacity: 0.2;
            transform: scale(1.1);
        }
        
        /* Style untuk harga */
        .price-tag {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            position: relative;
            overflow: hidden;
        }
        
        .price-tag::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-blue-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="bg-blue-600 p-2 rounded-lg shadow-lg shadow-blue-300/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v12"/><path d="M6 12h12"/></svg>
                    </div>
                    <span class="font-extrabold text-2xl text-slate-900 tracking-tight">JuraganSepeda<span class="text-blue-600">.</span></span>
                </div>

                <div class="flex items-center gap-8">
                    <div class="hidden md:flex items-center gap-6">
                        <a href="#paket" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Katalog Alat</a>
                        <a href="#cara-sewa" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Prosedur</a>
                    </div>

                    <?php if($is_login): ?>
                        <div class="relative group">
                            <button class="flex items-center gap-3 bg-slate-50 border border-blue-200 p-1 pr-4 rounded-full hover:bg-blue-50 transition shadow-md hover:shadow-blue-200">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-md shadow-blue-300 overflow-hidden">
                                    <?php if(!empty($_SESSION['foto'])): ?>
                                        <img src="storage/user/<?= $_SESSION['foto'] ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?>
                                    <?php endif; ?>
                                </div>
                                <span class="text-sm font-bold text-slate-700"><?= explode(' ', $_SESSION['nama'])[0] ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            
                            <div class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-2xl shadow-xl border border-blue-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <a href="riwayat_pinjam.php" class="block px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition">Riwayat Sewa</a>
                                <hr class="my-2 border-slate-50">
                                <a href="backend/auth/logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold transition">Keluar Akun</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="backend/auth/login.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full text-sm font-bold transition duration-300 shadow-lg shadow-blue-300 btn-3d">
                            Masuk / Daftar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-36 overflow-hidden">
        <!-- Background dengan gradien biru 3D dan sepeda -->
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-blue-800 via-blue-900 to-indigo-950">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-400/20 via-transparent to-transparent"></div>
            
            <!-- Efek 3D grid -->
            <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(to right, #3b82f6 1px, transparent 1px), linear-gradient(to bottom, #3b82f6 1px, transparent 1px); background-size: 50px 50px;"></div>
            
            <!-- Sepeda 3D di background - Kiri atas -->
            <div class="absolute top-20 left-10 w-64 h-64 bicycle-3d opacity-30 hidden lg:block">
                <svg viewBox="0 0 100 100" class="w-full h-full text-blue-300 fill-current">
                    <g transform="translate(10, 10)">
                        <!-- Roda belakang -->
                        <circle cx="30" cy="70" r="20" stroke="currentColor" stroke-width="3" fill="none"/>
                        <circle cx="30" cy="70" r="5" stroke="currentColor" stroke-width="2" fill="currentColor"/>
                        <line x1="20" y1="60" x2="40" y2="80" stroke="currentColor" stroke-width="2"/>
                        <line x1="40" y1="60" x2="20" y2="80" stroke="currentColor" stroke-width="2"/>
                        
                        <!-- Roda depan -->
                        <circle cx="70" cy="70" r="20" stroke="currentColor" stroke-width="3" fill="none"/>
                        <circle cx="70" cy="70" r="5" stroke="currentColor" stroke-width="2" fill="currentColor"/>
                        <line x1="60" y1="60" x2="80" y2="80" stroke="currentColor" stroke-width="2"/>
                        <line x1="80" y1="60" x2="60" y2="80" stroke="currentColor" stroke-width="2"/>
                        
                        <!-- Frame sepeda -->
                        <line x1="30" y1="50" x2="50" y2="30" stroke="currentColor" stroke-width="4"/>
                        <line x1="50" y1="30" x2="70" y2="50" stroke="currentColor" stroke-width="4"/>
                        <line x1="30" y1="50" x2="70" y2="50" stroke="currentColor" stroke-width="4"/>
                        <line x1="40" y1="50" x2="30" y2="70" stroke="currentColor" stroke-width="3"/>
                        <line x1="60" y1="50" x2="70" y2="70" stroke="currentColor" stroke-width="3"/>
                        
                        <!-- Stang -->
                        <line x1="70" y1="50" x2="85" y2="40" stroke="currentColor" stroke-width="3"/>
                        <circle cx="90" cy="37" r="3" fill="currentColor"/>
                        
                        <!-- Sadel -->
                        <rect x="40" y="25" width="20" height="10" rx="5" stroke="currentColor" stroke-width="2" fill="currentColor" opacity="0.7"/>
                    </g>
                </svg>
            </div>
            
            <!-- Sepeda 3D di background - Kanan bawah -->
            <div class="absolute bottom-20 right-10 w-80 h-80 bicycle-3d-reverse opacity-20 hidden lg:block">
                <svg viewBox="0 0 100 100" class="w-full h-full text-blue-200 fill-current">
                    <g transform="translate(10, 10)">
                        <!-- Roda belakang -->
                        <circle cx="30" cy="70" r="20" stroke="currentColor" stroke-width="3" fill="none"/>
                        <circle cx="30" cy="70" r="5" stroke="currentColor" stroke-width="2" fill="currentColor"/>
                        <line x1="20" y1="60" x2="40" y2="80" stroke="currentColor" stroke-width="2"/>
                        <line x1="40" y1="60" x2="20" y2="80" stroke="currentColor" stroke-width="2"/>
                        
                        <!-- Roda depan -->
                        <circle cx="70" cy="70" r="20" stroke="currentColor" stroke-width="3" fill="none"/>
                        <circle cx="70" cy="70" r="5" stroke="currentColor" stroke-width="2" fill="currentColor"/>
                        <line x1="60" y1="60" x2="80" y2="80" stroke="currentColor" stroke-width="2"/>
                        <line x1="80" y1="60" x2="60" y2="80" stroke="currentColor" stroke-width="2"/>
                        
                        <!-- Frame sepeda -->
                        <line x1="30" y1="50" x2="50" y2="30" stroke="currentColor" stroke-width="4"/>
                        <line x1="50" y1="30" x2="70" y2="50" stroke="currentColor" stroke-width="4"/>
                        <line x1="30" y1="50" x2="70" y2="50" stroke="currentColor" stroke-width="4"/>
                        <line x1="40" y1="50" x2="30" y2="70" stroke="currentColor" stroke-width="3"/>
                        <line x1="60" y1="50" x2="70" y2="70" stroke="currentColor" stroke-width="3"/>
                        
                        <!-- Stang -->
                        <line x1="70" y1="50" x2="85" y2="40" stroke="currentColor" stroke-width="3"/>
                        <circle cx="90" cy="37" r="3" fill="currentColor"/>
                        
                        <!-- Sadel -->
                        <rect x="40" y="25" width="20" height="10" rx="5" stroke="currentColor" stroke-width="2" fill="currentColor" opacity="0.7"/>
                    </g>
                </svg>
            </div>
            
            <!-- Sepeda 3D di background - Tengah kiri -->
            <div class="absolute top-1/2 left-20 w-48 h-48 bicycle-3d opacity-25 hidden lg:block" style="animation-delay: -2s;">
                <svg viewBox="0 0 100 100" class="w-full h-full text-blue-400 fill-current">
                    <g transform="translate(10, 10)">
                        <!-- Roda belakang -->
                        <circle cx="30" cy="70" r="20" stroke="currentColor" stroke-width="3" fill="none"/>
                        <circle cx="30" cy="70" r="5" stroke="currentColor" stroke-width="2" fill="currentColor"/>
                        <line x1="20" y1="60" x2="40" y2="80" stroke="currentColor" stroke-width="2"/>
                        <line x1="40" y1="60" x2="20" y2="80" stroke="currentColor" stroke-width="2"/>
                        
                        <!-- Roda depan -->
                        <circle cx="70" cy="70" r="20" stroke="currentColor" stroke-width="3" fill="none"/>
                        <circle cx="70" cy="70" r="5" stroke="currentColor" stroke-width="2" fill="currentColor"/>
                        <line x1="60" y1="60" x2="80" y2="80" stroke="currentColor" stroke-width="2"/>
                        <line x1="80" y1="60" x2="60" y2="80" stroke="currentColor" stroke-width="2"/>
                        
                        <!-- Frame sepeda -->
                        <line x1="30" y1="50" x2="50" y2="30" stroke="currentColor" stroke-width="4"/>
                        <line x1="50" y1="30" x2="70" y2="50" stroke="currentColor" stroke-width="4"/>
                        <line x1="30" y1="50" x2="70" y2="50" stroke="currentColor" stroke-width="4"/>
                        <line x1="40" y1="50" x2="30" y2="70" stroke="currentColor" stroke-width="3"/>
                        <line x1="60" y1="50" x2="70" y2="70" stroke="currentColor" stroke-width="3"/>
                        
                        <!-- Stang -->
                        <line x1="70" y1="50" x2="85" y2="40" stroke="currentColor" stroke-width="3"/>
                        <circle cx="90" cy="37" r="3" fill="currentColor"/>
                        
                        <!-- Sadel -->
                        <rect x="40" y="25" width="20" height="10" rx="5" stroke="currentColor" stroke-width="2" fill="currentColor" opacity="0.7"/>
                    </g>
                </svg>
            </div>
            
            <!-- Sepeda 3D kecil - Tersebar (untuk efek lebih ramai) -->
            <div class="absolute bottom-40 left-1/4 w-32 h-32 bicycle-3d opacity-15 hidden lg:block" style="animation-duration: 5s;">
                <svg viewBox="0 0 100 100" class="w-full h-full text-blue-500 fill-current">
                    <circle cx="30" cy="70" r="15" stroke="currentColor" stroke-width="2" fill="none"/>
                    <circle cx="70" cy="70" r="15" stroke="currentColor" stroke-width="2" fill="none"/>
                    <line x1="30" y1="55" x2="70" y2="55" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            
            <div class="absolute top-40 right-1/3 w-40 h-40 bicycle-3d-reverse opacity-10 hidden lg:block" style="animation-duration: 8s; animation-delay: -1s;">
                <svg viewBox="0 0 100 100" class="w-full h-full text-blue-200 fill-current">
                    <circle cx="30" cy="70" r="15" stroke="currentColor" stroke-width="2" fill="none"/>
                    <circle cx="70" cy="70" r="15" stroke="currentColor" stroke-width="2" fill="none"/>
                    <line x1="30" y1="55" x2="70" y2="55" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            
            <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-transparent to-transparent"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
            <span class="inline-flex items-center gap-2 py-2 px-4 rounded-full bg-white/10 border border-white/20 text-blue-100 text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                Sewa Alat sepeda Terlengkap 2026
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-8">
                AYO BERSEPEDA, <br>
                <span class="text-blue-400 drop-shadow-[0_4px_4px_rgba(0,0,0,0.3)]">Urusan Alat Kami Tangani.</span>
            </h1>
            <p class="text-lg md:text-xl text-blue-100/80 max-w-2xl mx-auto mb-12 leading-relaxed">
                Sewa full set sepeda kualitas premium, suara garing, dan sudah dituning rapi oleh ahli. Tanpa ribet, alat siap tempur!
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#paket" class="bg-blue-500 hover:bg-blue-400 text-white px-10 py-4 rounded-full font-bold text-lg transition duration-300 shadow-2xl shadow-blue-500/50 btn-3d border-b-4 border-blue-700 hover:border-blue-500">
                    Mulai Sewa Alat
                </a>
                <a href="#cara-sewa" class="bg-white/10 hover:bg-white/20 text-white border border-white/30 px-10 py-4 rounded-full font-bold text-lg transition duration-300 backdrop-blur-sm border-b-4 border-white/10">
                    Lihat Prosedur
                </a>
            </div>
        </div>
    </section>

    <section id="paket" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="max-w-xl text-left">
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Katalog Alat Tersedia</h2>
                    <p class="text-slate-500 italic">Pilih alat yang Anda butuhkan. Semua alat kami rawat secara rutin untuk menjamin kualitas suara.</p>
                </div>
                <div class="bg-slate-100 p-1 rounded-xl flex">
                    <button class="px-6 py-2 bg-white text-blue-600 rounded-lg shadow-sm text-sm font-bold">Semua</button>
                    <button class="px-6 py-2 text-slate-500 text-sm font-bold hover:text-slate-700">Set Lengkap</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php while($b = mysqli_fetch_assoc($data_barang)): ?>
                <div class="group bg-white rounded-[2rem] overflow-hidden border border-blue-100 shadow-md hover:shadow-2xl hover:shadow-blue-400/30 transition-all duration-500 flex flex-col card-3d">
                    <div class="h-64 bg-slate-100 overflow-hidden relative">
                        <?php if(!empty($b['foto'])): ?>
                            <img src="storage/barang/<?= $b['foto'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <?php else: ?>
                            <div class="flex items-center justify-center h-full bg-slate-200 text-slate-400 font-bold uppercase tracking-widest text-xs">Foto Tidak Tersedia</div>
                        <?php endif; ?>
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur text-blue-700 text-[10px] font-black uppercase rounded-lg shadow-md border border-blue-200">
                                Stok: <?= $b['jumlah'] ?> Unit
                            </span>
                        </div>
                    </div>
                    <div class="p-8 flex-grow">
                        <h3 class="text-xl font-extrabold text-slate-900 mb-2"><?= $b['nama_barang'] ?></h3>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-4 tracking-wider">Kondisi: <span class="text-blue-600"><?= $b['kondisi'] ?></span></p>
                        
                        <!-- TAMBAHAN LABEL HARGA DI SINI -->
                        <div class="mb-6">
                            <?php if(!empty($b['harga']) && $b['harga'] > 0): ?>
                                <div class="inline-flex items-center gap-2 price-tag px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 12H4M12 4v16M4 8h16M4 16h16"/>
                                        <circle cx="12" cy="12" r="2"/>
                                    </svg>
                                    <span class="font-bold text-lg">Rp <?= number_format($b['harga'], 0, ',', '.') ?></span>
                                    <span class="text-xs opacity-90">/hari</span>
                                </div>
                            <?php else: ?>
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-500 border border-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 12H4M12 4v16M4 8h16M4 16h16"/>
                                        <circle cx="12" cy="12" r="2"/>
                                    </svg>
                                    <span class="font-medium">Harga belum tersedia</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-slate-500 text-sm mb-8 line-clamp-2 leading-relaxed italic">"<?= $b['keterangan'] ?>"</p>
                        
                        <a href="detail_barang.php?id=<?= $b['id_barang'] ?>" class="flex items-center justify-center gap-2 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition duration-300 group-hover:shadow-xl group-hover:shadow-blue-300 btn-3d border-b-4 border-blue-800 hover:border-blue-600">
                            Cek Detail & Sewa
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section id="cara-sewa" class="py-24 bg-gradient-to-b from-blue-50 to-white border-t border-blue-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-16">Alur Penyewaan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <div class="hidden md:block absolute top-12 left-1/4 right-1/4 h-0.5 bg-gradient-to-r from-blue-300 via-blue-500 to-blue-300"></div>
                
                <div class="relative group card-3d">
                    <div class="w-20 h-20 bg-white border-4 border-blue-300 text-blue-600 font-black text-2xl rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-3 group-hover:rotate-0 transition duration-300 shadow-xl shadow-blue-400/30">1</div>
                    <h4 class="font-extrabold text-lg text-slate-900">Pilih Alat</h4>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Cari alat yang dibutuhkan di katalog kami dan klik Detail.</p>
                </div>
                <div class="relative group card-3d">
                    <div class="w-20 h-20 bg-blue-600 text-white font-black text-2xl rounded-3xl flex items-center justify-center mx-auto mb-6 -rotate-3 group-hover:rotate-0 transition duration-300 shadow-xl shadow-blue-500/50 border-b-4 border-blue-800">2</div>
                    <h4 class="font-extrabold text-lg text-slate-900">Isi Form & Verifikasi</h4>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Lengkapi data diri dan tentukan tanggal peminjaman.</p>
                </div>
                <div class="relative group card-3d">
                    <div class="w-20 h-20 bg-white border-4 border-blue-300 text-blue-600 font-black text-2xl rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-3 group-hover:rotate-0 transition duration-300 shadow-xl shadow-blue-400/30">3</div>
                    <h4 class="font-extrabold text-lg text-slate-900">Ambil & Bayar</h4>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Cetak bukti sewa, ambil alat ke toko, dan bayar di tempat.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gradient-to-b from-blue-900 to-indigo-950 text-blue-200 py-20 relative overflow-hidden">
        <!-- Efek 3D grid di footer -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, #60a5fa 1px, transparent 0); background-size: 40px 40px;"></div>
        
        <!-- Sepeda kecil di footer -->
        <div class="absolute bottom-10 left-10 w-24 h-24 bicycle-3d opacity-20 hidden lg:block">
            <svg viewBox="0 0 100 100" class="w-full h-full text-blue-400 fill-current">
                <circle cx="30" cy="70" r="15" stroke="currentColor" stroke-width="2" fill="none"/>
                <circle cx="70" cy="70" r="15" stroke="currentColor" stroke-width="2" fill="none"/>
                <line x1="30" y1="55" x2="70" y2="55" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        
        <div class="absolute top-10 right-10 w-32 h-32 bicycle-3d-reverse opacity-20 hidden lg:block">
            <svg viewBox="0 0 100 100" class="w-full h-full text-blue-300 fill-current">
                <circle cx="30" cy="70" r="15" stroke="currentColor" stroke-width="2" fill="none"/>
                <circle cx="70" cy="70" r="15" stroke="currentColor" stroke-width="2" fill="none"/>
                <line x1="30" y1="55" x2="70" y2="55" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        
        <div class="absolute inset-0 bg-gradient-to-t from-indigo-950 via-transparent to-transparent"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="text-left">
                <h2 class="text-3xl font-extrabold text-white mb-6 leading-tight text-center md:text-left drop-shadow-lg">Amankan Tanggal Acara <br>Anda Sekarang!</h2>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="https://wa.me/6281234567890" class="flex-1 bg-blue-500 hover:bg-blue-400 text-white font-black px-8 py-5 rounded-2xl transition text-center shadow-2xl shadow-blue-500/40 btn-3d border-b-4 border-blue-700 hover:border-blue-500">
                        Chat Admin WA
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8 border-l border-blue-800 pl-0 md:pl-16">
                <div>
                    <h5 class="text-white font-bold mb-4 uppercase text-xs tracking-widest">Kontak</h5>
                    <p class="text-sm mb-2 text-blue-200">admin@juraganSepeda.com</p>
                    <p class="text-sm text-blue-200">+62 812 3456 7890</p>
                </div>
                <div>
                    <h5 class="text-white font-bold mb-4 uppercase text-xs tracking-widest">Lokasi</h5>
                    <p class="text-sm leading-relaxed text-blue-200">Jl. Sepeda No. 123, <br>Kota Pekalongan, Jateng.</p>
                </div>
            </div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 mt-20 pt-8 border-t border-blue-800 text-center text-xs font-bold tracking-widest uppercase opacity-70 text-blue-300">
            &copy; 2026 JuraganSepeda. All rights reserved.
        </div>
    </footer>

</body>
</html>
