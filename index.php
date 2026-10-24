<?php
declare(strict_types=1);

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (int)($_SERVER['SERVER_PORT'] ?? 0) === 443;
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => $isHttps, 'path' => '/']);
session_start();
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';

$portfolioConfig = [
    // TODO: Ganti dengan email baru sebelum kartu email diaktifkan.
    'email' => '[ISI EMAIL BARU]',
    'whatsapp' => '6282144725785',
    'social' => [
        ['platform'=>'GitHub','url'=>'https://github.com/azizaabadu','icon_class'=>'fa-brands fa-github'],
        ['platform'=>'X','url'=>'https://x.com/AzhinanN55825','icon_class'=>'fa-brands fa-x-twitter'],
        ['platform'=>'Instagram','url'=>'https://www.instagram.com/azizaabadu/','icon_class'=>'fa-brands fa-instagram'],
        ['platform'=>'LinkedIn','url'=>'https://www.linkedin.com/in/aziza-ony-badu-968a1240b/','icon_class'=>'fa-brands fa-linkedin'],
    ],
];

$bio = 'Siswa PPLG di MAKN Ende yang belajar pengembangan web full stack, termasuk Tailwind CSS, JavaScript, PHP, MySQL, dan Laravel. Mencari kesempatan magang untuk menerapkan keterampilan serta belajar dari tim pengembang profesional.';
$profile = ['name' => 'Aziza Ony Badu', 'headline' => 'Siswa PPLG · Web Developer', 'bio' => $bio, 'location' => 'Ende, Nusa Tenggara Timur', 'cv_url' => 'assets/cv/cv-aziza-badu.pdf', 'open_to_internship' => 1, 'photo' => 'zaza.png'];
$skills = [
    ['name'=>'HTML','icon_class'=>'fa-brands fa-html5','category'=>'Frontend','level'=>85], ['name'=>'CSS','icon_class'=>'fa-brands fa-css3-alt','category'=>'Frontend','level'=>80], ['name'=>'Tailwind CSS','icon_class'=>'fa-solid fa-wind','category'=>'Frontend','level'=>65], ['name'=>'JavaScript','icon_class'=>'fa-brands fa-js','category'=>'Frontend','level'=>65],
    ['name'=>'PHP','icon_class'=>'fa-brands fa-php','category'=>'Backend','level'=>60], ['name'=>'Java','icon_class'=>'fa-brands fa-java','category'=>'Backend','level'=>60], ['name'=>'MySQL','icon_class'=>'fa-solid fa-database','category'=>'Database & Tools','level'=>60], ['name'=>'Git & GitHub','icon_class'=>'fa-brands fa-github','category'=>'Database & Tools','level'=>65],
    ['name'=>'Laravel','icon_class'=>'fa-brands fa-laravel','category'=>'CMS/Framework','level'=>58], ['name'=>'WordPress','icon_class'=>'fa-brands fa-wordpress','category'=>'CMS/Framework','level'=>58], ['name'=>'UI Design','icon_class'=>'fa-solid fa-paintbrush','category'=>'Frontend','level'=>65]
];
$education = [
    ['school'=>'MAKN ENDE','major'=>'Pengembangan Perangkat Lunak dan Gim (PPLG)','start_year'=>2024,'end_year'=>'Sekarang','description'=>'Sedang menempuh pendidikan dan mengembangkan keterampilan perangkat lunak.'],
    ['school'=>'MTs N 1 ALOR','major'=>'','start_year'=>2021,'end_year'=>'2024','description'=>'Pendidikan menengah pertama.']
];
$projects = [
    ['title'=>'Sistem Stok & Penjualan Toko Pakaian','description'=>'Sistem web yang dikembangkan setelah melihat langsung kendala UMKM pakaian di Flores Timur dalam mencatat barang masuk dan keluar serta menghitung belanja saat penjualan. Sistem membantu mengelola stok dan transaksi agar pencatatan persediaan lebih rapi dan perhitungan total belanja lebih akurat.','image'=>'sistem-stok-toko-pakaian.png','category'=>'php','tech_stack'=>'PHP,MySQL,Tailwind CSS','github_url'=>'','demo_url'=>''],
    ['title'=>'POS Beauty — Sistem Kasir Toko Kecantikan','description'=>'Tugas akhir kelas industri berupa aplikasi Point of Sale (POS) untuk membantu proses operasional toko kecantikan. Dashboard menyajikan ringkasan jumlah customer, produk, dan transaksi terbaru. Aplikasi menyediakan pengelolaan customer, kategori, produk, dan admin, serta pencatatan transaksi penjualan dan laporan. Proyek ini menjadi latihan membangun alur kasir dan pengelolaan data toko dalam satu aplikasi web.','image'=>'pos-beauty.png','category'=>'php','tech_stack'=>'PHP,MySQL','github_url'=>'','demo_url'=>''],
    ['title'=>'Desain Website Rizky Store di Figma','description'=>'Desain UI/UX di Figma untuk website Rizky Store, toko peralatan rumah tangga di Larantuka. Rancangan ini dibuat sebagai tahap awal sebelum rencana implementasi menggunakan WordPress. Desain mencakup navigasi Beranda, Produk, Kontak, dan Admin; hero promosi katalog; tombol kontak WhatsApp; serta informasi lokasi toko. Proyek saat ini masih berupa desain Figma dan belum diimplementasikan menjadi website WordPress.','image'=>'rizky-store-figma.png','category'=>'design','tech_stack'=>'Figma','github_url'=>'','demo_url'=>'','figma_url'=>'https://www.figma.com/design/rKcY8SvGhi7Zhzrb6ebyzG/Untitled?node-id=0-1&t=W7voMhDXMGZiaH3D-1'],
    ['title'=>'Aplikasi Input Biodata','description'=>'Aplikasi Java untuk menerima dan menampilkan data biodata.','image'=>'3-2.png','category'=>'java','tech_stack'=>'Java','github_url'=>'','demo_url'=>''],
    ['title'=>'Aplikasi Kalkulator','description'=>'Kalkulator sederhana untuk operasi aritmetika dasar.','image'=>'4-2.png','category'=>'java','tech_stack'=>'Java','github_url'=>'','demo_url'=>''],
];
$socialLinks = $portfolioConfig['social'];
$db = null;
try {
    $db = portfolio_db();
    $row = $db->query('SELECT * FROM profile ORDER BY id LIMIT 1')->fetch(); if ($row) $profile = array_merge($profile, $row);
    $rows = $db->query('SELECT * FROM skills ORDER BY sort_order, id')->fetchAll(); if ($rows) $skills = $rows;
    $rows = $db->query('SELECT * FROM education ORDER BY sort_order, id')->fetchAll(); if ($rows) $education = $rows;
    $rows = $db->query('SELECT * FROM projects ORDER BY sort_order, id')->fetchAll(); if ($rows) $projects = $rows;
    $rows = $db->query('SELECT * FROM social_links ORDER BY sort_order, id')->fetchAll(); if ($rows) $socialLinks = $rows;
} catch (Throwable $exception) {
    error_log('Portfolio database unavailable: ' . $exception->getMessage());
    $db = null;
}
// The portfolio serves the uploaded PDF directly; ignore older Canva links stored in the profile row.
$profile['cv_url'] = 'assets/cv/cv-aziza-badu.pdf';
$linkedinUrl = '';
foreach ($portfolioConfig['social'] as $configuredSocial) {
    if (strtolower((string)$configuredSocial['platform']) === 'linkedin') $linkedinUrl = (string)$configuredSocial['url'];
}
$linkedinFound = false;
foreach ($socialLinks as &$social) {
    if (strtolower((string)($social['platform'] ?? '')) === 'linkedin') {
        $social['url'] = $linkedinUrl;
        $social['icon_class'] = 'fa-brands fa-linkedin';
        $linkedinFound = true;
        break;
    }
}
unset($social);
if (!$linkedinFound) $socialLinks[] = ['platform'=>'LinkedIn','url'=>$linkedinUrl,'icon_class'=>'fa-brands fa-linkedin'];
// TODO: X disembunyikan sementara sampai akun tersebut sesuai identitas profesional.
$socialLinks = array_values(array_filter($socialLinks, static fn(array $social): bool => trim((string)($social['url'] ?? '')) !== '' && strtolower((string)($social['platform'] ?? '')) !== 'x'));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    $values = ['name'=>trim((string)($_POST['name'] ?? '')), 'email'=>trim((string)($_POST['email'] ?? '')), 'phone'=>trim((string)($_POST['phone'] ?? '')), 'need_type'=>trim((string)($_POST['need_type'] ?? '')), 'subject'=>trim((string)($_POST['subject'] ?? '')), 'message'=>trim((string)($_POST['message'] ?? ''))];
    $errors = [];
    if (!csrf_verify(isset($_POST['csrf_token']) ? (string)$_POST['csrf_token'] : null)) $errors['form'] = 'Sesi formulir kedaluwarsa atau token keamanan tidak valid. Muat ulang halaman, lalu coba lagi.';
    if (trim((string)($_POST['website'] ?? '')) !== '') $errors['form'] = 'Permintaan tidak dapat diproses.';
    if (mb_strlen($values['name']) < 2 || mb_strlen($values['name']) > 100) $errors['name'] = 'Nama wajib diisi (2–100 karakter).';
    if (mb_strlen($values['email']) > 150 || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Masukkan email yang valid (maksimal 150 karakter).';
    if (!in_array($values['need_type'], ['Website','Sistem Kasir/Stok','Desain UI/UX','Konsultasi'], true)) $errors['need_type'] = 'Pilih jenis kebutuhan Anda.';
    if ($values['phone'] !== '' && (mb_strlen($values['phone']) < 6 || mb_strlen($values['phone']) > 20 || !preg_match('/^[0-9 +()\-]+$/', $values['phone']))) $errors['phone'] = 'Telepon hanya boleh berisi angka, spasi, +, -, dan tanda kurung (6–20 karakter).';
    if (mb_strlen($values['subject']) < 3 || mb_strlen($values['subject']) > 150 || preg_match('/[\r\n]/', $values['subject'])) $errors['subject'] = 'Subjek wajib diisi (3–150 karakter) tanpa baris baru.';
    if (mb_strlen($values['message']) < 10 || mb_strlen($values['message']) > 5000) $errors['message'] = 'Pesan wajib berisi 10–5.000 karakter.';
    if (!$db && empty($errors['form'])) $errors['form'] = 'Form kontak sedang tidak tersedia. Silakan hubungi saya melalui media sosial.';
    $ip = substr((string)($_SERVER['REMOTE_ADDR'] ?? 'unknown'), 0, 45);
    if (!$errors && contact_rate_limited($db, $ip)) $errors['form'] = 'Batas pesan tercapai. Silakan coba lagi dalam 10 menit.';
    if (!$errors) {
        try {
            $stmt = $db->prepare('INSERT INTO contact_messages (name,email,phone,subject,message,ip_address,user_agent) VALUES (:name,:email,:phone,:subject,:message,:ip,:agent)');
            $messageWithType = "Jenis kebutuhan: {$values['need_type']}\n\n{$values['message']}";
            $stmt->execute(['name'=>$values['name'],'email'=>$values['email'],'phone'=>$values['phone'] ?: null,'subject'=>$values['subject'],'message'=>$messageWithType,'ip'=>$ip,'agent'=>substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''),0,500)]);
            $recipient = $portfolioConfig['email'];
            if ($recipient && filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                $host = preg_replace('/[^a-zA-Z0-9.-]/', '', (string)($_SERVER['HTTP_HOST'] ?? 'localhost')) ?: 'localhost';
                $headers = "From: portfolio@{$host}\r\nReply-To: {$values['email']}";
                @mail($recipient, str_replace(["\r", "\n"], '', $values['subject']), "Nama: {$values['name']}\nEmail: {$values['email']}\nTelepon: {$values['phone']}\nJenis kebutuhan: {$values['need_type']}\n\n{$values['message']}", $headers);
            }
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); $_SESSION['csrf_expires'] = time() + 3600;
            flash('contact', ['type'=>'success','message'=>'Terima kasih! Pesanmu berhasil disimpan.']);
            header('Location: index.php', true, 303); exit;
        } catch (Throwable $exception) {
            error_log('Contact message could not be saved: ' . $exception->getMessage());
            $errors['form'] = 'Pesan belum dapat disimpan. Silakan coba lagi nanti.';
        }
    }
    $_SESSION['contact_errors'] = $errors; $_SESSION['contact_values'] = $values;
    flash('contact', ['type'=>'error','message'=>$errors['form'] ?? 'Periksa kembali isian formulir.']);
    header('Location: index.php', true, 303); exit;
}
$contactFlash = flash('contact');
$contactErrors = $_SESSION['contact_errors'] ?? []; unset($_SESSION['contact_errors']);
$contactValues = $_SESSION['contact_values'] ?? []; unset($_SESSION['contact_values']);
$skillGroups = ['Frontend'=>[], 'Backend'=>[], 'Database & Tools'=>[], 'CMS/Framework'=>[]];
foreach ($skills as $skill) { $category = (string)($skill['category'] ?? ''); if (isset($skillGroups[$category])) $skillGroups[$category][] = $skill; }
$categories = ['php'=>'PHP','java'=>'Java','design'=>'UI/UX'];
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Portofolio Aziza Ony Badu, siswa PPLG MAKN Ende yang mencari kesempatan magang pengembangan web.">
  <meta name="theme-color" content="#ffffff">
  <meta property="og:title" content="Aziza Ony Badu | Portofolio">
  <meta property="og:description" content="Siswa PPLG yang belajar pengembangan web full stack dan terbuka untuk kesempatan magang.">
  <meta property="og:type" content="website">
  <meta name="google-site-verification" content="Cg3aC95gry83m4ZUYeS8A4jDUnuiUtuEiWmFGH560nc">
  <link rel="stylesheet" href="assets/css/output.css?v=20261024-portfolio-layout">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="icon" href="assets/images/aziza-logo.png" type="image/png">
  <script>try{if(localStorage.getItem('aziza-theme')==='dark')document.documentElement.classList.add('dark')}catch(e){}</script>
  <title>Aziza Ony Badu | Portofolio</title>
</head>
<body class="overflow-x-hidden bg-canvas font-sans text-brand-ink transition-colors duration-300 dark:bg-slate-900 dark:text-slate-100">
  <div id="intro-screen" class="intro-screen" style="position:fixed;inset:0;z-index:1300;background:#020617" aria-hidden="true">
    <div class="intro-mark">
      <img class="intro-monogram" src="assets/images/ab-monogram.png" width="260" height="260" alt="" aria-hidden="true">
      <svg class="intro-butterfly" width="96" height="80" style="width:96px;height:80px;max-width:none" viewBox="0 0 96 80" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g class="butterfly-left-wing">
          <path d="M47 39C35 12 10 5 5 17C0 30 15 48 43 48C25 49 14 62 22 70C29 77 43 65 49 48" fill="#64B5F6" stroke="#1976D2" stroke-width="3"/>
          <path d="M39 36C28 22 17 19 12 21" stroke="#EAF5FF" stroke-width="2" stroke-linecap="round" opacity=".8"/>
        </g>
        <g class="butterfly-right-wing">
          <path d="M49 39C61 12 86 5 91 17C96 30 81 48 53 48C71 49 82 62 74 70C67 77 53 65 47 48" fill="#1976D2" stroke="#64B5F6" stroke-width="3"/>
          <path d="M57 36C68 22 79 19 84 21" stroke="#EAF5FF" stroke-width="2" stroke-linecap="round" opacity=".8"/>
        </g>
        <path d="M48 35V53M47 36C43 28 40 28 38 27M49 36C53 28 56 28 58 27" stroke="#EAF5FF" stroke-width="3" stroke-linecap="round"/>
      </svg>
      <svg class="intro-butterfly intro-butterfly-two" width="96" height="80" style="width:96px;height:80px;max-width:none" viewBox="0 0 96 80" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g class="butterfly-left-wing">
          <path d="M47 39C35 12 10 5 5 17C0 30 15 48 43 48C25 49 14 62 22 70C29 77 43 65 49 48" fill="#64B5F6" stroke="#1976D2" stroke-width="3"/>
          <path d="M39 36C28 22 17 19 12 21" stroke="#EAF5FF" stroke-width="2" stroke-linecap="round" opacity=".8"/>
        </g>
        <g class="butterfly-right-wing">
          <path d="M49 39C61 12 86 5 91 17C96 30 81 48 53 48C71 49 82 62 74 70C67 77 53 65 47 48" fill="#1976D2" stroke="#64B5F6" stroke-width="3"/>
          <path d="M57 36C68 22 79 19 84 21" stroke="#EAF5FF" stroke-width="2" stroke-linecap="round" opacity=".8"/>
        </g>
        <path d="M48 35V53M47 36C43 28 40 28 38 27M49 36C53 28 56 28 58 27" stroke="#EAF5FF" stroke-width="3" stroke-linecap="round"/>
      </svg>
    </div>
    <span class="intro-caption">AZIZA ONY BADU</span>
  </div>
  <div class="scroll-progress fixed inset-x-0 top-0 z-[1200] h-[3px] w-0 bg-gradient-to-r from-brand to-brand-light" aria-hidden="true"></div>
  <header id="site-header" class="fixed inset-x-0 top-4 z-50 mx-auto flex w-[calc(100%-2rem)] max-w-5xl items-center justify-between gap-3 rounded-full border border-slate-200 bg-white/90 px-4 py-2 shadow-lg shadow-blue-900/5 backdrop-blur-md transition-shadow duration-200 dark:border-slate-800 dark:bg-slate-900/90 sm:px-6">
    <a href="#home" class="flex shrink-0 items-center" aria-label="Aziza Badu, ke beranda"><img src="assets/images/aziza-logo.png" alt="Logo monogram Aziza Badu" width="56" height="56" class="h-12 w-12 object-contain"></a>
    <nav id="site-nav" class="absolute inset-x-0 top-[calc(100%+0.75rem)] hidden flex-col gap-2 rounded-3xl border border-slate-200 bg-white/95 p-4 shadow-xl shadow-blue-900/5 backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/95 lg:static lg:flex lg:flex-1 lg:flex-row lg:items-center lg:justify-center lg:gap-2 lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none dark:lg:bg-transparent" aria-label="Navigasi utama">
      <a class="nav-link" href="#home">Beranda</a><a class="nav-link" href="#layanan">Layanan</a><a class="nav-link" href="#portfolio">Portofolio</a><a class="nav-link" href="#about">Tentang</a>
      <a href="#kontak" class="mobile-contact-link btn-primary mt-2 w-full lg:hidden">Konsultasi</a>
    </nav>
    <div class="flex shrink-0 items-center gap-2 sm:gap-3">
      <button class="theme-toggle grid h-10 w-10 place-items-center rounded-full border border-brand text-brand transition hover:bg-brand hover:text-white dark:border-brand-light dark:text-brand-light" type="button" aria-label="Aktifkan mode gelap" title="Ganti tema"><i class="fa-solid fa-moon" aria-hidden="true"></i></button>
      <button id="menu-button" class="grid h-10 w-10 place-items-center rounded-full text-xl text-brand transition hover:bg-blue-50 dark:text-brand-light dark:hover:bg-slate-800 lg:hidden" type="button" aria-controls="site-nav" aria-expanded="false" aria-label="Buka menu"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
      <a href="#kontak" class="btn-primary hidden whitespace-nowrap lg:inline-flex">Konsultasi</a>
    </div>
  </header>

  <main>
    <section id="home" class="reveal scroll-mt-28 bg-gradient-to-b from-white via-blue-50/30 to-white dark:from-slate-900 dark:via-slate-950 dark:to-slate-900">
      <div class="mx-auto grid w-full max-w-6xl grid-cols-1 items-center gap-10 px-4 sm:px-6 md:grid-cols-2 lg:px-8">
        <div class="order-2 md:order-1">
          <p class="mb-2 text-lg font-semibold">Halo, saya</p><h1 class="bg-gradient-to-r from-brand to-brand-light bg-clip-text text-5xl font-extrabold leading-tight text-transparent md:text-6xl lg:text-7xl">Aziza Ony Badu</h1>
          <p class="mt-3 text-xl font-semibold md:text-2xl">Saya seorang <span class="typed-role text-brand dark:text-brand-light">Web Developer</span><span class="ml-1 animate-typing border-r-2 border-brand" aria-hidden="true"></span></p>
          <p class="mt-5 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300">Siswa PPLG MAKN Ende yang membantu UMKM dan bisnis kecil membangun website dan sistem web. Punya kendala stok, kasir, atau butuh website? Ceritakan dulu, kita cari solusinya bersama.</p>
          <p class="mt-3 text-sm text-slate-600 dark:text-slate-300"><i class="fa-solid fa-location-dot mr-2 text-brand dark:text-brand-light" aria-hidden="true"></i><?= e($profile['location']) ?></p>
          <div class="mt-6 flex flex-wrap gap-3"><a href="https://wa.me/<?= e($portfolioConfig['whatsapp']) ?>" target="_blank" rel="noopener noreferrer" class="btn-primary focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"><i class="fa-brands fa-whatsapp mr-2" aria-hidden="true"></i>Konsultasi Sekarang</a><a href="<?= e($profile['cv_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-secondary focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"><i class="fa-solid fa-download mr-2" aria-hidden="true"></i>Lihat CV</a></div>
          <div class="mt-5 flex flex-wrap gap-2"><span class="rounded-full bg-blue-50 px-4 py-1 text-sm text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">Siswa PPLG MAKN Ende</span><span class="rounded-full bg-blue-50 px-4 py-1 text-sm text-blue-700 dark:bg-blue-900/30 dark:text-blue-300"><?= count($projects) ?> Proyek</span><span class="rounded-full bg-blue-50 px-4 py-1 text-sm text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">Terbuka untuk Konsultasi</span></div>
          <div class="mt-6 flex flex-wrap gap-3" aria-label="Media sosial"><?php foreach ($socialLinks as $social): ?><a class="grid h-11 w-11 place-items-center rounded-full border border-brand text-lg text-brand transition hover:-translate-y-1 hover:bg-brand hover:text-white dark:border-brand-light dark:text-brand-light" href="<?= e($social['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Kunjungi <?= e($social['platform']) ?>"><i class="<?= e($social['icon_class']) ?>" aria-hidden="true"></i></a><?php endforeach; ?></div>
        </div>
        <div class="relative order-1 mx-auto w-full max-w-sm md:order-2 md:max-w-md">
          <span class="absolute -inset-5 -z-10 rounded-full bg-blue-200/50 blur-3xl dark:bg-blue-900/30" aria-hidden="true"></span>
          <!-- TODO: Ganti foto ini dengan foto resolusi lebih tinggi, minimal lebar 1000px. Foto yang sama dipakai di Tentang. -->
          <img src="assets/images/<?= e(basename((string)($profile['photo'] ?? 'zaza.png'))) ?>" alt="Foto Aziza Ony Badu, siswa PPLG dan web developer dari Ende" width="700" height="700" fetchpriority="high" class="mx-auto aspect-square w-[75vw] max-w-sm rounded-[44%_56%_62%_38%/42%_42%_58%_58%] border-4 border-brand object-cover object-top shadow-xl shadow-brand/20 md:w-full">
        </div>
      </div>
    </section>

    <section id="layanan" class="reveal scroll-mt-28 bg-white dark:bg-slate-900">
      <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
        <p class="eyebrow">Layanan</p><h2 class="section-title">Bantuan untuk <span>Bisnis Anda</span></h2><p class="section-description">Solusi website dan sistem web yang dirancang sesuai kebutuhan usaha.</p>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
          <?php $services = [
            ['Website','Website company profile atau toko online yang rapi dan responsif.','fa-globe'],
            ['Sistem Kasir & Stok','Aplikasi POS dan pencatatan stok untuk UMKM, mengurangi pencatatan manual.','fa-cash-register'],
            ['Desain UI/UX','Rancangan tampilan di Figma sebelum dibangun, supaya hasil sesuai harapan.','fa-pen-ruler'],
            ['Konsultasi','Bingung mulai dari mana? Ceritakan masalahmu, saya bantu mencari solusi yang paling masuk akal.','fa-comments'],
          ]; foreach ($services as $i=>$service): ?>
          <article class="card reveal" style="--i:<?= (int)$i ?>"><span class="mb-5 grid h-12 w-12 place-items-center rounded-xl bg-blue-50 text-xl text-brand dark:bg-blue-900/30 dark:text-brand-light"><i class="fa-solid <?= e($service[2]) ?>" aria-hidden="true"></i></span><h3 class="mb-2 text-lg font-semibold"><?= e($service[0]) ?></h3><p class="text-sm leading-6 text-slate-600 dark:text-slate-300"><?= e($service[1]) ?></p></article>
          <?php endforeach; ?>
        </div>
        <div class="mt-8 flex flex-col items-center justify-between gap-4 rounded-2xl border border-blue-100 bg-blue-50/70 p-5 text-center dark:border-slate-800 dark:bg-slate-950 sm:flex-row sm:text-left"><p class="text-sm text-slate-700 dark:text-slate-300">Konsultasi awal gratis. Estimasi biaya dan waktu disesuaikan kebutuhan.</p><a href="#kontak" class="btn-primary shrink-0">Mulai Konsultasi</a></div>
      </div>
    </section>

    <section id="portfolio" class="reveal scroll-mt-28 bg-blue-50 dark:bg-slate-950">
      <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
        <p class="eyebrow">Portofolio</p><h2 class="section-title">Proyek <span>Pilihan</span></h2><p class="section-description">Beberapa proyek yang saya kerjakan untuk berlatih dan menyelesaikan kebutuhan nyata.</p>
        <div class="project-filters mb-10 flex flex-wrap justify-center gap-3" role="group" aria-label="Filter proyek"><button class="filter-btn active" type="button" data-filter="all" aria-pressed="true">Semua</button><?php foreach ($categories as $key=>$label): ?><button class="filter-btn" type="button" data-filter="<?= e($key) ?>" aria-pressed="false"><?= e($label) ?></button><?php endforeach; ?></div>
        <?php $mainProjects = array_slice($projects, 0, 3); $practiceProjects = array_slice($projects, 3); ?>
        <div class="project-group mb-12" data-project-group>
          <h3 class="mb-5 text-2xl font-semibold">Proyek <span class="text-brand dark:text-brand-light">Utama</span></h3>
          <div class="grid grid-cols-1 items-stretch gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($mainProjects as $i=>$project) include __DIR__ . '/includes/project-card.php'; ?>
          </div>
        </div>
        <div class="project-group" data-project-group>
          <h3 class="mb-5 text-xl font-semibold text-slate-700 dark:text-slate-200">Proyek Latihan</h3>
          <div class="mx-auto grid max-w-4xl grid-cols-1 items-stretch gap-5 md:grid-cols-2">
            <?php foreach ($practiceProjects as $i=>$project) { $i += count($mainProjects); include __DIR__ . '/includes/project-card.php'; } ?>
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="reveal scroll-mt-28 bg-white dark:bg-slate-900 motion-reduce:transition-none">
      <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-10 md:grid-cols-2">
          <img src="assets/images/<?= e(basename((string)($profile['photo'] ?? 'zaza.png'))) ?>" alt="Foto Aziza Ony Badu, siswa PPLG MAKN Ende" width="700" height="700" loading="lazy" class="mx-auto aspect-square w-full max-w-sm rounded-3xl border-4 border-brand object-cover object-top shadow-xl md:max-w-md">
          <div>
            <p class="eyebrow text-left">Tentang</p><h2 class="section-title text-left">Tentang <span>Saya</span></h2>
            <h3 class="text-lg font-semibold leading-relaxed text-slate-700 dark:text-slate-200 md:whitespace-nowrap">Siswa PPLG MAKN Ende · Web Developer</h3>
            <p class="mt-5 text-base leading-8 text-slate-700 dark:text-slate-300">Saya siswa jurusan Pengembangan Perangkat Lunak dan Gim (PPLG) di MAKN Ende yang fokus pada pengembangan web. Saya sudah membangun sistem stok dan penjualan untuk UMKM pakaian di Flores Timur, aplikasi kasir POS Beauty sebagai tugas akhir kelas industri, serta merancang UI/UX website di Figma. Saya suka membantu pemilik usaha mengubah masalah sehari-hari menjadi sistem yang mudah dipakai.</p>
            <div class="mt-6 flex flex-wrap gap-4"><a href="<?= e($profile['cv_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-secondary"><i class="fa-solid fa-download mr-2" aria-hidden="true"></i>Download CV</a><a href="#kontak" class="btn-primary">Konsultasi</a></div>
          </div>
        </div>
        <div class="mt-12 grid grid-cols-1 items-start gap-6 md:grid-cols-3">
          <div id="education" class="card scroll-mt-28 reveal"><h3 class="mb-6 text-xl font-semibold">Pendidikan</h3><div class="relative space-y-6 before:absolute before:bottom-2 before:left-[7px] before:top-2 before:w-0.5 before:bg-brand dark:before:bg-brand-light">
            <?php foreach ($education as $item): ?><article class="relative pl-8"><span class="absolute left-0 top-1 h-4 w-4 rounded-full bg-brand ring-4 ring-white dark:bg-brand-light dark:ring-slate-900" aria-hidden="true"></span><h4 class="font-semibold"><?= e($item['school']) ?></h4><?php if (!empty($item['major'])): ?><p class="mt-1 text-sm font-medium text-brand dark:text-brand-light"><?= e($item['major']) ?></p><?php endif; ?><p class="mt-1 text-sm text-slate-600 dark:text-slate-300"><?= e($item['start_year']) ?> – <?= e($item['end_year']) ?></p><p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300"><?= e($item['description'] ?? '') ?></p></article><?php endforeach; ?>
          </div></div>
          <div id="skills" class="card scroll-mt-28 reveal"><h3 class="mb-5 text-xl font-semibold">Keahlian</h3><div class="space-y-5">
            <?php foreach ($skillGroups as $category=>$groupSkills): if (!$groupSkills) continue; $categoryLabel = $category === 'CMS/Framework' ? 'Framework/CMS' : $category; ?><div><h4 class="mb-2 text-sm font-semibold text-slate-600 dark:text-slate-300"><?= e($categoryLabel) ?></h4><div class="flex flex-wrap gap-2"><?php foreach ($groupSkills as $skill): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300"><i class="<?= e($skill['icon_class']) ?>" aria-hidden="true"></i><?= e($skill['name']) ?></span><?php endforeach; ?></div></div><?php endforeach; ?>
          </div></div>
          <div id="workflow" class="card scroll-mt-28 reveal"><h3 class="mb-2 text-xl font-semibold">Cara Saya Bekerja</h3><p class="mb-5 text-sm leading-6 text-slate-600 dark:text-slate-300">Setiap proyek saya kerjakan melalui langkah yang terarah agar kebutuhan jelas dan hasilnya sesuai tujuan.</p><div class="space-y-4">
            <?php $workflowSteps = [
              ['Diskusi','Memahami kebutuhan, tujuan, dan ruang lingkup proyek.'],
              ['Riset & Konsep','Mencari referensi dan menyusun arah solusi serta tampilan.'],
              ['Pengerjaan','Membangun desain atau website berdasarkan konsep yang disepakati.'],
              ['Revisi','Meninjau hasil dan menyempurnakannya dari masukan yang diberikan.'],
              ['Serah Terima','Menyerahkan hasil akhir beserta file atau aset proyek.'],
            ]; foreach ($workflowSteps as $step): ?>
            <div class="flex items-start gap-3"><span class="mt-1 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-blue-50 text-xs text-blue-700 dark:bg-blue-900/30 dark:text-blue-300"><i class="fa-solid fa-check" aria-hidden="true"></i></span><p class="text-sm leading-6"><span class="font-semibold"><?= e($step[0]) ?></span> — <?= e($step[1]) ?></p></div>
            <?php endforeach; ?>
          </div><!-- TODO: Tambahkan keterangan dukungan setelah serah terima jika sudah ditentukan. --></div>
        </div>
      </div>
    </section>

    <dialog id="project-modal" class="m-auto max-h-[90vh] w-[min(92vw,48rem)] overflow-y-auto rounded-2xl border border-slate-200 bg-white p-0 text-brand-ink shadow-2xl backdrop:bg-slate-950/70 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100" aria-labelledby="project-modal-title">
      <div class="relative">
        <button type="button" id="project-modal-close" class="absolute right-4 top-4 z-10 grid h-10 w-10 place-items-center rounded-full bg-white text-xl text-slate-900 shadow-lg transition hover:bg-slate-100 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2" aria-label="Tutup detail proyek"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        <img id="project-modal-image" src="" alt="" class="max-h-[38vh] w-full bg-slate-100 object-contain dark:bg-slate-950">
        <div class="p-6 sm:p-8">
          <span id="project-modal-category" class="rounded-full bg-brand/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand dark:bg-brand-light/15 dark:text-brand-light"></span>
          <h2 id="project-modal-title" class="mt-4 text-2xl font-bold sm:text-3xl"></h2>
          <p class="mt-3 text-sm text-slate-600 dark:text-slate-300"><span class="font-semibold text-brand-ink dark:text-white">Peran saya:</span> <span id="project-modal-role"></span></p>
          <div class="mt-5 space-y-4"><div><h3 class="font-semibold">Masalah</h3><p id="project-modal-problem" class="mt-1 leading-7 text-slate-600 dark:text-slate-300"></p></div><div><h3 class="font-semibold">Solusi</h3><p id="project-modal-solution" class="mt-1 leading-7 text-slate-600 dark:text-slate-300"></p></div><div><h3 class="font-semibold">Hasil</h3><p id="project-modal-result" class="mt-1 leading-7 text-slate-600 dark:text-slate-300"></p></div></div>
          <div id="project-modal-tech" class="mt-5 flex flex-wrap gap-2" aria-label="Teknologi proyek"></div>
          <div class="mt-7 flex flex-wrap gap-3">
            <a id="project-modal-github" class="btn-secondary" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-github mr-2" aria-hidden="true"></i>Source Code</a>
            <a id="project-modal-demo" class="btn-primary" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-arrow-up-right-from-square mr-2" aria-hidden="true"></i>Live Demo</a>
            <a id="project-modal-figma" class="btn-secondary" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-figma mr-2" aria-hidden="true"></i>Lihat Desain Figma</a>
          </div>
        </div>
      </div>
    </dialog>

    <?php $emailAvailable = filter_var($portfolioConfig['email'], FILTER_VALIDATE_EMAIL) !== false; ?>
    <section id="kontak" class="reveal scroll-mt-28 bg-blue-50 text-brand-ink dark:bg-slate-950 dark:text-slate-100"><span id="contact" class="block scroll-mt-28"></span>
      <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
      <p class="eyebrow">Kontak</p><h2 class="section-title">Hubungi <span>Saya</span></h2><p class="section-description">Punya kendala stok, kasir, atau butuh website? Ceritakan kebutuhan Anda. Konsultasi awal gratis. Saya balas dalam 1-2 hari kerja.</p>
      <?php if (is_array($contactFlash)): ?><p class="mx-auto mb-6 max-w-6xl rounded-xl <?= $contactFlash['type']==='success' ? 'bg-emerald-100 text-emerald-900 dark:bg-emerald-900/60 dark:text-emerald-100' : 'bg-red-100 text-red-900 dark:bg-red-900/60 dark:text-red-100' ?> p-4" role="status"><?= e($contactFlash['message']) ?></p><?php endif; ?>
      <div class="grid items-start gap-8 lg:grid-cols-2 lg:gap-10">
        <div class="pt-1">
          <div class="grid gap-4">
            <?php if ($emailAvailable): ?><a href="mailto:<?= e($portfolioConfig['email']) ?>" class="card group flex items-center gap-5 p-5"><span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-brand/10 text-xl text-brand dark:text-brand-light"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span><span class="min-w-0"><span class="block text-sm text-slate-500 dark:text-slate-400">Email</span><span class="break-all font-semibold"><?= e($portfolioConfig['email']) ?></span></span></a><?php endif; ?>
            <a href="https://wa.me/<?= e($portfolioConfig['whatsapp']) ?>" target="_blank" rel="noopener noreferrer" class="card group flex items-center gap-5 p-5"><span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-brand/10 text-xl text-brand dark:text-brand-light"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></span><span><span class="block text-sm text-slate-500 dark:text-slate-400">WhatsApp</span><span class="font-semibold">Chat langsung</span></span></a>
          </div>
          <ol class="mt-8 grid gap-4 text-sm text-slate-700 dark:text-slate-300"><li class="flex items-center gap-3"><span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white font-semibold text-brand dark:bg-slate-900">1</span>Kirim pesan</li><li class="flex items-center gap-3"><span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white font-semibold text-brand dark:bg-slate-900">2</span>Saya balas dan jadwalkan diskusi</li><li class="flex items-center gap-3"><span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white font-semibold text-brand dark:bg-slate-900">3</span>Kita susun solusi dan estimasi</li></ol>
        </div>
        <form id="contact-form" action="https://formspree.io/f/mgaawjbb" method="post" class="card grid gap-1 p-6 sm:p-8" novalidate>
          <input type="hidden" name="_subject" value="Pesan melalui formulir portofolio">
          <div class="sr-only" aria-hidden="true"><label for="website">Jangan isi kolom ini</label><input id="website" type="text" name="_gotcha" tabindex="-1" autocomplete="off"></div>
          <div class="mb-3"><label class="mb-2 block text-sm font-semibold" for="name">Nama</label><input class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-brand-ink placeholder:text-slate-500 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-400" id="name" name="name" autocomplete="name" minlength="2" maxlength="100" required placeholder="Nama lengkap Anda" value="<?= e($contactValues['name'] ?? '') ?>" aria-describedby="name-error"><p id="name-error" class="mt-1 text-sm text-red-700 dark:text-red-300"><?= e($contactErrors['name'] ?? '') ?></p></div>
          <div class="mb-3"><label class="mb-2 block text-sm font-semibold" for="email">Email</label><input class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-brand-ink placeholder:text-slate-500 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-400" id="email" type="email" name="email" autocomplete="email" maxlength="150" required placeholder="email@contoh.com" value="<?= e($contactValues['email'] ?? '') ?>" aria-describedby="email-error"><p id="email-error" class="mt-1 text-sm text-red-700 dark:text-red-300"><?= e($contactErrors['email'] ?? '') ?></p></div>
          <div class="mb-3"><label class="mb-2 block text-sm font-semibold" for="phone">Nomor WhatsApp (opsional)</label><input class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-brand-ink placeholder:text-slate-500 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-400" id="phone" type="tel" name="phone" autocomplete="tel" maxlength="20" placeholder="08xx-xxxx-xxxx" value="<?= e($contactValues['phone'] ?? '') ?>"></div>
          <div class="mb-3"><label class="mb-2 block text-sm font-semibold" for="need_type">Jenis kebutuhan</label><select id="need_type" name="need_type" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-brand-ink focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-950 dark:text-white" aria-describedby="need-type-error"><option value="">Pilih jenis kebutuhan</option><?php foreach (['Website','Sistem Kasir/Stok','Desain UI/UX','Konsultasi'] as $needType): ?><option value="<?= e($needType) ?>" <?= ($contactValues['need_type'] ?? '') === $needType ? 'selected' : '' ?>><?= e($needType) ?></option><?php endforeach; ?></select><p id="need-type-error" class="mt-1 text-sm text-red-700 dark:text-red-300"><?= e($contactErrors['need_type'] ?? '') ?></p></div>
          <div class="mb-2"><label class="mb-2 block text-sm font-semibold" for="message">Pesan</label><textarea class="w-full resize-y rounded-2xl border border-slate-300 bg-white px-4 py-3 text-brand-ink placeholder:text-slate-500 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-400" id="message" name="message" rows="4" minlength="10" maxlength="5000" required placeholder="Ceritakan masalah atau kebutuhan Anda..." aria-describedby="message-error"><?= e($contactValues['message'] ?? '') ?></textarea><p id="message-error" class="mt-1 text-sm text-red-700 dark:text-red-300"><?= e($contactErrors['message'] ?? '') ?></p></div>
          <p id="contact-form-status" class="hidden rounded-2xl px-5 py-4 text-sm font-semibold" role="status" aria-live="polite"></p><button class="btn-primary mt-1 w-full" type="submit"><i class="fa-solid fa-paper-plane mr-2" aria-hidden="true"></i>Kirim Pesan</button>
        </form>
      </div>
      </div>
    </section>
  </main>
  <footer class="bg-white px-[5%] py-8 text-center dark:bg-slate-900"><div class="mb-5 flex justify-center gap-4"><?php foreach ($socialLinks as $social): ?><a class="grid h-10 w-10 place-items-center rounded-full border border-brand text-brand transition hover:bg-brand hover:text-white dark:border-brand-light dark:text-brand-light" href="<?= e($social['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Kunjungi <?= e($social['platform']) ?>"><i class="<?= e($social['icon_class']) ?>" aria-hidden="true"></i></a><?php endforeach; ?></div><p class="text-sm text-slate-600 dark:text-slate-400">&copy; <?= date('Y') ?> Aziza Ony Badu · Hak cipta dilindungi.</p></footer>
  <a href="#home" id="back-to-top" class="fixed bottom-5 right-5 z-40 hidden h-12 w-12 place-items-center rounded-full bg-brand text-white shadow-lg transition hover:-translate-y-1" aria-label="Kembali ke atas"><i class="fa-solid fa-arrow-up" aria-hidden="true"></i></a>
  <script src="assets/js/app.js?v=20261024-client-refresh" defer></script>
</body>
</html>
