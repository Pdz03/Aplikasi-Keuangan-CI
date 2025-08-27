<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard - CI Keuangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #f9fafc, #eef2f7);
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.8) !important;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .card-stat {
      border: none;
      border-radius: 20px;
      padding: 25px;
      color: #fff;
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
      transition: all .3s ease;
    }
    .card-stat:hover {
      transform: translateY(-6px) scale(1.02);
      box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    .card-stat h6 {
      font-size: 14px;
      font-weight: 500;
      opacity: 0.9;
    }
    .card-stat h3 {
      margin: 0;
      font-weight: bold;
      font-size: 26px;
    }
    .bg-income { background: linear-gradient(135deg,#4facfe,#00f2fe); }
    .bg-expense { background: linear-gradient(135deg,#f857a6,#ff5858); }
    .bg-balance { background: linear-gradient(135deg,#43e97b,#38f9d7); }

    .card {
      border-radius: 18px !important;
    }
    footer {
      margin-top: 50px;
      padding: 15px;
      font-size: 13px;
      color: #666;
    }
    .btn {
      border-radius: 12px;
      padding: 8px 16px;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="<?= site_url('dashboard'); ?>">💰 CI Keuangan</a>
    <div class="ms-auto">
      <span class="me-3 text-muted">👋 Halo, <strong><?= $this->session->userdata('username'); ?></strong></span>
      <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container" style="margin-top:90px;">
  <!-- Statistik -->
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card-stat bg-income">
        <h6>Total Pemasukan</h6>
        <h3>Rp <?= number_format($summary['pemasukan'] ?? 0,0,',','.'); ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-stat bg-expense">
        <h6>Total Pengeluaran</h6>
        <h3>Rp <?= number_format($summary['pengeluaran'] ?? 0,0,',','.'); ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-stat bg-balance">
        <h6>Saldo</h6>
        <h3>Rp <?= number_format(($summary['pemasukan'] ?? 0) - ($summary['pengeluaran'] ?? 0),0,',','.'); ?></h3>
      </div>
    </div>
  </div>

  <!-- Chart -->
  <div class="card mt-5 shadow-sm border-0">
    <div class="card-body">
      <h5 class="card-title mb-3">📊 Grafik Pemasukan & Pengeluaran</h5>
      <canvas id="keuanganChart" height="100"></canvas>
    </div>
  </div>

  <!-- Tombol navigasi -->
  <div class="mt-4 d-flex gap-2">
    <a href="<?= site_url('transaksi'); ?>" class="btn btn-primary"><i class="bi bi-list-ul"></i> Daftar Transaksi</a>
    <a href="<?= site_url('transaksi/add'); ?>" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Transaksi</a>
    <a href="<?= site_url('laporan'); ?>" class="btn btn-outline-secondary"><i class="bi bi-file-earmark-text"></i> Laporan</a>
  </div>

  <footer class="text-center">© <?= date('Y'); ?> CI3 Keuangan — Latihan PKL</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const chartData = <?= json_encode($chartData ?? []); ?>;
  const labels = chartData.map(item => item.tanggal);
  const pemasukan = chartData.map(item => item.pemasukan);
  const pengeluaran = chartData.map(item => item.pengeluaran);

  const ctx = document.getElementById('keuanganChart').getContext('2d');

  const gradientIncome = ctx.createLinearGradient(0, 0, 0, 400);
  gradientIncome.addColorStop(0, 'rgba(79,172,254,0.4)');
  gradientIncome.addColorStop(1, 'rgba(0,242,254,0.05)');

  const gradientExpense = ctx.createLinearGradient(0, 0, 0, 400);
  gradientExpense.addColorStop(0, 'rgba(248,87,166,0.4)');
  gradientExpense.addColorStop(1, 'rgba(255,88,88,0.05)');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [
        {
          label: 'Pemasukan',
          data: pemasukan,
          borderColor: '#4facfe',
          backgroundColor: gradientIncome,
          tension: 0.4,
          fill: true,
          borderWidth: 3,
          pointRadius: 4,
          pointBackgroundColor: '#4facfe'
        },
        {
          label: 'Pengeluaran',
          data: pengeluaran,
          borderColor: '#f857a6',
          backgroundColor: gradientExpense,
          tension: 0.4,
          fill: true,
          borderWidth: 3,
          pointRadius: 4,
          pointBackgroundColor: '#f857a6'
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top', labels: { usePointStyle: true, font: { family: "Poppins" } } }
      },
      scales: {
        x: { ticks: { maxRotation: 45, minRotation: 45 } },
        y: { beginAtZero: true }
      }
    }
  });
</script>
</body>
</html>
