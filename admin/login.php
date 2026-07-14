<?php
session_start();
include("../config/koneksi.php");

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if (mysqli_num_rows($query) > 0) {

        $admin = mysqli_fetch_assoc($query);

        // Login password biasa
        
        if ($password == $admin['password']) {

            $_SESSION['admin'] = [
                "id"   => $admin['id'],
                "nama" => $admin['nama']
            ];

            header("Location: dashboard.php");
            exit;
        }

        /*
        Jika nanti menggunakan password_hash(),
        ganti menjadi:

        if(password_verify($password,$admin['password'])){
            ...
        }
        */
    }

    $error = "Username atau Password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Admin | Coffee Sigma</title>

<link rel="icon" type="image/png" href="../assets/img/logo.png">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{

    min-height:100vh;

    display:flex;

    align-items:center;

    justify-content:center;

    overflow:hidden;

    background:
    
    url("../assets/img/bg-login.jpeg");

    background-size:cover;

    background-position:center;

    position:relative;

}

/* Background Glow */

body::before{

    content:"";

    position:absolute;

    width:500px;

    height:500px;

    background:#D89A3D;

    filter:blur(180px);

    opacity:.20;

    top:-180px;

    right:-120px;

}

body::after{

    content:"";

    position:absolute;

    width:450px;

    height:450px;

    background:#6F4E37;

    filter:blur(180px);

    opacity:.20;

    bottom:-180px;

    left:-100px;

}

/* Card Login */

.login-box{

    position:relative;

    z-index:10;

    width:450px;

    padding:45px;

    border-radius:28px;

    background:rgba(35,22,16,.60);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,.08);

    box-shadow:
    0 25px 60px rgba(0,0,0,.45);

    animation:fadeUp .8s ease;

}

@keyframes fadeUp{

from{

opacity:0;

transform:translateY(45px);

}

to{

opacity:1;

transform:translateY(0);

}

}

.logo{

    width:150px;

    transition:.4s;

    margin-bottom:18px;

}

.logo:hover{

    transform:rotate(-5deg) scale(1.08);

}

.title{

    color:#fff;

    font-weight:700;

    letter-spacing:.5px;

}

.subtitle{

    color:#d6d6d6;

    font-size:14px;

    margin-bottom:35px;

}

.form-label{

    color:white;

    font-size:14px;

    font-weight:500;

}

.input-group{

    overflow:hidden;

    border-radius:14px;

}

.input-group-text{

    background:#3a261d;

    border:none;

    color:#D89A3D;

    width:55px;

    justify-content:center;

}

.form-control{

    background:#3a261d;

    border:none;

    color:#fff;

    height:56px;

    font-size:15px;

}

.form-control::placeholder{

    color:#b9b9b9;

}

.form-control:focus{

    background:#3a261d;

    color:white;

    box-shadow:none;

}

.toggle-password{

    cursor:pointer;

    transition:.3s;

}

.toggle-password:hover{

    color:#fff;

}

.btn-login{

    width:100%;

    height:56px;

    border:none;

    border-radius:14px;

    font-size:16px;

    font-weight:600;

    color:#2d1b15;

    background:linear-gradient(135deg,#D89A3D,#F2B85C);

    transition:.35s;

}

.btn-login:hover{

    transform:translateY(-3px);

    box-shadow:0 15px 30px rgba(216,154,61,.35);

}

.alert{

    border:none;

    border-radius:12px;

}

.footer-text{

    margin-top:25px;

    text-align:center;

    color:#cfcfcf;

    font-size:13px;

}

.footer-text span{

    color:#D89A3D;

    font-weight:600;

}

/* Responsive */

@media(max-width:576px){

.login-box{

width:95%;

padding:35px 25px;

}

.logo{

width:150px;

}

.title{

font-size:28px;

}

}

/* Ripple Effect */

.btn-login{

    position:relative;

    overflow:hidden;

}

.ripple{

    position:absolute;

    width:20px;

    height:20px;

    background:rgba(255,255,255,.7);

    border-radius:50%;

    transform:translate(-50%,-50%);

    animation:ripple .6s linear;

}

@keyframes ripple{

from{

width:0;

height:0;

opacity:.8;

}

to{

width:450px;

height:450px;

opacity:0;

}

}


/* Smooth Hover */

.form-control{

transition:.25s;

}

.form-control:hover{

background:#422b20;

}


/* Floating Animation Logo */

.logo{

animation:floating 4s ease-in-out infinite;

}

@keyframes floating{

0%{

transform:translateY(0px);

}

50%{

transform:translateY(-8px);

}

100%{

transform:translateY(0px);

}

}


/* Login Box Hover */

.login-box{

transition:.4s;

}

.login-box:hover{

transform:translateY(-5px);

box-shadow:0 35px 70px rgba(0,0,0,.55);

}


/* Button Hover */

.btn-login:hover{

letter-spacing:.5px;

}


/* Scrollbar */

::-webkit-scrollbar{

width:8px;

}

::-webkit-scrollbar-thumb{

background:#D89A3D;

border-radius:20px;

}

::-webkit-scrollbar-track{

background:#1E120D;

}

</style>

</head>

<body>

<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-5 col-md-7">

            <div class="login-box">

                <!-- Logo -->
                <div class="text-center">

                    <img src="../assets/img/logo.png" class="logo" alt="Coffee Sigma">

                    <h2 class="title mt-2">
                        Coffee Sigma
                    </h2>

                    <p class="subtitle">
                        Admin Dashboard Management System
                    </p>

                </div>

                <!-- Alert -->
                <?php if($error!=""){ ?>

                <div class="alert alert-danger d-flex align-items-center">

                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                    <?= $error; ?>

                </div>

                <?php } ?>

                <!-- Form Login -->
                <form method="POST" action="" autocomplete="off">

                    <!-- Username -->
                    <div class="mb-3">

                        <label class="form-label">
                            Username
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fa-solid fa-user"></i>

                            </span>

                            <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Masukkan Username"
                            required>

                        </div>

                    </div>

                    <!-- Password -->
                    <div class="mb-4">

                        <label class="form-label">
                            Password
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fa-solid fa-lock"></i>

                            </span>

                            <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan Password"
                            required>

                            <span
                            class="input-group-text toggle-password"
                            onclick="togglePassword()">

                                <i
                                id="eyeIcon"
                                class="fa-solid fa-eye">
                                </i>

                            </span>

                        </div>

                    </div>

                    <!-- Button Login -->

                    <button
                    type="submit"
                    name="login"
                    class="btn btn-login">

                        <i class="fa-solid fa-right-to-bracket me-2"></i>

                        Login ke Dashboard

                    </button>

                </form>

                <!-- Divider -->

                <div class="d-flex align-items-center my-4">

                    <hr class="flex-grow-1 text-secondary">

                    <span class="mx-3 text-secondary small">
                        Coffee Sigma
                    </span>

                    <hr class="flex-grow-1 text-secondary">

                </div>

                <!-- Footer -->

                <div class="footer-text">

                    <i class="fa-solid fa-mug-hot me-1"></i>

                    Crafted with
                    <span>❤ Coffee Sigma</span>

                    <br>

                    <small class="text-secondary">

                        © <?= date('Y'); ?> Coffee Sigma.
                        All Rights Reserved.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>

// ===============================
// SHOW / HIDE PASSWORD
// ===============================

function togglePassword(){

    const password = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if(password.type === "password"){

        password.type = "text";

        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");

    }else{

        password.type = "password";

        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");

    }

}


// ===============================
// BUTTON LOADING
// ===============================

const form = document.querySelector("form");

const button = document.querySelector(".btn-login");

form.addEventListener("submit",function(){

    button.disabled = true;

    button.innerHTML = `
    <span class="spinner-border spinner-border-sm me-2"></span>
    Memverifikasi...
    `;

});


// ===============================
// INPUT ANIMATION
// ===============================

document.querySelectorAll(".form-control").forEach(function(input){

    input.addEventListener("focus",function(){

        this.parentElement.style.boxShadow =
        "0 0 0 3px rgba(216,154,61,.25)";

        this.parentElement.style.transition=".3s";

    });

    input.addEventListener("blur",function(){

        this.parentElement.style.boxShadow="none";

    });

});


// ===============================
// RIPPLE BUTTON EFFECT
// ===============================

button.addEventListener("click",function(e){

    let ripple = document.createElement("span");

    ripple.classList.add("ripple");

    this.appendChild(ripple);

    let x = e.offsetX;
    let y = e.offsetY;

    ripple.style.left = x + "px";
    ripple.style.top = y + "px";

    setTimeout(()=>{

        ripple.remove();

    },600);

});

</script>



</body>

</html>