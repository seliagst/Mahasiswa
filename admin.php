<?php
include 'koneksi.php';

// hapus data
if (isset($_GET['delete'])) {
    $nim = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim = '$nim'");
    header("Location: admin.php");
}

// ambil data mahasiswa berdasarkan nim secara descending
$result_mhs = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY nim DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManageStudent - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col p-8">
        <div class="flex items-center gap-3 mb-12">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">M</div>
            <span class="text-xl font-extrabold text-slate-800 tracking-tight">ManageStudent</span>
        </div>
        <nav class="space-y-3 flex-1">
            <a href="index.php" class="flex items-center gap-4 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-3 rounded-2xl font-semibold transition">
                <i class="fa-solid fa-home"></i> Home
            </a>
            <a href="admin.php" class="flex items-center gap-4 text-indigo-600 bg-indigo-50 px-4 py-3 rounded-2xl font-bold transition">
                <i class="fa-solid fa-user-graduate"></i> Admin 
            </a>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto p-12">
        <header class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800">Manajemen Data ✍️</h1>
                <p class="text-slate-400 font-medium">Kelola daftar mahasiswa secara terpusat.</p>
            </div>
            <a href="tambah.php" class="flex items-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-indigo-200 transition transform active:scale-95">
                <i class="fa-solid fa-plus text-sm"></i>
                Tambah Mahasiswa
            </a>
        </header>

        <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest">Informasi Mahasiswa</th>
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest text-center">Gender</th>
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest">Alamat</th>
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while($row = mysqli_fetch_assoc($result_mhs)): ?>
                    <tr class="hover:bg-slate-50/50 transition group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold">
                                    <?= substr($row['nama'], 0, 1) ?>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800"><?= $row['nama'] ?></h4>
                                    <p class="text-slate-400 text-sm">NIM: <?= $row['nim'] ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-4 py-1.5 <?= $row['gender'] == 'Laki-laki' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' ?> rounded-full text-xs font-bold uppercase">
                                <?= $row['gender'] ?>
                            </span>
                        </td>
                        <td class="px-8 py-6 text-slate-400 text-sm italic"><?= $row['alamat'] ?></td>
                        <td class="px-8 py-6">
                            <div class="flex justify-center gap-2">
                                <a href="edit.php?nim=<?= $row['nim'] ?>" class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center hover:bg-amber-50 hover:text-amber-600 transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="admin.php?delete=<?= $row['nim'] ?>" onclick="return confirm('Hapus mahasiswa ini?')" class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>