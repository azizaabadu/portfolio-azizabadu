<?php
$projectRole = match ((string)$project['title']) {
    'Sistem Stok & Penjualan Toko Pakaian' => 'Membangun sistem pencatatan stok dan transaksi penjualan.',
    'POS Beauty — Sistem Kasir Toko Kecantikan' => 'Mengembangkan aplikasi POS sebagai tugas akhir kelas industri.',
    'Desain Website Rizky Store di Figma' => 'Merancang UI/UX website Rizky Store di Figma.',
    'Aplikasi Input Biodata' => 'Membuat antarmuka untuk memasukkan dan menampilkan biodata.',
    'Aplikasi Kalkulator' => 'Membuat aplikasi kalkulator untuk operasi aritmetika dasar.',
    default => 'Peran proyek belum diisi.',
};
$projectProblem = match ((string)$project['title']) {
    'Sistem Stok & Penjualan Toko Pakaian' => 'UMKM pakaian mengalami kendala mencatat barang masuk dan keluar serta menghitung transaksi penjualan.',
    'POS Beauty — Sistem Kasir Toko Kecantikan' => 'Operasional toko membutuhkan pengelolaan produk, pelanggan, transaksi, dan laporan dalam satu alur kasir.',
    'Desain Website Rizky Store di Figma' => 'Toko membutuhkan rancangan tampilan website sebelum rencana implementasi WordPress.',
    'Aplikasi Input Biodata' => 'Data biodata perlu dimasukkan dan ditampilkan melalui aplikasi sederhana.',
    'Aplikasi Kalkulator' => 'Pengguna memerlukan aplikasi untuk menghitung operasi aritmetika dasar.',
    default => (string)$project['description'],
};
$projectSolution = match ((string)$project['title']) {
    'Sistem Stok & Penjualan Toko Pakaian' => 'Membangun sistem berbasis PHP, MySQL, dan Tailwind CSS untuk mencatat persediaan dan transaksi penjualan.',
    'POS Beauty — Sistem Kasir Toko Kecantikan' => 'Membuat aplikasi PHP dan MySQL dengan fitur pengelolaan data toko, pencatatan transaksi, dashboard, dan laporan.',
    'Desain Website Rizky Store di Figma' => 'Merancang UI/UX website di Figma, mencakup navigasi, katalog promosi, kontak WhatsApp, dan informasi lokasi.',
    'Aplikasi Input Biodata' => 'Membuat formulir Java untuk menerima dan menampilkan data biodata.',
    'Aplikasi Kalkulator' => 'Membuat antarmuka Java untuk operasi kalkulator dasar.',
    default => (string)$project['description'],
};
$projectDescription = match ((string)$project['title']) {
    'Sistem Stok & Penjualan Toko Pakaian' => 'Sistem stok dan penjualan berbasis PHP, MySQL, dan Tailwind CSS membantu UMKM pakaian mencatat barang masuk, barang keluar, dan transaksi dengan lebih rapi. Proyek ini berangkat dari kendala pencatatan persediaan yang ditemui pada UMKM pakaian di Flores Timur.',
    'POS Beauty — Sistem Kasir Toko Kecantikan' => 'Aplikasi POS Beauty berbasis PHP dan MySQL membantu toko kecantikan mengelola produk, pelanggan, transaksi, dan laporan penjualan. Dashboard merangkum jumlah pelanggan, produk, dan transaksi terbaru sebagai tugas akhir kelas industri.',
    'Desain Website Rizky Store di Figma' => 'Rancangan UI/UX di Figma untuk website Rizky Store menyusun navigasi, katalog promosi, kontak WhatsApp, dan informasi lokasi toko peralatan rumah tangga di Larantuka. Desain ini merupakan tahap awal sebelum rencana implementasi WordPress dan belum menjadi website aktif.',
    'Aplikasi Input Biodata' => 'Aplikasi Java ini menerima dan menampilkan data biodata melalui antarmuka formulir.',
    'Aplikasi Kalkulator' => 'Aplikasi Java ini menyediakan kalkulator untuk operasi aritmetika dasar.',
    default => (string)$project['description'],
};
$projectTech = array_values(array_filter(array_map('trim', explode(',', (string)($project['tech_stack'] ?? '')))));
if (!$projectTech) $projectTech = ['[ISI TEKNOLOGI]'];
$projectImage = basename((string)$project['image']);
?>
<?php if ((string)$project['title'] === 'POS Beauty — Sistem Kasir Toko Kecantikan'): ?>
<!-- TODO: Ganti thumbnail POS Beauty dengan screenshot yang memuat data contoh nyata; jangan memalsukan data pada gambar. -->
<?php endif; ?>
<!-- TODO: Isi hasil nyata proyek saat sudah tersedia; jangan mengarang dampak atau angka. -->
<button type="button" class="project-card card group reveal flex h-full w-full flex-col overflow-hidden p-0 text-left transition hover:-translate-y-1 hover:shadow-xl" style="--i:<?= (int)$i ?>" data-category="<?= e($project['category']) ?>" data-title="<?= e($project['title']) ?>" data-role="<?= e($projectRole) ?>" data-problem="<?= e($projectProblem) ?>" data-solution="<?= e($projectSolution) ?>" data-result="" data-description="<?= e($projectDescription) ?>" data-image="assets/images/<?= e($projectImage) ?>" data-category-label="<?= e($categories[$project['category']] ?? $project['category']) ?>" data-tech="<?= e(implode(',', $projectTech)) ?>" data-github="<?= e($project['github_url'] ?? '') ?>" data-demo="<?= e($project['demo_url'] ?? '') ?>" data-figma="<?= e($project['figma_url'] ?? '') ?>" aria-haspopup="dialog" aria-label="Lihat detail proyek: <?= e($project['title']) ?>">
  <span class="relative block aspect-video w-full shrink-0 overflow-hidden bg-slate-100 dark:bg-slate-950"><img src="assets/images/<?= e($projectImage) ?>" alt="Pratinjau proyek: <?= e($project['title']) ?>" width="800" height="500" loading="lazy" class="h-full w-full object-cover object-top transition duration-500 group-hover:scale-105 <?= $project['category'] === 'java' ? 'object-center' : '' ?>"><span class="absolute inset-0 bg-brand/0 transition duration-300 group-hover:bg-brand/15"></span></span>
  <span class="flex flex-1 flex-col p-5"><span class="mb-3 flex flex-wrap items-center justify-between gap-2"><span class="rounded-full bg-brand/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand dark:bg-brand-light/15 dark:text-brand-light"><?= e($categories[$project['category']] ?? $project['category']) ?></span><?php if (!empty($project['is_featured'])): ?><span class="text-xs font-semibold text-amber-700 dark:text-amber-300"><i class="fa-solid fa-star mr-1" aria-hidden="true"></i>Unggulan</span><?php endif; ?></span><span class="block text-lg font-semibold text-brand-ink dark:text-white"><?= e($project['title']) ?></span><span class="mt-2 line-clamp-3 text-left text-sm leading-6 text-slate-600 dark:text-slate-300"><?= e($projectDescription) ?></span><span class="mt-4 flex flex-wrap gap-2" aria-label="Teknologi proyek"><?php foreach ($projectTech as $technology): ?><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-700 dark:text-slate-200"><?= e($technology) ?></span><?php endforeach; ?></span><span class="mt-auto flex items-center gap-2 pt-5 text-sm font-semibold text-brand dark:text-brand-light">Lihat detail <i class="fa-solid fa-arrow-right transition group-hover:translate-x-1" aria-hidden="true"></i></span></span>
</button>
