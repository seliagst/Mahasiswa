<?php
include 'koneksi.php';

// Data jumlah total mahasiswa
$query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa");
$total_mhs = mysqli_fetch_assoc($query_total)['total'];

$query_lk = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa WHERE gender = 'Laki-laki'");
$total_lk = mysqli_fetch_assoc($query_lk)['total'] ?? 0;

$query_pr = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa WHERE gender = 'Perempuan'");
$total_pr = mysqli_fetch_assoc($query_pr)['total'] ?? 0;

// Ambil data mahasiswa berdasarkan nim secara descending
$result_mhs = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY nim DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManageStudent - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col p-8">
        <div class="flex items-center gap-3 mb-12">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">M</div>
            <span class="text-xl font-extrabold text-slate-800 tracking-tight">ManageStudent</span>
        </div>

        <nav class="space-y-3 flex-1">
            <a href="index.php" class="flex items-center gap-4 text-indigo-600 bg-indigo-50 px-4 py-3 rounded-2xl font-bold transition">
                <i class="fa-solid fa-home"></i> Home
            </a>
            <a href="admin.php" class="flex items-center gap-4 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-3 rounded-2xl font-semibold transition">
                <i class="fa-solid fa-user-graduate"></i> Admin
            </a>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto p-12 no-scrollbar">
        
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800">Analistik Data 👋</h1>
                <p class="text-slate-400 font-medium">Visualisasi perbandingan dan list mahasiswa secara real-time.</p>
            </div>
            
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Cari nama mahasiwa..." 
                       class="pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-400 w-64 shadow-sm transition">
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <div class="lg:col-span-2 bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm flex flex-col md:flex-row items-center gap-8">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Perbandingan Gender</h3>
                    <p class="text-slate-400 text-sm mb-6">Persentase mahasiswa laki-laki dan perempuan.</p>
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-indigo-600"></div>
                            <span class="text-slate-600 font-medium">Laki-laki: <b class="text-slate-800"><?= $total_lk ?></b></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-pink-500"></div>
                            <span class="text-slate-600 font-medium">Perempuan: <b class="text-slate-800"><?= $total_pr ?></b></span>
                        </div>
                    </div>
                </div>
                <div class="relative h-52 w-52">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-1 flex flex-col gap-6">
                <div class="bg-indigo-600 p-8 rounded-[32px] text-white shadow-xl shadow-indigo-100 flex-1 relative overflow-hidden group">
                    <i class="fa-solid fa-users text-6xl absolute -right-4 -bottom-4 opacity-20 transition group-hover:scale-110"></i>
                    <div class="relative z-10">
                        <h4 class="text-indigo-100 text-xs uppercase font-bold tracking-widest mb-2">Total Mahasiswa</h4>
                        <span class="text-5xl font-extrabold tracking-tight"><?= $total_mhs; ?></span>
                        <p class="mt-2 text-indigo-200 text-sm italic font-medium">Database terupdate</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden mb-12">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest">Mahasiswa</th>
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest text-center">Gender</th>
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest text-center">Tanggal Lahir</th>
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest text-center">Usia</th>
                        <th class="px-8 py-5 text-slate-400 font-bold text-xs uppercase tracking-widest">Alamat</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody" class="divide-y divide-slate-100">
                    <?php while($mhs = mysqli_fetch_assoc($result_mhs)): ?>
                    <tr class="hover:bg-slate-50/50 transition group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold">
                                    <?= substr($mhs['nama'], 0, 1) ?>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800"><?= $mhs['nama'] ?></h4>
                                    <p class="text-slate-400 text-sm font-medium">NIM: <?= $mhs['nim'] ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-4 py-1.5 <?= $mhs['gender'] == 'Laki-laki' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' ?> rounded-full text-[11px] font-bold uppercase">
                                <?= $mhs['gender'] ?>
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center text-slate-600 font-semibold italic">
                            <?= $mhs['tanggal_lahir'] ?> 
                        </td>
                        <td class="px-8 py-6 text-center text-slate-600 font-semibold italic">
                            <?= $mhs['usia'] ?> Thn
                        </td>
                        <td class="px-8 py-6 text-slate-400 text-sm">
                            <?= $mhs['alamat'] ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // menampilkan statistik gender
        const config = document.getElementById('genderChart').getContext('2d');
        new Chart(config, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [<?= $total_lk ?>, <?= $total_pr ?>],
                    backgroundColor: ['#4f46e5', '#ec4899'],
                    hoverOffset: 15,
                    borderWidth: 0,
                    borderRadius: 10
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: { legend: { display: false } }
            }
        });

        // logika pencarian
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('studentTableBody');

        searchInput.addEventListener('input', function() {
            const keyword = searchInput.value;

            // Fetch data ke search.php
            fetch(`search.php?search=${encodeURIComponent(keyword)}&role=home`)
                .then(response => response.text())
                .then(data => {
                    tableBody.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        });
    </script>
</body>
</html>