<?php
session_start();
require_once "../app.php";

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $nama = escapeString($koneksi, $_POST['nama']);
    $username = escapeString($koneksi, $_POST['username']);
    $password = escapeString($koneksi, $_POST['password']);
    $role = escapeString($koneksi, $_POST['role']);
    
    // Cek apakah username sudah ada
    $check_query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($check_query) > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        // Dapatkan id_role berdasarkan role yang dipilih
        $role_query = mysqli_query($koneksi, "SELECT id_role FROM roles WHERE nama_role='$role'");
        $role_data = mysqli_fetch_assoc($role_query);
        $id_role = $role_data['id_role'];
        
        // Insert user baru
        $insert_query = "INSERT INTO users (nama, username, password, id_role) 
                        VALUES ('$nama', '$username', '$password', '$id_role')";
        
        if (mysqli_query($koneksi, $insert_query)) {
            $success = "Registrasi berhasil! Silakan login.";
            header("refresh:2;url=login.php");
        } else {
            $error = "Gagal mendaftar: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register 3D | Sistem Peminjaman</title>
    <link rel="stylesheet" href="../template/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a1a2a 0%, #1a3a5a 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Simple 3D Background Elements - Tetap Bergerak */
        .bg-3d {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .cube {
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(13, 110, 253, 0.1);
            border: 2px solid rgba(13, 110, 253, 0.3);
            transform-style: preserve-3d;
            animation: float 20s infinite linear;
        }

        .cube-1 {
            top: -150px;
            right: -150px;
            transform: rotateX(45deg) rotateY(45deg);
            animation-duration: 25s;
        }

        .cube-2 {
            bottom: -150px;
            left: -150px;
            width: 400px;
            height: 400px;
            transform: rotateX(30deg) rotateY(-30deg);
            animation-duration: 30s;
            animation-direction: reverse;
        }

        @keyframes float {
            0% { transform: rotateX(45deg) rotateY(45deg) translateZ(0); }
            50% { transform: rotateX(225deg) rotateY(225deg) translateZ(50px); }
            100% { transform: rotateX(405deg) rotateY(405deg) translateZ(0); }
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(13, 110, 253, 0.5);
            border-radius: 50%;
            box-shadow: 0 0 20px #0d6efd;
            animation: particleFloat 15s infinite;
        }

        .particle-1 { top: 20%; left: 10%; animation-duration: 15s; }
        .particle-2 { top: 70%; left: 80%; animation-duration: 20s; animation-direction: reverse; }
        .particle-3 { top: 40%; left: 60%; animation-duration: 18s; }
        .particle-4 { top: 80%; left: 30%; animation-duration: 22s; animation-direction: reverse; }
        .particle-5 { top: 30%; left: 90%; animation-duration: 25s; }

        @keyframes particleFloat {
            0% { transform: translateY(0) translateX(0) scale(1); opacity: 0.5; }
            50% { transform: translateY(-100px) translateX(50px) scale(2); opacity: 1; }
            100% { transform: translateY(0) translateX(0) scale(1); opacity: 0.5; }
        }

        /* Main Container - Card TIDAK BERGERAK */
        .register-container {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 10;
        }

        /* 3D Card - EFEK 3D TETAP TAPI TIDAK GOYANG */
        .card-3d {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(13, 110, 253, 0.3);
            border-radius: 30px;
            padding: 35px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.5),
                0 0 0 2px rgba(13, 110, 253, 0.2) inset,
                0 0 30px rgba(13, 110, 253, 0.3),
                /* Efek 3D dengan bayangan */
                15px 15px 30px rgba(0, 0, 0, 0.6),
                -5px -5px 15px rgba(255, 255, 255, 0.1) inset;
            
            /* Transformasi 3D TETAP - TIDAK BERUBAH */
            transform: perspective(1000px) rotateX(2deg) rotateY(1deg) translateZ(10px);
            
            /* Transition hanya untuk hover effect */
            transition: all 0.3s ease;
            color: white;
            
            /* Menghilangkan efek mouse tracking */
            pointer-events: auto;
        }

        /* Hover effect minimal - hanya memperjelas efek 3D */
        .card-3d:hover {
            transform: perspective(1000px) rotateX(1deg) rotateY(0.5deg) translateZ(20px);
            box-shadow: 
                0 35px 70px rgba(0, 0, 0, 0.6),
                0 0 0 3px rgba(13, 110, 253, 0.4) inset,
                0 0 50px rgba(13, 110, 253, 0.5),
                20px 20px 40px rgba(0, 0, 0, 0.7),
                -5px -5px 20px rgba(255, 255, 255, 0.15) inset;
        }

        /* Header */
        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-header h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5), 0 0 20px #0d6efd;
        }

        .card-header p {
            color: #b0d4ff;
            font-size: 1rem;
        }

        .card-header i {
            font-size: 3rem;
            color: #0d6efd;
            filter: drop-shadow(0 0 20px #0d6efd);
            margin-bottom: 15px;
            animation: iconPulse 2s infinite;
        }

        @keyframes iconPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #b0d4ff;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group label i {
            margin-right: 8px;
            color: #0d6efd;
        }

        .form-control {
            width: 100%;
            padding: 14px 20px;
            background: rgba(10, 30, 50, 0.8);
            border: 2px solid rgba(13, 110, 253, 0.3);
            border-radius: 15px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #0d6efd;
            background: rgba(13, 110, 253, 0.1);
            box-shadow: 0 0 30px rgba(13, 110, 253, 0.3);
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: rgba(176, 212, 255, 0.5);
        }

        select.form-control option {
            background: #0a1e30;
            color: white;
        }

        /* Password Strength */
        .strength-meter {
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
        }

        .strength-text {
            font-size: 0.8rem;
            text-align: right;
            margin-top: 4px;
            color: #b0d4ff;
        }

        /* Terms Checkbox */
        .terms-check {
            margin: 25px 0;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #0d6efd;
        }

        .form-check-label {
            color: #b0d4ff;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .form-check-label a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        /* Register Button */
        .btn-register {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #0d6efd, #0056b3);
            border: none;
            border-radius: 15px;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(13, 110, 253, 0.5);
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register i {
            margin-right: 10px;
            animation: spin 4s infinite linear;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: rgba(176, 212, 255, 0.5);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(13, 110, 253, 0.3);
        }

        .divider span {
            padding: 0 15px;
            font-size: 0.9rem;
        }

        /* Login Link */
        .login-link {
            text-align: center;
        }

        .login-link a {
            color: #b0d4ff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #0d6efd;
            text-shadow: 0 0 20px #0d6efd;
        }

        .login-link i {
            margin-right: 5px;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            font-weight: 500;
            animation: slideDown 0.5s ease;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #d4edda;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #f8d7da;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
            color: rgba(176, 212, 255, 0.5);
            font-size: 0.85rem;
        }

        .footer i {
            color: #0d6efd;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .card-3d {
                padding: 25px;
                transform: perspective(1000px) rotateX(1deg) rotateY(0.5deg) translateZ(5px);
            }
            
            .card-header h2 {
                font-size: 1.8rem;
            }
            
            .bg-3d {
                opacity: 0.3;
            }
        }

        /* Efek 3D tambahan untuk elemen di dalam card (opsional) */
        .form-group {
            transform: translateZ(5px);
        }

        .btn-register {
            transform: translateZ(10px);
        }

        .login-link {
            transform: translateZ(5px);
        }
    </style>
</head>
<body>
    <!-- Simple 3D Background - Tetap Bergerak -->
    <div class="bg-3d">
        <div class="cube cube-1"></div>
        <div class="cube cube-2"></div>
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <!-- Register Container - Card TIDAK BERGERAK -->
    <div class="register-container">
        <div class="card-3d">
            <!-- Header -->
            <div class="card-header">
                <i class="fas fa-user-plus"></i>
                <h2>Daftar Akun</h2>
                <p>Bergabung dengan Sistem Peminjaman</p>
            </div>

            <!-- Alert Messages -->
            <?php if ($error != ""): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success != ""): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $success; ?>
                </div>
            <?php endif; ?>

            <!-- Register Form -->
            <form method="POST" id="registerForm">
                <div class="form-group">
                    <label>
                        <i class="fas fa-id-card"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" 
                           name="nama" 
                           class="form-control" 
                           placeholder="Masukkan nama lengkap"
                           required>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-user"></i>
                        Username
                    </label>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           placeholder="Masukkan username"
                           required>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           id="password"
                           placeholder="Minimal 6 karakter"
                           required>
                    
                    <!-- Strength Meter -->
                    <div class="strength-meter">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-text" id="strengthText">
                        <i class="fas fa-shield-alt me-1"></i>
                        Kekuatan password
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="terms-check">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="terms" 
                               required>
                        <label class="form-check-label" for="terms">
                            Saya setuju dengan <a href="#">Syarat & Ketentuan</a>
                        </label>
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit" name="register" class="btn-register">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </button>

                <!-- Divider -->
                <div class="divider">
                    <span>atau</span>
                </div>

                <!-- Login Link -->
                <div class="login-link">
                    <a href="login.php">
                        <i class="fas fa-sign-in-alt"></i>
                        Sudah punya akun? Login
                    </a>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <i class="fas fa-shield-alt me-1"></i>
                    Data terenkripsi aman
                    <span class="mx-2">•</span>
                    <i class="fas fa-users me-1"></i>
                    1000+ pengguna
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../template/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password Strength Checker
        const password = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        password.addEventListener('input', function() {
            const pwd = this.value;
            let strength = 0;
            
            // Check length
            if (pwd.length >= 6) strength += 25;
            if (pwd.length >= 8) strength += 10;
            
            // Check for lowercase
            if (pwd.match(/[a-z]/)) strength += 15;
            
            // Check for uppercase
            if (pwd.match(/[A-Z]/)) strength += 15;
            
            // Check for numbers
            if (pwd.match(/[0-9]/)) strength += 15;
            
            // Check for special characters
            if (pwd.match(/[^a-zA-Z0-9]/)) strength += 20;
            
            // Cap at 100
            strength = Math.min(strength, 100);
            
            // Update bar
            strengthBar.style.width = strength + '%';
            
            // Update color and text
            if (strength < 30) {
                strengthBar.style.background = '#dc3545';
                strengthText.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Password lemah';
                strengthText.style.color = '#dc3545';
            } else if (strength < 60) {
                strengthBar.style.background = '#ffc107';
                strengthText.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Password sedang';
                strengthText.style.color = '#ffc107';
            } else if (strength < 85) {
                strengthBar.style.background = '#0d6efd';
                strengthText.innerHTML = '<i class="fas fa-check-circle me-1"></i>Password kuat';
                strengthText.style.color = '#0d6efd';
            } else {
                strengthBar.style.background = '#28a745';
                strengthText.innerHTML = '<i class="fas fa-shield-alt me-1"></i>Password sangat kuat';
                strengthText.style.color = '#28a745';
            }
        });

        // Auto close alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
            }
        });

        // TIDAK ADA LAGI MOUSE EFFECT - CARD DIAM
        // Hanya background 3D yang bergerak
    </script>
</body>
</html>