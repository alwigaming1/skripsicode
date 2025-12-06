<?php 
include 'koneksi.php'; 
include 'data.php'; 
include 'header.php'; 

// --- 1. LOGIKA FILTER & PENCARIAN (DIPINDAHKAN KE ATAS) ---
$keyword = isset($_GET['cari']) ? strtolower($_GET['cari']) : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Tampung hasil filter ke array baru
$filtered_katalog = [];

foreach($katalog as $kode => $item) {
    // Filter Pencarian (Keyword)
    if($keyword){
        $judul_kecil = strtolower($item['judul']);
        $tech_kecil = strtolower($item['tech']);
        $desc_kecil = strtolower($item['desc']);
        if(strpos($judul_kecil, $keyword) === false && strpos($tech_kecil, $keyword) === false && strpos($desc_kecil, $keyword) === false){
            continue; 
        }
    }

    // Filter Kategori (Teknologi)
    if($kategori && stripos($item['tech'], $kategori) === false){
        continue;
    }

    // Jika lolos filter, masukkan ke array baru (simpan key/kode asli)
    $filtered_katalog[$kode] = $item;
}

// --- 2. LOGIKA PAGINATION ---
$batas = 6; // Jumlah katalog per halaman
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$total_data = count($filtered_katalog);
$total_halaman = ceil($total_data / $batas);

// Ambil data sesuai halaman (Slice array)
// Parameter ke-4 'true' agar key ($kode) tidak berubah/direset
$data_halaman_ini = array_slice($filtered_katalog, $halaman_awal, $batas, true);

// Fungsi bantu untuk membuat URL pagination tetap membawa filter
function build_url($page, $cari, $kategori) {
    $params = ['page' => $page];
    if ($cari) $params['cari'] = $cari;
    if ($kategori) $params['kategori'] = $kategori;
    return 'index.php?' . http_build_query($params) . '#katalog';
}
?>

<section id="home" class="pt-32 pb-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-purple-50 rounded-full blur-3xl opacity-50"></div>

    <div class="container mx-auto px-6 text-center relative z-10">
        <span class="bg-blue-50 text-blue-600 border border-blue-100 px-4 py-1 rounded-full text-xs font-bold mb-6 inline-block uppercase tracking-wider">
            🔥 Gudangnya Skripsi IT Terlengkap
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 leading-tight">
            Source Code Skripsi <br> <span class="text-primary">Siap Pakai & Berkualitas</span>
        </h1>
        <p class="text-gray-500 text-lg mb-10 max-w-2xl mx-auto">
            Hemat waktu pengerjaan skripsimu. Pilih judul, lihat demo, dan dapatkan source code lengkap beserta panduan instalasinya.
        </p>

        <div class="max-w-2xl mx-auto bg-white p-2 rounded-full shadow-xl border border-gray-200 flex mb-8">
            <form action="index.php" method="GET" class="flex w-full">
                <div class="flex-1 flex items-center px-4">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 mr-3"></i>
                    <input type="text" name="cari" value="<?= $keyword ?>" placeholder="Cari judul project..." class="w-full outline-none text-gray-700 bg-transparent placeholder-gray-400">
                </div>
                <?php if($kategori): ?><input type="hidden" name="kategori" value="<?= $kategori ?>"><?php endif; ?>
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-secondary transition shadow-lg shadow-blue-200">
                    Cari
                </button>
            </form>
        </div>

        <div class="flex flex-wrap justify-center gap-3">
            <a href="index.php" class="px-5 py-2 rounded-full text-sm font-bold border transition <?= ($kategori == '') ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-gray-500 border-gray-200 hover:border-primary hover:text-primary' ?>">
                Semua
            </a>
            <a href="index.php?kategori=PHP Native" class="px-5 py-2 rounded-full text-sm font-bold border transition <?= ($kategori == 'PHP Native') ? 'bg-primary text-white border-primary shadow-lg shadow-blue-200' : 'bg-white text-gray-500 border-gray-200 hover:border-primary hover:text-primary' ?>">
                PHP Native
            </a>
            <a href="index.php?kategori=Laravel" class="px-5 py-2 rounded-full text-sm font-bold border transition <?= ($kategori == 'Laravel') ? 'bg-primary text-white border-primary shadow-lg shadow-blue-200' : 'bg-white text-gray-500 border-gray-200 hover:border-primary hover:text-primary' ?>">
                Laravel
            </a>
            <a href="index.php?kategori=CodeIgniter" class="px-5 py-2 rounded-full text-sm font-bold border transition <?= ($kategori == 'CodeIgniter') ? 'bg-primary text-white border-primary shadow-lg shadow-blue-200' : 'bg-white text-gray-500 border-gray-200 hover:border-primary hover:text-primary' ?>">
                CodeIgniter
            </a>
            <a href="index.php?kategori=HTML" class="px-5 py-2 rounded-full text-sm font-bold border transition <?= ($kategori == 'HTML') ? 'bg-primary text-white border-primary shadow-lg shadow-blue-200' : 'bg-white text-gray-500 border-gray-200 hover:border-primary hover:text-primary' ?>">
                HTML/CSS
            </a>
        </div>
    </div>
</section>

<section id="katalog" class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="container mx-auto px-6">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Katalog Project Terbaru</h2>
                <p class="text-gray-500 mt-2">
                    <?php if($kategori): ?>
                        Menampilkan kategori: <span class="font-bold text-primary"><?= htmlspecialchars($kategori) ?></span>
                    <?php else: ?>
                        Menampilkan semua source code yang tersedia.
                    <?php endif; ?>
            
                </p>
            </div>
            
            <?php if($keyword || $kategori): ?>
                <a href="index.php" class="text-red-500 font-bold hover:underline text-sm"><i class="fa-solid fa-times"></i> Reset Filter</a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($data_halaman_ini as $kode => $item): ?>
            
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group flex flex-col h-full hover:-translate-y-1">
                
                <div class="relative h-56 overflow-hidden bg-gray-200">
                    <img src="<?= $item['img'] ?>" alt="<?= $item['judul'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                    
                    <div class="absolute top-3 right-3 flex flex-col items-end gap-1">
                        <?php 
                        $tech_stack = explode(',', $item['tech']);
                        foreach($tech_stack as $t): 
                        ?>
                        <span class="bg-white/95 backdrop-blur px-2 py-1 rounded text-[10px] font-bold text-gray-800 shadow-sm border border-gray-100 uppercase tracking-wide">
                            <?= trim($t) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <div class="mb-3 flex justify-between items-center">
                        <span class="text-[10px] font-bold text-<?= $item['color'] ?>-600 bg-<?= $item['color'] ?>-50 px-2 py-1 rounded border border-<?= $item['color'] ?>-100 uppercase tracking-wide">
                            Full Source Code
                        </span>
                        <?php if($item['terjual'] > 0): ?>
                            <span class="text-[10px] font-bold text-orange-600 flex items-center gap-1">
                                <i class="fa-solid fa-fire animate-pulse"></i> <?= $item['terjual'] ?>x Terjual
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <h3 class="font-bold text-xl text-slate-800 mb-2 leading-snug group-hover:text-primary transition line-clamp-2">
                        <?= $item['judul'] ?>
                    </h3>
                    
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2">
                        <?= $item['desc'] ?>
                    </p>

                    <div class="mt-auto flex items-center justify-between pt-6 border-t border-gray-50">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-400 font-bold uppercase">Harga</span>
                            <span class="font-bold text-lg text-slate-800"><?= $item['harga'] ?></span>
                        </div>
                        <a href="detail.php?id=<?= $kode ?>" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-primary transition shadow-lg flex items-center gap-2">
                            Detail <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if($total_data == 0): ?>
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-3xl">
                    <i class="fa-solid fa-filter"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Tidak ada produk ditemukan</h3>
                <p class="text-gray-500 mt-2">Coba kata kunci lain atau reset filter.</p>
                <a href="index.php" class="mt-6 inline-block bg-primary text-white px-6 py-2 rounded-lg font-bold">Lihat Semua Project</a>
            </div>
        <?php endif; ?>

        <?php if($total_halaman > 1): ?>
        <div class="mt-16 flex justify-center">
            <nav class="inline-flex rounded-md shadow-sm isolate">
                <?php if($halaman > 1): ?>
                    <a href="<?= build_url($halaman - 1, $keyword, $kategori) ?>" class="relative inline-flex items-center rounded-l-md px-4 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </a>
                <?php endif; ?>

                <?php for($x = 1; $x <= $total_halaman; $x++): ?>
                    <?php if($x == $halaman): ?>
                        <span aria-current="page" class="relative z-10 inline-flex items-center bg-primary px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <?= $x ?>
                        </span>
                    <?php else: ?>
                        <a href="<?= build_url($x, $keyword, $kategori) ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <?= $x ?>
                        </a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if($halaman < $total_halaman): ?>
                    <a href="<?= build_url($halaman + 1, $keyword, $kategori) ?>" class="relative inline-flex items-center rounded-r-md px-4 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
        <?php endif; ?>

    </div>
</section>

<section id="custom" class="py-24 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600 rounded-full blur-[100px] opacity-20 -mr-20 -mt-20"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-600 rounded-full blur-[100px] opacity-20 -ml-20 -mb-20"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2">
                <span class="text-blue-400 font-bold tracking-wider uppercase text-sm mb-2 block">✨ Solusi Skripsi Eksklusif</span>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Butuh Website Custom <br> Sesuai <span class="text-blue-400">Judul Skripsimu?</span></h2>
                <p class="text-slate-300 text-lg mb-8 leading-relaxed">Punya judul unik yang tidak ada di katalog? Tim developer kami siap membangun website dari nol sesuai permintaan dosen.</p>
                <ul class="space-y-5">
                    <li class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-file-code"></i></div>
                        <div><h4 class="font-bold text-white">Sesuai Alur BAB 1 & 3</h4><p class="text-sm text-slate-400">Analisa kebutuhan sistem disesuaikan dengan penulisan skripsi.</p></div>
                    </li>
                    <li class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-shield-halved"></i></div>
                        <div><h4 class="font-bold text-white">Garansi Revisi Program</h4><p class="text-sm text-slate-400">Gratis revisi minor sampai program di-ACC.</p></div>
                    </li>
                </ul>
            </div>
            <div class="lg:w-1/2 w-full">
                <div class="bg-white text-gray-800 rounded-3xl p-8 shadow-2xl border border-gray-100 relative">
                    <div class="absolute -top-6 right-8 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">Form Penawaran</div>
                    <h3 class="text-2xl font-bold mb-6 text-gray-900">Request Pembuatan</h3>
                    <form action="kirim_request.php" method="POST" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div><label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label><input type="text" name="nama" required placeholder="Nama Anda" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                            <div><label class="block text-sm font-bold text-gray-700 mb-2">Asal Kampus</label><input type="text" name="kampus" required placeholder="Nama Kampus" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                        </div>
                        <div><label class="block text-sm font-bold text-gray-700 mb-2">Judul Skripsi</label><textarea name="judul" rows="3" required placeholder="Tuliskan judul lengkap..." class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></textarea></div>
                        <div><label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp</label><input type="number" name="wa" required placeholder="0812xxxx" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                        <button type="submit" name="kirim" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg">Kirim Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>