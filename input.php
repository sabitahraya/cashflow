<?php
include 'koneksi.php';

$bank_query = "SELECT id, nama_bank FROM bank ORDER BY nama_bank ASC";
$bank_hasil = mysqli_query($conn, $bank_query);

if(isset($_POST['submit'])) {
    $bank_id = $_POST['bank_id'] ?? null;
    $tipe = $_POST['tipe'] ?? null;
    $jumlah = $_POST['jumlah'] ?? 0;
    $tanggal_transaksi = $_POST['tanggal_transaksi'] ?? date('Y-m-d');
    $deskripsi = $_POST['deskripsi'] ?? '';

    if (!empty($bank_id) && !empty($tipe) && $jumlah > 0) {
        $insert_query = "INSERT INTO transaksi (bank_id, tipe, jumlah, tanggal_transaksi, deskripsi) 
                         VALUES ($bank_id, '$tipe', $jumlah, '$tanggal_transaksi', '$deskripsi')";

        if(mysqli_query($conn, $insert_query)){
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Gagal menyimpan transaksi: ". mysqli_error($conn). "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container my-5" style="max-width: 600px;">
        <div class="mb-4">
            <a href="index.php" class="text-decoration-none text-secondary">x</a>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <h3 class="fw-bold text-dark mb-1">Tambah Transaksi</h3>
                <p class="text-muted mb-4">Catat arus uang masuk atau keluar</p>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="bank_id" class="form-label fw-semibold text-secondary">Pilih Bank</label>
                        <select class="form-select" id="bank_id" name="bank_id" required>
                            <option value="" disabled selected>Pilih Bank dan Rekening Kamu!</option>
                            <?php
                            $bank_query_lengkap = "SELECT id, nama_bank, nomor_akun FROM bank ORDER BY nama_bank ASC";
                            $bank_hasil_lengkap = mysqli_query($conn, $bank_query_lengkap);
                            while ($bank = mysqli_fetch_assoc($bank_hasil_lengkap)) {
                                echo "<option value='". $bank['id']."'>". ($bank['nama_bank']) . " - (" . ($bank['nomor_akun'] ?? '-') . ")</option>";
                                }
                                ?>
                                </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block fw-semibold text-secondary">Jenis Transaksi</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe" id="pemasukan" value="pemasukan" required>
                            <label class="form-check-label text-success fw-bold" for="pemasukan">Pemasukan (+)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe" id="pengeluaran" value="pengeluaran">
                            <label class="form-check-label text-danger fw-bold" for="pengeluaran">Pengeluaran (-)</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label fw-semibold text-secondary">Nominal (Rp)</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required placeholder="Contoh: 50000">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_transaksi" class="form-label fw-semibold text-secondary">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required value="<?= date('Y-m-d'); ?>">
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-semibold text-secondary">Keterangan / Catatan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Contoh: Bayar internet, Uang jajan, dll..."></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-primary py-2 fw-semibold shadow-sm">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>