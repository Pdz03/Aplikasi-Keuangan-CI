<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Laporan Bulanan - CI Keuangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f5f7fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .app-card {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
      padding: 30px;
    }
    h4 {
      font-weight: 600;
      color: #2d3436;
    }
    table thead {
      background: linear-gradient(90deg,#0d6efd,#6f42c1);
      color: #fff;
    }
    .summary-card {
      border-radius: 14px;
      padding: 25px;
      color: #fff;
      font-weight: 600;
      box-shadow: 0 6px 14px rgba(0,0,0,0.08);
      transition: transform .2s;
    }
    .summary-card:hover {
      transform: translateY(-4px);
    }
    .app-footer {
      text-align: center;
      padding: 15px;
      font-size: 13px;
      color: #999;
      margin-top: 40px;
    }
    .table-hover tbody tr:hover {
      background: #f1f5ff;
      transition: .2s;
    }
    .btn-gradient {
      background: linear-gradient(90deg,#0d6efd,#6f42c1);
      color: #fff;
      border: none;
    }
    .btn-gradient:hover {
      background: linear-gradient(90deg,#0b5ed7,#5a32a3);
      color: #fff;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="<?= site_url('dashboard'); ?>">
      <i class="bi bi-cash-stack"></i> CI Keuangan
    </a>
    <div class="ms-auto">
      <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-danger btn-sm rounded-pill">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>
  </div>
</nav>

<div class="container my-5">
  <div class="app-card">
    <h4 class="mb-4"><i class="bi bi-clipboard-data"></i> Laporan Bulanan</h4>

    <!-- Filter Form -->
    <form method="get" class="row g-3 align-items-end mb-4">
      <div class="col-md-3">
        <label class="form-label fw-semibold">Tahun</label>
        <input type="number" name="year" class="form-control shadow-sm" value="<?= $year; ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Bulan</label>
        <input type="number" name="month" class="form-control shadow-sm" value="<?= $month; ?>">
      </div>
      <div class="col-md-6 d-flex gap-2">
        <button class="btn btn-gradient shadow-sm">
          <i class="bi bi-search"></i> Tampilkan
        </button>
        <!-- Tombol Export seperti versi lama -->
        <a href="<?= site_url('laporan/export_pdf?year='.$year.'&month='.$month); ?>" class="btn btn-outline-danger shadow-sm">
          <i class="bi bi-filetype-pdf"></i> Export PDF
        </a>
        <a href="<?= site_url('laporan/export_excel?year='.$year.'&month='.$month); ?>" class="btn btn-outline-success shadow-sm">
          <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
      </div>
    </form>

    <!-- Ringkasan -->
    <?php if(isset($summary)): ?>
    <div class="row mb-4 text-center">
      <div class="col-md-6">
        <div class="summary-card bg-success">
          <h6><i class="bi bi-arrow-down-circle"></i> Total Pemasukan</h6>
          <h3>Rp <?= number_format($summary['pemasukan'], 0, ',', '.'); ?></h3>
        </div>
      </div>
      <div class="col-md-6">
        <div class="summary-card bg-danger">
          <h6><i class="bi bi-arrow-up-circle"></i> Total Pengeluaran</h6>
          <h3>Rp <?= number_format($summary['pengeluaran'], 0, ',', '.'); ?></h3>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Tabel -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Nominal</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
        <?php if(!empty($rekap)): ?>
          <?php foreach($rekap as $r): ?>
            <tr>
              <td><?= $r->tanggal; ?></td>
              <td>
                <?php if(strtolower($r->jenis) == 'masuk'): ?>
                  <span class="badge bg-success px-3 py-2"><i class="bi bi-arrow-down-circle"></i> Pemasukan</span>
                <?php else: ?>
                  <span class="badge bg-danger px-3 py-2"><i class="bi bi-arrow-up-circle"></i> Pengeluaran</span>
                <?php endif; ?>
              </td>
              <td><strong>Rp <?= number_format($r->nominal,0,',','.'); ?></strong></td>
              <td><?= $r->keterangan; ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center text-muted">Tidak ada data untuk bulan ini.</td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Tombol kembali -->
    <div class="mt-4">
      <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary shadow-sm">
        <i class="bi bi-house"></i> Kembali
      </a>
    </div>
  </div>

  <footer class="app-footer">© <?= date('Y'); ?> CI3 Keuangan — Latihan PKL</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
