<?php
// 1. Cek apakah tombol 'kirim' sudah ditekan
if (isset($_POST['kirim'])) {

    // --- KONFIGURASI NOMOR WA ADMIN ---
    // Ganti dengan nomor WhatsApp kamu (Gunakan kode negara 62, tanpa + atau 0 di depan)
    $nomor_admin = '6281234567890'; 

    // 2. Ambil data dari formulir
    $nama   = htmlspecialchars($_POST['nama']);
    $kampus = htmlspecialchars($_POST['kampus']);
    $judul  = htmlspecialchars($_POST['judul']);
    $wa     = htmlspecialchars($_POST['wa']);

    // 3. Buat format pesan WhatsApp
    // %0A adalah kode untuk baris baru (Enter) di URL
    $pesan  = "Halo Admin SkripsiCode,%0A%0A";
    $pesan .= "Saya ingin request website custom:%0A";
    $pesan .= "----------------------------------%0A";
    $pesan .= "*Nama:* $nama%0A";
    $pesan .= "*Kampus:* $kampus%0A";
    $pesan .= "*No. WA:* $wa%0A";
    $pesan .= "*Judul Skripsi:*%0A$judul%0A";
    $pesan .= "----------------------------------%0A";
    $pesan .= "Mohon info estimasi biaya dan waktu pengerjaannya. Terima kasih.";

    // 4. Redirect (alihkan) user ke WhatsApp Web / Aplikasi WA
    header("Location: https://wa.me/$nomor_admin?text=$pesan");
    exit;

} else {
    // Jika file ini dibuka langsung tanpa lewat form, kembalikan ke halaman utama
    header("Location: index.php");
    exit;
}
?>