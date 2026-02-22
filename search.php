<?php
include 'koneksi.php';

// ambil kata yang dicari
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// mencari data mahasiswa
$query = "SELECT * FROM mahasiswa WHERE 
          nama LIKE '%$search%' OR 
          nim LIKE '%$search%' 
          ORDER BY nim DESC";
$result_mhs = mysqli_query($conn, $query);

if(mysqli_num_rows($result_mhs) > 0) {
    while($row = mysqli_fetch_assoc($result_mhs)) {
        $genderClass = ($row['gender'] == 'Laki-laki') ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600';
        
        $initial = substr($row['nama'], 0, 1);
        $alamat = (strlen($row['alamat']) > 40) ? substr($row['alamat'], 0, 40).'...' : $row['alamat'];

        echo "<tr class='hover:bg-slate-50/50 transition group'>";
        
        echo "
            <td class='px-8 py-6'>
                <div class='flex items-center gap-4'>
                    <div class='w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold'>$initial</div>
                    <div>
                        <h4 class='font-bold text-slate-800'>{$row['nama']}</h4>
                        <p class='text-slate-400 text-sm font-medium'>NIM: {$row['nim']}</p>
                    </div>
                </div>
            </td>";

        echo "
            <td class='px-8 py-6 text-center'>
                <span class='px-4 py-1.5 $genderClass rounded-full text-[11px] font-bold uppercase'>{$row['gender']}</span>
            </td>";

        echo "
            <td class='px-8 py-6 text-center text-slate-600 font-semibold italic'>
                {$row['usia']} Thn
            </td>";

        echo "
            <td class='px-8 py-6 text-center text-slate-500 font-medium'>
                " . date('d M Y', strtotime($row['tanggal_lahir'])) . "
            </td>";

        echo "
            <td class='px-8 py-6 text-slate-400 text-sm'>
                $alamat
            </td>";

        echo "</tr>";
    }
} else {
    // jika data pencarian tidak ditemukan
    echo "<tr><td colspan='5' class='px-8 py-20 text-center text-slate-400 italic'>Data mahasiswa tidak ditemukan.</td></tr>";
}
?>