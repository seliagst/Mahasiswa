<?php
include 'koneksi.php';

// cek nim yang dikirim
if (!isset($_GET['nim'])) {
    header("Location: admin.php");
    exit;
}

$nim = mysqli_real_escape_string($conn, $_GET['nim']);

// ambil data mahasiswa berasarkan nim
$result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = '$nim'");
$data = mysqli_fetch_assoc($result);

// jika data tidak ditemukan
if (!$data) {
    header("Location: admin.php");
    exit;
}

// proses update data
if (isset($_POST['update'])) {
    $nama          = mysqli_real_escape_string($conn, $_POST['nama']);
    $gender        = $_POST['gender'];
    $tanggal_lahir = $_POST['tanggal_lahir']; 
    $usia          = mysqli_real_escape_string($conn, $_POST['usia']);
    $alamat        = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Query UPDATE
    $query = "UPDATE mahasiswa SET 
                nama = '$nama', 
                gender = '$gender', 
                tanggal_lahir = '$tanggal_lahir', 
                usia = '$usia', 
                alamat = '$alamat' 
              WHERE nim = '$nim'";

    if (mysqli_query($conn, $query)) {
        header("Location: admin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - <?= $data['nama'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="w-full max-w-xl bg-white p-10 rounded-[40px] border border-slate-200 shadow-2xl shadow-slate-200/50">
        <div class="mb-10 text-center">
            <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-3xl flex items-center justify-center text-3xl font-bold mx-auto mb-4">
                <?= substr($data['nama'], 0, 1) ?>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Perbarui Profil</h2>
            <p class="text-slate-400 font-medium mt-1">Mengedit data mahasiswa NIM: <span class="text-slate-900 font-bold"><?= $data['nim'] ?></span></p>
        </div>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="block text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor Induk Mahasiswa (Permanen)</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    <input type="text" value="<?= $data['nim'] ?>" readonly 
                           class="w-full pl-12 pr-6 py-4 bg-slate-100 border border-slate-200 rounded-2xl text-slate-400 font-bold cursor-not-allowed outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= $data['nama'] ?>" required
                       class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-widest mb-2 ml-1">Tanggal Lahir</label>
                <div class="relative">
                    <i class="fa-solid fa-calendar absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" required
                           class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition text-slate-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-widest mb-2 ml-1">Jenis Kelamin</label>
                    <select name="gender" required
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition appearance-none cursor-pointer">
                        <option value="Laki-laki" <?= $data['gender'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $data['gender'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-widest mb-2 ml-1">Usia (Tahun)</label>
                    <input type="number" name="usia" value="<?= $data['usia'] ?>" required
                           class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" required
                          class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition"><?= $data['alamat'] ?></textarea>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <a href="admin.php" 
                   class="flex-1 text-center py-4 rounded-2xl font-bold text-slate-400 hover:text-slate-600 transition">
                   Batal
                </a>
                <button type="submit" name="update" 
                        class="flex-[2] bg-indigo-600 text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-[1.02] active:scale-[0.98] transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>
</html>