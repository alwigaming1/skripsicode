<?php 
include 'koneksi.php'; 
include 'data.php'; 

// 1. Ambil ID dari URL
$id = $_GET['id'] ?? '';

// 2. Cek apakah produk valid
if(!isset($katalog[$id])){ 
    header("Location: index.php"); 
    exit; 
}

// 3. Ambil data produk
$p = $katalog[$id];

// 4. Set Judul SEO & Header
$page_title = $p['judul'] . " - Source Code Skripsi"; 
include 'header.php';
?>

<section class="pt-32 pb-20 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6">
        
        <div class="mb-8 flex items-center gap-2 text-sm text-gray-500">
            <a href="index.php" class="hover:text-primary transition">Home</a> 
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="index.php#katalog" class="hover:text-primary transition">Katalog</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-900 font-bold truncate"><?= $p['judul'] ?></span>
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col lg:flex-row mb-12 border border-gray-100">
            
            <div class="lg:w-5/12 bg-gray-100 relative group min-h-[400px]">
                <img src="<?= $p['img'] ?>" alt="<?= $p['judul'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 cursor-pointer" onclick="openModal(this.src)">
                
                <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                    <?php 
                    $tech_stack = explode(',', $p['tech']);
                    foreach($tech_stack as $t): 
                    ?>
                    <span class="bg-white/95 backdrop-blur text-<?= $p['color'] ?>-600 px-3 py-1 rounded-lg text-xs font-bold shadow-md uppercase tracking-wide border border-gray-100">
                        <?= trim($t) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="lg:w-7/12 p-8 lg:p-12 flex flex-col">
                <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                    <?= $p['judul'] ?>
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 mb-8 pb-8 border-b border-gray-100">
                    <span class="text-4xl font-extrabold text-primary"><?= $p['harga'] ?></span>
                    
                    <?php if($p['terjual'] > 0): ?>
                    <div class="flex items-center gap-2 bg-orange-50 text-orange-700 px-4 py-2 rounded-xl font-bold text-sm border border-orange-100 shadow-sm animate-pulse">
                        <i class="fa-solid fa-fire text-orange-500"></i> <?= $p['terjual'] ?>x Terjual
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-8">
                    <h3 class="font-bold text-gray-900 mb-3 text-lg">Tentang Aplikasi</h3>
                    <p class="text-gray-600 leading-relaxed text-base"><?= $p['full_desc'] ?></p>
                </div>

                <div class="mb-10 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-star text-yellow-400"></i> Fitur & Modul Utama
                    </h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6">
                        <?php foreach($p['fitur'] as $fitur): ?>
                        <li class="flex items-start gap-3 text-sm text-gray-700">
                            <i class="fa-solid fa-circle-check text-green-500 mt-1 flex-shrink-0"></i> 
                            <span><?= $fitur ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="mt-auto flex flex-col sm:flex-row gap-4">
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20tertarik%20membeli%20source%20code%20*<?= urlencode($p['judul']) ?>*" target="_blank" class="flex-1 bg-green-600 text-white py-4 rounded-xl font-bold text-center hover:bg-green-700 transition shadow-lg shadow-green-100 flex items-center justify-center gap-2 group">
                        <i class="fa-brands fa-whatsapp text-xl group-hover:scale-110 transition"></i> Beli Source Code
                    </a>
                    
                    <?php if(!empty($p['demo_link'])): ?>
                    <a href="<?= $p['demo_link'] ?>" target="_blank" class="flex-1 border-2 border-gray-200 text-gray-700 py-4 rounded-xl font-bold text-center hover:border-primary hover:text-primary hover:bg-blue-50 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-desktop"></i> Lihat Live Demo
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if(!empty($p['screenshots']) && is_array($p['screenshots'])): ?>
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <i class="fa-regular fa-images text-primary"></i> Preview Tampilan Aplikasi
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($p['screenshots'] as $caption => $img): 
                    // Pastikan gambar tidak kosong atau error
                    if(empty($img)) continue;
                ?>
                <div class="group relative rounded-2xl overflow-hidden shadow-md bg-white border border-gray-100 cursor-pointer hover:-translate-y-1 transition duration-300" onclick="openModal('<?= $img ?>')">
                    
                    <div class="aspect-video bg-gray-200 relative overflow-hidden">
                        <img src="<?= $img ?>" alt="<?= $caption ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <i class="fa-solid fa-magnifying-glass-plus text-white text-3xl drop-shadow-lg transform scale-75 group-hover:scale-100 transition"></i>
                        </div>
                    </div>
                    
                    <div class="p-4 border-t border-gray-50 bg-white">
                        <h4 class="font-bold text-gray-700 text-center text-sm"><?= $caption ?></h4>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<div id="imageModal" class="fixed inset-0 z-[100] hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300" onclick="closeModal()">
    <div class="relative max-w-6xl w-full">
        <button class="absolute -top-12 right-0 text-white text-3xl hover:text-gray-300 focus:outline-none transition" onclick="closeModal()">
            <i class="fa-solid fa-times"></i>
        </button>
        <img id="modalImg" src="" class="w-full h-auto max-h-[85vh] object-contain rounded-lg shadow-2xl">
    </div>
</div>

<script>
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');

    function openModal(src) {
        modalImg.src = src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Matikan scroll body agar tidak geser
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Hidupkan kembali scroll
    }

    // Tutup jika tekan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeModal();
        }
    });
</script>

<?php include 'footer.php'; ?>