<?php

$buku = [
    ["judul" => "Berserk", "penulis" => "Miura Kentaro"],
    ["judul" => "Oswald", "penulis" => "Walt Disney"],
    ["judul" => "Kadal jamban", "penulis" => "satria"]
];

function tampilBuku($buku) {
    echo "<table border='1'>";
    echo "<tr><th>Judul</th><th>Penulis</th></tr>";
    foreach ($buku as $b) {
        echo "<tr><td>{$b['judul']}</td><td>{$b['penulis']}</td></tr>";
    }
    echo "</table>";
}

function tambahBuku(&$buku, $judul, $penulis) {
    $buku[] = ["judul" => $judul, "penulis" => $penulis];
}

function editBuku(&$buku, $id, $judulBaru, $penulisBaru) {
    if (isset($buku[$id])) {
        $buku[$id] = ["judul" => $judulBaru, "penulis" => $penulisBaru];
    }
}

function hapusBuku(&$buku, $id) {
    if (isset($buku[$id])) {
        unset($buku[$id]);
        $buku = array_values($buku); 
    }
}

function cariBuku($buku, $kataKunci) {
    $hasilCari = [];
    foreach ($buku as $b) {
        if (strpos(strtolower($b['judul']), strtolower($kataKunci)) !== false ||
            strpos(strtolower($b['penulis']), strtolower($kataKunci)) !== false) {
            $hasilCari[] = $b;
        }
    }
    return $hasilCari;
}

echo "<h3>Menampilkan Data Awal:</h3>";
tampilBuku($buku);

tambahBuku($buku, "One Piece", "Eiichiro Oda");
echo "<h3>Menambah Buku Baru:</h3>";
tampilBuku($buku);

editBuku($buku, 2, "Naruto", "Masashi Kishimoto");
echo "<h3>Memperbarui Buku dengan ID ke-2:</h3>";
tampilBuku($buku);

hapusBuku($buku, 1);
echo "<h3>Menghapus Buku dengan ID ke-1:</h3>";
tampilBuku($buku);

$hasilCari = cariBuku($buku, "Naruto");
echo "<h3>Mencari Buku dengan kata kunci 'Naruto':</h3>";
tampilBuku($hasilCari);
?>