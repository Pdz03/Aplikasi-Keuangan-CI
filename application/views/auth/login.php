<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - CI Keuangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,.15);
      padding: 2rem;
      width: 100%;
      max-width: 420px;
      animation: fadeInUp 0.6s ease;
    }
    @keyframes fadeInUp {
      from {opacity: 0; transform: translateY(30px);}
      to {opacity: 1; transform: translateY(0);}
    }
    .login-title {
      font-weight: 700;
      color: #0072ff;
    }
    .form-control {
      border-radius: 10px;
      padding-left: 40px;
    }
    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
    }
    .btn-login {
      background: linear-gradient(135deg, #0072ff, #00c6ff);
      border: none;
      font-weight: 500;
      border-radius: 12px;
    }
    .btn-login:hover {
      background: linear-gradient(135deg, #005bea, #00c6fb);
    }
    .footer-text {
      margin-top: 1rem;
      font-size: .85rem;
      color: #666;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h3 class="text-center login-title mb-3">💰 CI Keuangan</h3>
    <p class="text-center text-muted mb-4">Masuk untuk melanjutkan</p>

    <?php if(!empty($error)): ?>
      <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('auth/login'); ?>">
      <div class="mb-3 position-relative">
        <span class="input-icon"><i class="bi bi-person"></i></span>
        <input name="username" class="form-control" placeholder="Username" required autofocus>
      </div>
      <div class="mb-3 position-relative">
        <span class="input-icon"><i class="bi bi-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button class="btn btn-login w-100 py-2 text-white">Login</button>
    </form>

    <div class="footer-text">
      <hr>
      <small>Default admin: <b>admin</b> / <b>TerangBulanKeju2025</b></small><br>
      <small>CI3 Starter Project — latihan PKL</small>
    </div>
  </div>

  <!-- Bootstrap Icon CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
