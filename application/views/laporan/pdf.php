<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    th { background: #eee; }
  </style>
</head>
<body>
  <h3>Laporan Bulanan <?= $month ?>/<?= $year ?></h3>
  <table>
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Nominal</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($rekap as $r): ?>
      <tr>
        <td><?= $r->tanggal; ?></td>
        <td><?= ucfirst($r->jenis); ?></td>
        <td>Rp <?= number_format($r->nominal,0,',','.'); ?></td>
        <td><?= $r->keterangan; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
