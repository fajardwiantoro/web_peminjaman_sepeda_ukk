<?php
// WAJIB: Letakkan ini di baris 1, tanpa ada spasi atau baris kosong sebelumnya
session_start();

// Cek apakah user sudah login (opsional tapi disarankan)
if (!isset($_SESSION['login'])) {
    header("Location: ../../auth/login.php");
    exit;
}

// Baru sertakan file-file partial lainnya
include '../../partials/header.php'; 
?>

<?php include '../../partials/header.php'?>
<body>
    <!--! ================================================================ !-->
    <!--! [Start] Navigation Menu !-->
    <!--! ================================================================ !-->
    <nav class="nxl-navigation">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="index.html" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <img src="../../template/assets/images/logo-full.png" alt="" class="logo logo-lg" />
                    <img src="../../template/assets/images/logo-abbr.png" alt="" class="logo logo-sm" />
                </a>
            </div>
          <?php include '../../partials/sidebar.php'?>
    </nav>
    <!--! ================================================================ !-->
    <!--! [End]  Navigation Menu !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! [Start] Header !-->
    <!--! ================================================================ !-->
    <?php include '../../partials/navbar.php'?>
    <!--! ================================================================ !-->
    <!--! [End] Header !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard</h5>
                                <p class="m-b-0">Sistem Peminjaman Sepeda</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Statistik Card 1: Total User -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statustic-card gradient-card-1">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-card bg-white-20">
                                    <i class="feather icon-users text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h3 class="mb-0 text-white">42</h3>
                                    <span class="text-white-80">Total User</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Card 2: Sepeda Tersedia -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statustic-card gradient-card-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-card bg-white-20">
                                    <i class="feather icon-drum text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h3 class="mb-0 text-white">28</h3>
                                    <span class="text-white-80">Sepeda Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Card 3: Peminjaman Aktif -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statustic-card gradient-card-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-card bg-white-20">
                                    <i class="feather icon-calendar text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h3 class="mb-0 text-white">12</h3>
                                    <span class="text-white-80">Peminjaman Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Card 4: Pengembalian Terlambat -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statustic-card gradient-card-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-card bg-white-20">
                                    <i class="feather icon-clock text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h3 class="mb-0 text-white">3</h3>
                                    <span class="text-white-80">Terlambat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Grafik Peminjaman Bulanan -->
                <div class="col-xl-8 col-md-12">
                    <div class="card modern-card">
                        <div class="card-header modern-card-header">
                            <h5 class="gradient-text-primary">Statistik Peminjaman Bulanan</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Grafik Status Sepeda -->
                <div class="col-xl-4 col-md-12">
                    <div class="card modern-card">
                        <div class="card-header modern-card-header">
                            <h5 class="gradient-text-secondary">Status Sepeda</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="doughnutChart" height="250"></canvas>
                            <div class="text-center mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <span class="d-block"><i class="fas fa-circle text-success-grad"></i> Tersedia</span>
                                        <h5 class="mb-0">28</h5>
                                    </div>
                                    <div class="col-4">
                                        <span class="d-block"><i class="fas fa-circle text-warning-grad"></i> Dipinjam</span>
                                        <h5 class="mb-0">12</h5>
                                    </div>
                                    <div class="col-4">
                                        <span class="d-block"><i class="fas fa-circle text-danger-grad"></i> Rusak</span>
                                        <h5 class="mb-0">4</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Grafik Kategori Sepeda -->
                <div class="col-xl-6 col-md-12">
                    <div class="card modern-card">
                        <div class="card-header modern-card-header">
                            <h5 class="gradient-text-info">Kategori Sepeda</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Daftar Peminjaman Terbaru -->
                <div class="col-xl-6 col-md-12">
                    <div class="card modern-card">
                        <div class="card-header modern-card-header">
                            <h5 class="gradient-text-warning">Peminjaman Terbaru</h5>
                            <div class="card-header-right">
                                <a href="../peminjaman/index.php" class="btn btn-modern-primary">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover modern-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Peminjam</th>
                                            <th>Sepeda</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Ahmad Fauzi</td>
                                            <td>Sepeda Tril</td>
                                            <td>15 Jan 2024</td>
                                            <td><span class="badge badge-gradient-success">Aktif</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Siti Nurhaliza</td>
                                            <td>Sepeda Gunung</td>
                                            <td>14 Jan 2024</td>
                                            <td><span class="badge badge-gradient-success">Aktif</span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Budi Santoso</td>
                                            <td>roda sepeda</td>
                                            <td>12 Jan 2024</td>
                                            <td><span class="badge badge-gradient-danger">Terlambat</span></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Rina Amelia</td>
                                            <td>reem sepeda</td>
                                            <td>10 Jan 2024</td>
                                            <td><span class="badge badge-gradient-warning">Selesai</span></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Joko Widodo</td>
                                            <td>sedel sepeda</td>
                                            <td>08 Jan 2024</td>
                                            <td><span class="badge badge-gradient-warning">Selesai</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Chart Tren Pengguna -->
                <div class="col-xl-12">
                    <div class="card modern-card">
                        <div class="card-header modern-card-header">
                            <h5 class="gradient-text-primary">Tren Peminjaman 6 Bulan Terakhir</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
        <!-- [ Footer ] start -->
       <?php include '../../partials/footer.php'?>
        <!-- [ Footer ] end -->
    </main>
    <!--! ================================================================ !-->
    <!--! [End] Main Content !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! BEGIN: Theme Customizer !-->
    <!--! ================================================================ !-->
    <div class="theme-customizer">
        <div class="customizer-handle">
            <a href="javascript:void(0);" class="cutomizer-open-trigger bg-primary">
                <i class="feather-settings"></i>
            </a>
        </div>
        <div class="customizer-sidebar-wrapper">
            <div class="customizer-sidebar-header px-4 ht-80 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Theme Settings</h5>
                <a href="javascript:void(0);" class="cutomizer-close-trigger d-flex">
                    <i class="feather-x"></i>
                </a>
            </div>
            <div class="customizer-sidebar-body position-relative p-4" data-scrollbar-target="#psScrollbarInit">
                <!--! BEGIN: [Navigation] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set">
                    <label class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label" style="top: -12px">Navigation</label>
                    <div class="row g-2 theme-options-items app-navigation" id="appNavigationList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-navigation-light" name="app-navigation" value="1" data-app-navigation="app-navigation-light" checked />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-navigation-light">Light</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-navigation-dark" name="app-navigation" value="2" data-app-navigation="app-navigation-dark" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-navigation-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Navigation] !-->
                <!--! BEGIN: [Header] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set mt-5">
                    <label class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label" style="top: -12px">Header</label>
                    <div class="row g-2 theme-options-items app-header" id="appHeaderList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-header-light" name="app-header" value="1" data-app-header="app-header-light" checked />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-header-light">Light</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-header-dark" name="app-header" value="2" data-app-header="app-header-dark" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-header-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Header] !-->
                <!--! BEGIN: [Skins] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set">
                    <label class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label" style="top: -12px">Skins</label>
                    <div class="row g-2 theme-options-items app-skin" id="appSkinList">
                        <div class="col-6 text-center position-relative single-option light-button active">
                            <input type="radio" class="btn-check" id="app-skin-light" name="app-skin" value="1" data-app-skin="app-skin-light" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-skin-light">Light</label>
                        </div>
                        <div class="col-6 text-center position-relative single-option dark-button">
                            <input type="radio" class="btn-check" id="app-skin-dark" name="app-skin" value="2" data-app-skin="app-skin-dark" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-skin-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Skins] !-->
                <!--! BEGIN: [Typography] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-0 border border-gray-2 theme-options-set">
                    <label class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label" style="top: -12px">Typography</label>
                    <div class="row g-2 theme-options-items font-family" id="fontFamilyList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-lato" name="font-family" value="1" data-font-family="app-font-family-lato" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-lato">Lato</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-rubik" name="font-family" value="2" data-font-family="app-font-family-rubik" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-rubik">Rubik</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-inter" name="font-family" value="3" data-font-family="app-font-family-inter" checked />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-inter">Inter</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-cinzel" name="font-family" value="4" data-font-family="app-font-family-cinzel" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-cinzel">Cinzel</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-nunito" name="font-family" value="6" data-font-family="app-font-family-nunito" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-nunito">Nunito</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-roboto" name="font-family" value="7" data-font-family="app-font-family-roboto" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-roboto">Roboto</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ubuntu" name="font-family" value="8" data-font-family="app-font-family-ubuntu" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-ubuntu">Ubuntu</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-poppins" name="font-family" value="9" data-font-family="app-font-family-poppins" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-poppins">Poppins</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-raleway" name="font-family" value="10" data-font-family="app-font-family-raleway" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-raleway">Raleway</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-system-ui" name="font-family" value="11" data-font-family="app-font-family-system-ui" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-system-ui">System UI</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-noto-sans" name="font-family" value="12" data-font-family="app-font-family-noto-sans" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-noto-sans">Noto Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-fira-sans" name="font-family" value="13" data-font-family="app-font-family-fira-sans" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-fira-sans">Fira Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-work-sans" name="font-family" value="14" data-font-family="app-font-family-work-sans" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-work-sans">Work Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-open-sans" name="font-family" value="15" data-font-family="app-font-family-open-sans" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-open-sans">Open Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-maven-pro" name="font-family" value="16" data-font-family="app-font-family-maven-pro" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-maven-pro">Maven Pro</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-quicksand" name="font-family" value="17" data-font-family="app-font-family-quicksand" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-quicksand">Quicksand</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-montserrat" name="font-family" value="18" data-font-family="app-font-family-montserrat" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-montserrat">Montserrat</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-josefin-sans" name="font-family" value="19" data-font-family="app-font-family-josefin-sans" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-josefin-sans">Josefin Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ibm-plex-sans" name="font-family" value="20" data-font-family="app-font-family-ibm-plex-sans" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-ibm-plex-sans">IBM Plex Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-source-sans-pro" name="font-family" value="5" data-font-family="app-font-family-source-sans-pro" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-source-sans-pro">Source Sans Pro</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-montserrat-alt" name="font-family" value="21" data-font-family="app-font-family-montserrat-alt" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-montserrat-alt">Montserrat Alt</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-roboto-slab" name="font-family" value="22" data-font-family="app-font-family-roboto-slab" />
                            <label class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label" for="app-font-family-roboto-slab">Roboto Slab</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Typography] !-->
            </div>
            <div class="customizer-sidebar-footer px-4 ht-60 border-top d-flex align-items-center gap-2">
                <div class="flex-fill w-50">
                    <a href="javascript:void(0);" class="btn btn-danger" data-style="reset-all-common-style">Reset</a>
                </div>
                <div class="flex-fill w-50">
                    <a href="https://www.themewagon.com/themes/Web sewa-admin" target="_blank" class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
    </div>
    <!--! ================================================================ !-->
    <!--! [End] Theme Customizer !-->
    <!--! ================================================================ !-->
    
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
    /* Custom CSS untuk Dashboard HD dengan warna baru */
    
    /* Gradient Colors */
    .gradient-card-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        transition: transform 0.3s ease;
    }
    
    .gradient-card-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
        transition: transform 0.3s ease;
    }
    
    .gradient-card-3 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
        transition: transform 0.3s ease;
    }
    
    .gradient-card-4 {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        border: none;
        box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3);
        transition: transform 0.3s ease;
    }
    
    .gradient-card-1:hover,
    .gradient-card-2:hover,
    .gradient-card-3:hover,
    .gradient-card-4:hover {
        transform: translateY(-5px);
    }
    
    .bg-white-20 {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .text-white-80 {
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* Modern Card Style */
    .modern-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .modern-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .modern-card-header {
        background: transparent;
        border-bottom: 2px solid #f0f2f5;
        padding: 1.25rem 1.5rem;
    }
    
    /* Gradient Text */
    .gradient-text-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }
    
    .gradient-text-secondary {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }
    
    .gradient-text-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }
    
    .gradient-text-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }
    
    /* Gradient Badges */
    .badge-gradient-success {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #fff;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 500;
    }
    
    .badge-gradient-danger {
        background: linear-gradient(135deg, #f43b47 0%, #453a94 100%);
        color: #fff;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 500;
    }
    
    .badge-gradient-warning {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        color: #fff;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 500;
    }
    
    /* Modern Table */
    .modern-table thead th {
        border: none;
        font-weight: 600;
        color: #667eea;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
        transform: scale(1.01);
    }
    
    /* Modern Button */
    .btn-modern-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    /* Gradient Colors for Status */
    .text-success-grad {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }
    
    .text-warning-grad {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }
    
    .text-danger-grad {
        background: linear-gradient(135deg, #f43b47 0%, #453a94 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }
    
    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: -30px -30px 30px -30px;
        padding: 60px 30px 30px 30px;
        color: white;
    }
    
    .page-header .breadcrumb-item,
    .page-header .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .page-header .breadcrumb-item.active {
        color: white;
    }
    
    .page-header-title h5,
    .page-header-title p {
        color: white;
    }
    
    /* Main Content Background */
    .nxl-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
    }
    
    /* Card Shadow Enhancements */
    .card {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    </style>
    
    <script>
    // Inisialisasi Chart.js dengan warna baru
    document.addEventListener('DOMContentLoaded', function() {
        // Grafik Peminjaman Bulanan (Bar Chart)
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: [12, 19, 15, 25, 22, 30, 28, 26, 24, 20, 18, 14],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(240, 147, 251, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(250, 112, 154, 0.8)',
                        'rgba(132, 250, 176, 0.8)',
                        'rgba(143, 211, 244, 0.8)',
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(240, 147, 251, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(250, 112, 154, 0.8)',
                        'rgba(132, 250, 176, 0.8)',
                        'rgba(143, 211, 244, 0.8)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Grafik Status Sepeda (Doughnut Chart)
        const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
        const doughnutChart = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Dipinjam', 'Rusak'],
                datasets: [{
                    data: [28, 12, 4],
                    backgroundColor: [
                        'rgba(132, 250, 176, 0.9)',
                        'rgba(255, 154, 158, 0.9)',
                        'rgba(244, 59, 71, 0.9)'
                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 0.8)',
                        'rgba(255, 255, 255, 0.8)',
                        'rgba(255, 255, 255, 0.8)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '70%',
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
        
        // Grafik Kategori Sepeda (Bar Chart)
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Besar', 'Kecil', 'Lipat', 'Gunung', 'Listrik'],
                datasets: [{
                    label: 'Jumlah Unit',
                    data: [8, 12, 6, 10, 8],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.9)',
                        'rgba(240, 147, 251, 0.9)',
                        'rgba(79, 172, 254, 0.9)',
                        'rgba(250, 112, 154, 0.9)',
                        'rgba(132, 250, 176, 0.9)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Tren Peminjaman (Line Chart)
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Peminjaman',
                    data: [18, 22, 26, 30, 28, 32],
                    fill: true,
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(102, 126, 234, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }, {
                    label: 'Pengembalian',
                    data: [15, 20, 24, 28, 26, 30],
                    fill: true,
                    backgroundColor: 'rgba(132, 250, 176, 0.1)',
                    borderColor: 'rgba(132, 250, 176, 1)',
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(132, 250, 176, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
    </script>
    
    <!--! ================================================================ !-->
    <!--! Footer Script !-->
    <!--! ================================================================ !-->
    <!--! BEGIN: Vendors JS !-->
   <?php include '../../partials/script.php'?>
    <!--! END: Theme Customizer !-->
</body>
</html>