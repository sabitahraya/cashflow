<?php
include 'koneksi.php';

$bank_query = "SELECT b.id, b.nama_bank, b.nomor_akun, SUM(CASE WHEN t.tipe = 'pemasukan' THEN t.jumlah ELSE 0 END) -
SUM(CASE WHEN t.tipe = 'pengeluaran' THEN t.jumlah ELSE 0 END) AS saldo FROM bank b LEFT JOIN transaksi t ON b.id = t.bank_id GROUP BY b.id"; #tabel bank(b) transaksi(t)
$bank_hasil = mysqli_query($conn, $bank_query);

$history_query = "SELECT t.*, b.nama_bank FROM transaksi t
JOIN bank b ON t.bank_id = b.id
ORDER BY t.tanggal_transaksi DESC, t.id DESC LIMIT 10";
$history_result = mysqli_query($conn, $history_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cashflow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container my-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
            <div>
                <h1 class= "fw-bold text-dark m-0">Cashflow</h1>
                <p class="text-muted m-0">Mencatat transaksi keuanganmu!</p>
            </div>
            <div>
                <a href="input.php" class="btn btn-info px-4 py-2 fw-semibold shadow-sm">+ Transaksi</a>
            </div>
        </div>
    </div>

    <h4 class="mb-3 fw-bold text-secondary px-2">Saldo kamu sekarang :</h4>
    <div class="row-3 mb-5">
        <?php
        if (mysqli_num_rows($bank_hasil) >0) {
            while ($bank = mysqli_fetch_assoc($bank_hasil)) {
                $saldo = $bank['saldo'] ?? 0;
                ?>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card h-100 shadow-sm border-0 border-start border-primary border-4 rounded-3">
                            <div class="card-body p-4">
                                <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                    <?= ($bank['nama_bank']); ?>
                                </h6>
                                <small class="text-black-50 d-block mb-3">No. Rek: <?= ($bank['nomor_akun'] ?? '-'); ?></small>
                                <h3 class="fw-bold text-dark m-0">
                                    Rp <?= number_format($saldo, 0, ',', '.'); ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php 
                } 
            } else {
                echo "<div class='col-12'><div class='alert alert-warning border-0 shadow-sm'>Belum ada data bank di database.</div></div>";
            }
            ?>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <h4 class="card-title mb-4 fw-bold text-secondary">Riwayat Transaksi Terbaru</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="table-light text-muted uppercase" style="font-size: 0.85rem;">
                            <tr>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3">Bank</th>
                                <th class="py-3">Jenis</th>
                                <th class="py-3">Nominal</th>
                                <th class="py-3 px-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (mysqli_num_rows($history_result) > 0) {
                                while ($row = mysqli_fetch_assoc($history_result)) { 
                                    $is_pemasukan = ($row['tipe'] == 'pemasukan');
                                    $badge_color = $is_pemasukan ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle';
                                    $cek = $is_pemasukan ? '+ Rp ' : '- Rp ';
                                    ?>
                                    <tr>
                                        <td class="py-3 px-4 text-secondary"><?= date('d M Y', strtotime($row['tanggal_transaksi'])); ?></td>
                                        <td class="py-3"><span class="badge bg-light text-dark border fw-medium px-2.5 py-1.5"><?= ($row['nama_bank']); ?></span></td>
                                        <td class="py-3">
                                            <span class="badge <?= $badge_color; ?> px-2.5 py-1.5 fw-bold text-uppercase" style="font-size: 0.7rem;">
                                                <?= $row['tipe']; ?>
                                            </span>
                                        </td>
                                        <td class="py-3 fw-bold <?= $is_pemasukan ? 'text-success' : 'text-danger'; ?>">
                                            <?= $cek . number_format($row['jumlah'], 0, ',', '.'); ?>
                                        </td>
                                        <td class="py-3 px-4 text-muted font-monospace" style="font-size: 0.9rem;"><?= ($row['deskripsi'] ?? '-'); ?></td>
                                    </tr>
                                <?php 
                                } 
                            } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5 fs-6">Belum ada histori transaksi. Silakan tambah transaksi baru.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>