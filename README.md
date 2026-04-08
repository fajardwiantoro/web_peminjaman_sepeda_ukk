<?php
session_start();

require_once "../app.php";

$error = "";

if (isset($_POST['login'])) {
    $username = escapeString($koneksi, $_POST['username']);
    $password = escapeString($koneksi, $_POST['password']);
    $role     = escapeString($koneksi, $_POST['role']);

    $query = mysqli_query(
        $koneksi,
        "SELECT u.*, r.nama_role
         FROM users u
         JOIN roles r ON u.id_role = r.id_role
         WHERE u.username='$username'"
    );

    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);

        if ($password === $user['password']) {

            $_SESSION['login']   = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['nama_role'];

            if ($_SESSION['role'] === 'admin') {
                header("Location: ../pages/dashboard/index.php");
            }
            elseif ( $_SESSION['role'] === 'petugas') {
                header("Location: ../pages/dashboard/petugas.php");
            }
             else {
                header("Location: /ukk/index.php");
            }
            exit;
            
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username atau role tidak sesuai!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="utf-8">
<title>Login | Sistem Peminjaman Sepeda</title>

<link rel="stylesheet" href="../template/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

:root{
--primary:#0d6efd;
--secondary:#3fa9f5;
--darkblue:#001f3f;
--lightblue:#6cb2eb;
--accent:#ffd700;
}

body{
margin:0;
padding:0;
min-height:100vh;
font-family: 'Poppins', 'Segoe UI', sans-serif;
overflow-x:hidden;
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
position:relative;
}

/* Background 3D dengan efek parallax */
.background-3d {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
z-index: -1;
overflow: hidden;
}

.layer {
position: absolute;
width: 100%;
height: 100%;
}

.layer-1 {
background: linear-gradient(120deg, #0d6efd, #4a90e2);
opacity: 0.9;
transform: translateZ(-10px) scale(2);
}

.layer-2 {
background: radial-gradient(circle at 30% 50%, rgba(13,110,253,0.3) 0%, transparent 50%);
transform: translateZ(-5px) scale(1.5);
animation: float 20s ease-in-out infinite;
}

.layer-3 {
background: repeating-linear-gradient(45deg, rgba(255,255,255,0.1) 0px, rgba(255,255,255,0.1) 2px, transparent 2px, transparent 10px);
transform: translateZ(-2px) scale(1.2);
animation: slide 30s linear infinite;
}

/* Kubus 3D */
.cube-container {
position: absolute;
width: 100%;
height: 100%;
perspective: 1000px;
}

.cube {
position: absolute;
width: 200px;
height: 200px;
transform-style: preserve-3d;
animation: rotateCube 20s infinite linear;
}

.cube-1 { top: 10%; left: 5%; }
.cube-2 { bottom: 10%; right: 5%; animation-duration: 15s; }
.cube-3 { top: 50%; right: 10%; animation-duration: 25s; }

.face {
position: absolute;
width: 200px;
height: 200px;
background: rgba(13, 110, 253, 0.2);
border: 2px solid rgba(255,255,255,0.3);
box-shadow: 0 0 30px rgba(13,110,253,0.5);
backdrop-filter: blur(5px);
}

.face.front  { transform: translateZ(100px); }
.face.back   { transform: rotateY(180deg) translateZ(100px); }
.face.right  { transform: rotateY(90deg) translateZ(100px); }
.face.left   { transform: rotateY(-90deg) translateZ(100px); }
.face.top    { transform: rotateX(90deg) translateZ(100px); }
.face.bottom { transform: rotateX(-90deg) translateZ(100px); }

/* Partikel 3D */
.particles {
position: absolute;
width: 100%;
height: 100%;
}

.particle {
position: absolute;
width: 4px;
height: 4px;
background: rgba(255,255,255,0.5);
border-radius: 50%;
box-shadow: 0 0 10px rgba(13,110,253,0.8);
animation: floatParticle 15s infinite;
}

/* Login Card 3D */
.login-container {
min-height: 100vh;
display: flex;
align-items: center;
perspective: 2000px;
}

.card-login {
border-radius: 30px;
background: rgba(255, 255, 255, 0.1);
backdrop-filter: blur(20px);
border: 1px solid rgba(255, 255, 255, 0.2);
box-shadow: 
    0 50px 80px rgba(0,0,0,0.4),
    0 0 0 2px rgba(255,255,255,0.1) inset;
transform: 
    rotateX(5deg) 
    rotateY(-5deg) 
    translateZ(20px);
transition: transform 0.5s ease;
animation: floatCard 6s ease-in-out infinite;
color: white;
overflow: hidden;
}

.card-login:hover {
transform: 
    rotateX(2deg) 
    rotateY(-2deg) 
    translateZ(40px) 
    scale(1.02);
box-shadow: 
    0 70px 100px rgba(0,0,0,0.6),
    0 0 0 4px rgba(255,255,255,0.2) inset;
}

.card-header-login {
background: linear-gradient(135deg, rgba(13,110,253,0.8), rgba(106,13,173,0.8));
padding: 30px 20px;
text-align: center;
font-size: 28px;
font-weight: bold;
border-bottom: 3px solid rgba(255,255,255,0.3);
position: relative;
overflow: hidden;
}

.card-header-login::before {
content: '';
position: absolute;
top: -50%;
left: -50%;
width: 200%;
height: 200%;
background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
transform: rotate(45deg);
animation: shine 3s infinite;
}

.card-body {
padding: 40px;
position: relative;
z-index: 1;
}

.form-group {
margin-bottom: 25px;
position: relative;
}

.form-group label {
display: block;
margin-bottom: 8px;
color: rgba(255,255,255,0.9);
font-weight: 500;
text-shadow: 0 2px 5px rgba(0,0,0,0.3);
transform: translateZ(10px);
}

.form-control {
width: 100%;
padding: 15px 20px;
border: none;
border-radius: 15px;
background: rgba(255, 255, 255, 0.15);
border: 2px solid rgba(255, 255, 255, 0.1);
color: white;
font-size: 16px;
transition: all 0.3s ease;
box-shadow: 0 5px 15px rgba(0,0,0,0.2);
transform: translateZ(5px);
}

.form-control:focus {
outline: none;
border-color: var(--accent);
background: rgba(255, 255, 255, 0.25);
box-shadow: 
    0 10px 30px rgba(13,110,253,0.4),
    0 0 0 3px rgba(255,215,0,0.3);
transform: translateZ(15px) scale(1.02);
}

.form-control::placeholder {
color: rgba(255,255,255,0.5);
}

.form-control option {
background: var(--darkblue);
color: white;
}

.btn-login {
width: 100%;
padding: 16px;
border: none;
border-radius: 15px;
background: linear-gradient(45deg, #0d6efd, #4a90e2, #6f42c1);
background-size: 200% 200%;
color: white;
font-weight: bold;
font-size: 18px;
cursor: pointer;
transition: all 0.3s ease;
box-shadow: 
    0 10px 30px rgba(13,110,253,0.5),
    0 0 0 2px rgba(255,255,255,0.2) inset;
transform: translateZ(20px);
animation: gradient 3s ease infinite;
}

.btn-login:hover {
background-position: right center;
transform: translateZ(30px) scale(1.05);
box-shadow: 
    0 20px 40px rgba(13,110,253,0.8),
    0 0 0 4px rgba(255,255,255,0.3) inset;
}

.btn-login i {
margin-right: 10px;
animation: bounce 2s infinite;
}

/* Elemen 3D dekoratif */
.floating-icon {
position: absolute;
font-size: 60px;
color: rgba(255,255,255,0.2);
animation: float 8s infinite;
transform-style: preserve-3d;
}

.icon-1 { top: 10%; left: 10%; animation-delay: 0s; }
.icon-2 { bottom: 15%; left: 20%; animation-delay: 2s; font-size: 80px; }
.icon-3 { top: 20%; right: 15%; animation-delay: 4s; }
.icon-4 { bottom: 25%; right: 25%; animation-delay: 6s; }

/* Alert 3D */
.alert-3d {
background: rgba(220, 53, 69, 0.8);
backdrop-filter: blur(10px);
border: 1px solid rgba(255,255,255,0.3);
border-radius: 15px;
padding: 15px 20px;
color: white;
margin-bottom: 30px;
transform: translateZ(15px);
box-shadow: 0 10px 30px rgba(220,53,69,0.5);
animation: shake 0.5s ease;
}

/* Animations */
@keyframes float {
0%, 100% { transform: translateY(0) translateZ(0) rotate(0deg); }
50% { transform: translateY(-30px) translateZ(50px) rotate(5deg); }
}

@keyframes floatCard {
0%, 100% { transform: rotateX(5deg) rotateY(-5deg) translateZ(20px) translateY(0); }
50% { transform: rotateX(3deg) rotateY(-3deg) translateZ(30px) translateY(-10px); }
}

@keyframes rotateCube {
0% { transform: rotateX(0) rotateY(0) rotateZ(0); }
100% { transform: rotateX(360deg) rotateY(360deg) rotateZ(360deg); }
}

@keyframes floatParticle {
0% { transform: translateY(0) translateZ(0); }
100% { transform: translateY(-100vh) translateZ(200px); }
}

@keyframes shine {
0% { left: -100%; top: -100%; }
100% { left: 100%; top: 100%; }
}

@keyframes gradient {
0% { background-position: 0% 50%; }
50% { background-position: 100% 50%; }
100% { background-position: 0% 50%; }
}

@keyframes bounce {
0%, 100% { transform: translateY(0); }
50% { transform: translateY(-5px); }
}

@keyframes slide {
0% { background-position: 0 0; }
100% { background-position: 100% 100%; }
}

@keyframes shake {
0%, 100% { transform: translateZ(15px) translateX(0); }
25% { transform: translateZ(15px) translateX(-10px); }
75% { transform: translateZ(15px) translateX(10px); }
}

/* Responsive */
@media (max-width: 768px) {
.card-body { padding: 30px 20px; }
.cube { transform: scale(0.5); }
}

/* Link styles */
.text-link {
color: rgba(255,255,255,0.9);
text-decoration: none;
font-weight: 500;
transition: all 0.3s ease;
position: relative;
display: inline-block;
}

.text-link:hover {
color: var(--accent);
transform: translateZ(10px) scale(1.1);
text-shadow: 0 0 20px rgba(255,215,0,0.5);
}

.divider {
border-color: rgba(255,255,255,0.2);
margin: 20px 0;
transform: translateZ(5px);
}

</style>
</head>

<body>

<!-- Background 3D Layers -->
<div class="background-3d">
    <div class="layer layer-1"></div>
    <div class="layer layer-2"></div>
    <div class="layer layer-3"></div>
    
    <!-- Kubus 3D -->
    <div class="cube-container">
        <div class="cube cube-1">
            <div class="face front"></div>
            <div class="face back"></div>
            <div class="face right"></div>
            <div class="face left"></div>
            <div class="face top"></div>
            <div class="face bottom"></div>
        </div>
        <div class="cube cube-2">
            <div class="face front"></div>
            <div class="face back"></div>
            <div class="face right"></div>
            <div class="face left"></div>
            <div class="face top"></div>
            <div class="face bottom"></div>
        </div>
        <div class="cube cube-3">
            <div class="face front"></div>
            <div class="face back"></div>
            <div class="face right"></div>
            <div class="face left"></div>
            <div class="face top"></div>
            <div class="face bottom"></div>
        </div>
    </div>
    
    <!-- Partikel -->
    <div class="particles" id="particles"></div>
</div>

<!-- Floating Icons -->
<i class="fas fa-cube floating-icon icon-1"></i>
<i class="fas fa-cubes floating-icon icon-2"></i>
<i class="fas fa-shield-alt floating-icon icon-3"></i>
<i class="fas fa-lock floating-icon icon-4"></i>

<div class="login-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                
                <div class="card card-login">
                    
                    <div class="card-header-login">
                        <i class="fas fa-cubes me-3"></i>
                        PERSEWAAN SEPEDA
                        <i class="fas fa-cube ms-3"></i>
                    </div>
                    
                    <div class="card-body">
                        
                        <h4 class="text-center mb-4" style="color: white; text-shadow: 0 5px 15px rgba(0,0,0,0.5);">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            SELAMAT DATANG
                        </h4>
                        
                        <?php if ($error != ""): ?>
                            <div class="alert-3d">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-user me-2"></i>
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
                                    <i class="fas fa-lock me-2"></i>
                                    Password
                                </label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control" 
                                       placeholder="Masukkan password"
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-users me-2"></i>
                                    Login Sebagai
                                </label>
                                <select name="role" class="form-control" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin">Admin</option>
                                    <option value="petugas">Petugas</option>
                                    <option value="peminjaman">User</option>
                                </select>
                            </div>
                            
                            <button type="submit" name="login" class="btn-login">
                                <i class="fas fa-sign-in-alt"></i>
                                Sewa Sepeda
                            </button>
                            
                            <hr class="divider">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="text-link">
                                    <i class="fas fa-question-circle me-1"></i>
                                    Lupa Password?
                                </a>
                                <a href="register.php" class="text-link">
                                    <i class="fas fa-user-plus me-1"></i>
                                    Daftar Akun
                                </a>
                            </div>
                            
                        </form>
                        
                        <div class="text-center mt-4" style="color: rgba(255,255,255,0.6);">
                            <i class="fas fa-copyright me-1"></i>
                            <?= date('Y'); ?> Sistem Peminjaman 3D
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="../template/assets/js/bootstrap.bundle.min.js"></script>

<script>
// Generate particles
const particlesContainer = document.getElementById('particles');
for (let i = 0; i < 50; i++) {
    const particle = document.createElement('div');
    particle.className = 'particle';
    particle.style.left = Math.random() * 100 + '%';
    particle.style.animationDelay = Math.random() * 10 + 's';
    particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
    particlesContainer.appendChild(particle);
}

// 3D mouse effect on card
const card = document.querySelector('.card-login');
document.addEventListener('mousemove', (e) => {
    const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
    const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
    card.style.transform = `rotateX(${yAxis}deg) rotateY(${-xAxis}deg) translateZ(20px)`;
});

// Reset on mouse leave
card.addEventListener('mouseleave', () => {
    card.style.transform = 'rotateX(5deg) rotateY(-5deg) translateZ(20px)';
});

// Input effects
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateZ(20px)';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateZ(0)';
    });
});

// Alert auto close
if (document.querySelector('.alert-3d')) {
    setTimeout(() => {
        document.querySelector('.alert-3d').style.opacity = '0';
        setTimeout(() => {
            document.querySelector('.alert-3d')?.remove();
        }, 500);
    }, 5000);
}
</script>

</body>
</html>
