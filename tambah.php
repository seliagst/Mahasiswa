<?php
include 'koneksi.php';

$error_message = "";

if (isset($_POST['save'])) {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $gender = $_POST['gender'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $usia = $_POST['usia'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // periksa apakah nim sudah terdaftar
    $check_nim = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim = '$nim'");
    
    if (mysqli_num_rows($check_nim) > 0) {
        // jika sudah ada, tampilkan pesan error
        $error_message = "NIM <b>$nim</b> sudah terdaftar!";
    } else {
        // jika belum ada, jalankan query INSERT
        $query = "INSERT INTO mahasiswa (nim, nama, gender, tanggal_lahir, usia, alamat) 
                  VALUES ('$nim', '$nama', '$gender', '$tanggal_lahir', '$usia', '$alamat')";
        
        if(mysqli_query($conn, $query)) {
            header("Location: admin.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="w-full max-w-xl bg-white p-10 rounded-[40px] border border-slate-200 shadow-2xl shadow-slate-200/50">
        <div class="mb-8">
            <a href="admin.php" class="inline-flex items-center text-slate-400 hover:text-indigo-600 font-bold mb-4 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800">Mahasiswa Baru</h2>
            <p class="text-slate-400 font-medium italic">Silakan lengkapi formulir pendaftaran di bawah ini.</p>
        </div>

        <?php if ($error_message !== ""): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl flex items-center gap-3 animate-shake">
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                <p class="text-sm font-semibold"><?= $error_message ?></p>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-5">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">NIM</label>
                    <input type="text" name="nim" value="<?= isset($_POST['nim']) ? $_POST['nim'] : '' ?>" 
                           placeholder="Cth: 2021001" 
                           class="w-full px-6 py-4 bg-slate-50 border <?= $error_message ? 'border-red-300 ring-2 ring-red-100' : 'border-slate-100' ?> rounded-2xl focus:ring-2 focus:ring-indigo-400 outline-none transition" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Usia</label>
                    <input type="number" name="usia" value="<?= isset($_POST['usia']) ? $_POST['usia'] : '' ?>" 
                           placeholder="20" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-400 outline-none transition" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= isset($_POST['nama']) ? $_POST['nama'] : '' ?>" 
                       placeholder="Masukkan nama mahasiswa" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-400 outline-none transition" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                <div class="relative">
                    <i class="fa-solid fa-calendar absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="date" name="tanggal_lahir" value="<?= isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : '' ?>" 
                           class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-400 outline-none transition text-slate-600" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin</label>
                <div class="flex gap-4">
                    <label class="flex-1">
                        <input type="radio" name="gender" value="Laki-laki" class="hidden peer" required <?= (isset($_POST['gender']) && $_POST['gender'] == 'Laki-laki') ? 'checked' : '' ?>>
                        <div class="text-center py-4 rounded-2xl border border-slate-100 bg-slate-50 text-slate-500 peer-checked:bg-blue-50 peer-checked:border-blue-200 peer-checked:text-blue-600 font-bold transition cursor-pointer">Laki-laki</div>
                    </label>
                    <label class="flex-1">
                        <input type="radio" name="gender" value="Perempuan" class="hidden peer" <?= (isset($_POST['gender']) && $_POST['gender'] == 'Perempuan') ? 'checked' : '' ?>>
                        <div class="text-center py-4 rounded-2xl border border-slate-100 bg-slate-50 text-slate-500 peer-checked:bg-pink-50 peer-checked:border-pink-200 peer-checked:text-pink-600 font-bold transition cursor-pointer">Perempuan</div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Domisili</label>
                <textarea name="alamat" rows="3" placeholder="Alamat lengkap..." class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-400 outline-none transition" required><?= isset($_POST['alamat']) ? $_POST['alamat'] : '' ?></textarea>
            </div>

            <button type="submit" name="save" class="w-full bg-slate-900 text-white font-bold py-5 rounded-[24px] shadow-xl hover:bg-slate-800 transition transform active:scale-[0.98]">
                Daftarkan Mahasiswa
            </button>
        </form>
    </div>

</body>
</html>