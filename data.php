<?php
// Cek koneksi jika belum ada
if(!isset($koneksi)){ include 'koneksi.php'; }

$katalog = [];
$query_produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC");

while($row = mysqli_fetch_assoc($query_produk)){
    
    // --- 1. LOGIC GAMBAR COVER ---
    // Cek apakah file gambar ada di folder assets
    $img_path = 'assets/images/' . $row['gambar'];
    
    if(!empty($row['gambar']) && file_exists($img_path)) {
        // Jika file asli ada, gunakan itu
        $final_img = $img_path;
    } else {
        // Jika tidak ada, gunakan Placeholder bawaan
        $final_img = "https://placehold.co/600x400/".$row['kode_img']."/ffffff?text=".urlencode($row['teknologi']);
    }

    // --- 2. LOGIC SCREENSHOTS (6 SLOT) ---
    $raw_screenshots = json_decode($row['screenshots'], true);
    $final_screenshots = [];

    if(is_array($raw_screenshots)){
        foreach($raw_screenshots as $cap => $img){
            // Cek apakah ini URL Eksternal (http) atau File Lokal
            if(strpos($img, 'http') === 0) {
                $final_screenshots[$cap] = $img;
            } else {
                // Cek fisik file screenshot lokal
                $ss_path = 'assets/images/screenshots/' . $img;
                if(file_exists($ss_path)){
                    $final_screenshots[$cap] = $ss_path;
                } else {
                    // Fallback jika file hilang
                    $final_screenshots[$cap] = "https://placehold.co/800x450/cccccc/ffffff?text=Image+Missing";
                }
            }
        }
    }

    // Masukkan ke Array Katalog
    $katalog[$row['kode_produk']] = [
        "judul" => $row['judul'],
        "tech"  => $row['teknologi'],
        "color" => $row['warna'],
        "harga" => $row['harga'],
        "img"   => $final_img, 
        "terjual" => $row['terjual'],
        "demo_link" => $row['link_demo'],
        "desc"  => $row['deskripsi_singkat'],
        "full_desc" => $row['deskripsi_lengkap'],
        "fitur" => json_decode($row['fitur'], true),
        "screenshots" => $final_screenshots
    ];
}
?>