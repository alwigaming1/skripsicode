<?php
if(!isset($page_title)) { $page_title = "SkripsiCode - Solusi Source Code IT"; }
if(!isset($page_desc)) { $page_desc = "Jasa pembuatan website skripsi dan jual source code PHP berkualitas."; }
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="<?= $page_desc ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script> tailwind.config = { theme: { extend: { colors: { primary: '#2563EB', secondary: '#1E40AF' } } } } </script>
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <nav class="bg-white shadow fixed w-full z-50 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-primary flex items-center gap-2"><i class="fa-solid fa-graduation-cap"></i> SkripsiCode</a>
            <div class="hidden md:flex space-x-8">
                <a href="index.php" class="hover:text-primary">Home</a>
                <a href="index.php#katalog" class="hover:text-primary">Katalog</a>
                <a href="index.php#custom" class="hover:text-primary">Jasa Custom</a>
            </div>
            <a href="https://wa.me/6281234567890" class="bg-green-500 text-white px-5 py-2 rounded-full font-bold hover:bg-green-600 transition"><i class="fa-brands fa-whatsapp"></i> Chat Admin</a>
        </div>
    </nav>