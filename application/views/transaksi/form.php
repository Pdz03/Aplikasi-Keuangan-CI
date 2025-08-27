<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= isset($transaksi) ? 'Edit' : 'Tambah'; ?> Transaksi - CI Keuangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .navbar {
      border-bottom: 1px solid #eee;
    }
    .card-custom {
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 2rem;
      background: #fff;
    }
    .form-label {
      font-weight: 500;
    }
    .btn-primary {
      border-radius: 8px;
      font-weight: 500;
    }
    .btn-secondary {
      border-radius: 8px;
    }
    footer.app-footer {
      margin-top: 3rem;
      text-align: center;
      font-size: 0.9rem;
      color: #6c757d;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="<?= site_url('dashboard'); ?>">
      <i class="bi bi-wallet2"></i> CI Keuangan
    </a>
    <div class="ms-auto">
      <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-danger btn-sm">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>
  </div>
</nav>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card-custom">
        <h4 class="mb-4 text-center text-primary">
          <?= isset($transaksi) ? '✏️ Edit' : '➕ Tambah'; ?> Transaksi
        </h4>

        <?php if(!empty($error)): ?>
          <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form method="post" action="">
          <div class="mb-3">
            <label class="form-label">📅 Tanggal</label>
            <input type="date" name="tanggal" class="form-control" 
              value="<?= isset($transaksi)?$transaksi->tanggal:date('Y-m-d'); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">🔄 Jenis</label>
            <select name="jenis" class="form-select" required>
              <option value="masuk" <?= (isset($transaksi) && $transaksi->jenis=='masuk')?'selected':''; ?>>Pemasukan</option>
              <option value="keluar" <?= (isset($transaksi) && $transaksi->jenis=='keluar')?'selected':''; ?>>Pengeluaran</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">💰 Nominal</label>
            <input type="number" name="nominal" class="form-control" 
              value="<?= isset($transaksi)?$transaksi->nominal:''; ?>" placeholder="Masukkan jumlah uang" required>
          </div>

          <div class="mb-3">
            <label class="form-label">📝 Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: bayar listrik / gaji karyawan"><?= isset($transaksi)?$transaksi->keterangan:''; ?></textarea>
          </div>

          <div class="d-flex justify-content-between">
            <a href="<?= site_url('transaksi'); ?>" class="btn btn-secondary">
              Batal
            </a>
            <button class="btn btn-primary">
              <i class="bi bi-save"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer class="app-footer">✨ CI3 Starter Project — Latihan PKL ✨</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>