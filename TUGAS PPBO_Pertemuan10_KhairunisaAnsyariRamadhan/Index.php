<?php
require_once 'Product.php';

// ===== Proses form (Create, Update, Delete) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'];

    if ($aksi === 'tambah') {
        $p = new Product($_POST['nama'], $_POST['band'], $_POST['ukuran'], (int)$_POST['harga'], (int)$_POST['stok']);
        $p->save();
    } elseif ($aksi === 'ubah') {
        $p = new Product($_POST['nama'], $_POST['band'], $_POST['ukuran'], (int)$_POST['harga'], (int)$_POST['stok']);
        $p->update((int)$_POST['id']);
    } elseif ($aksi === 'hapus') {
        Product::delete((int)$_POST['id']);
    }

    header('Location: index.php');
    exit;
}

// ===== Ambil data untuk ditampilkan (Read) =====
$daftar = Product::findAll();                                              // lihat semua
$edit   = isset($_GET['edit'])  ? Product::findById((int)$_GET['edit'])  : false;  // isi form ubah
$lihat  = isset($_GET['lihat']) ? Product::findById((int)$_GET['lihat']) : false;  // lihat satu

function h($teks) { return htmlspecialchars($teks); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Merch Band Lokal</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 900px; margin: 30px auto; padding: 0 16px; color: #222; }
    h1 { border-bottom: 4px solid #d63b1f; padding-bottom: 8px; }
    form.input { display: grid; gap: 10px; background: #f1f3f5; padding: 16px; border: 1px solid #ccc; }
    label { display: grid; gap: 4px; font-weight: bold; }
    input, select { padding: 8px; font-size: 1rem; }
    button, .btn { padding: 8px 14px; border: 0; background: #15203b; color: #fff; cursor: pointer; text-decoration: none; font-size: .9rem; display: inline-block; }
    .hapus { background: #d63b1f; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #15203b; color: #fff; }
    td form { display: inline; }
    .detail { background: #fff6d6; border: 1px solid #e0c060; padding: 12px 16px; margin: 16px 0; }
  </style>
</head>
<body>

<h1>Merchandise Band Lokal</h1>

<?php if ($lihat): ?>
  <div class="detail">
    <b>Detail produk #<?= $lihat['id'] ?></b><br>
    Nama: <?= h($lihat['nama']) ?><br>
    Band: <?= h($lihat['band']) ?><br>
    Ukuran: <?= h($lihat['ukuran']) ?><br>
    Harga: Rp <?= number_format($lihat['harga'], 0, ',', '.') ?><br>
    Stok: <?= $lihat['stok'] ?><br>
    <a href="index.php">Tutup</a>
  </div>
<?php endif; ?>

<h2><?= $edit ? 'Ubah Produk' : 'Tambah Produk' ?></h2>

<form class="input" method="post">
  <input type="hidden" name="aksi" value="<?= $edit ? 'ubah' : 'tambah' ?>">
  <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>

  <label>Nama produk
    <input type="text" name="nama" value="<?= $edit ? h($edit['nama']) : '' ?>" required>
  </label>
  <label>Band
    <input type="text" name="band" value="<?= $edit ? h($edit['band']) : '' ?>" required>
  </label>
  <label>Ukuran
    <select name="ukuran">
      <?php foreach (['S', 'M', 'L', 'XL', 'XXL'] as $u): ?>
        <option <?= ($edit && $edit['ukuran'] === $u) ? 'selected' : '' ?>><?= $u ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Harga (Rp)
    <input type="number" name="harga" min="0" value="<?= $edit ? $edit['harga'] : '' ?>" required>
  </label>
  <label>Stok
    <input type="number" name="stok" min="0" value="<?= $edit ? $edit['stok'] : '' ?>" required>
  </label>

  <div>
    <button type="submit"><?= $edit ? 'Simpan Perubahan' : 'Tambah' ?></button>
    <?php if ($edit): ?><a href="index.php">Batal</a><?php endif; ?>
  </div>
</form>

<h2>Daftar Produk</h2>
<table>
  <tr>
    <th>ID</th><th>Nama</th><th>Band</th><th>Ukuran</th><th>Harga</th><th>Stok</th><th>Aksi</th>
  </tr>
  <?php foreach ($daftar as $row): ?>
  <tr>
    <td><?= $row['id'] ?></td>
    <td><?= h($row['nama']) ?></td>
    <td><?= h($row['band']) ?></td>
    <td><?= h($row['ukuran']) ?></td>
    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
    <td><?= $row['stok'] ?></td>
    <td>
      <a class="btn" href="?lihat=<?= $row['id'] ?>">Lihat</a>
      <a class="btn" href="?edit=<?= $row['id'] ?>">Ubah</a>
      <form method="post" onsubmit="return confirm('Hapus produk ini?')">
        <input type="hidden" name="aksi" value="hapus">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <button class="hapus" type="submit">Hapus</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

</body>
</html>