<?php
declare(strict_types=1);

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (int)($_SERVER['SERVER_PORT'] ?? 0) === 443;
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => $isHttps, 'path' => '/']);
session_start();
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';

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
$socialLinks = [
    ['platform'=>'GitHub','url'=>'https://github.com/azizaabadu','icon_class'=>'fa-brands fa-github'],
    ['platform'=>'X','url'=>'https://x.com/AzhinanN55825','icon_class'=>'fa-brands fa-x-twitter'],
    ['platform'=>'Instagram','url'=>'https://www.instagram.com/azizaabadu/','icon_class'=>'fa-brands fa-instagram'],
    ['platform'=>'LinkedIn','url'=>'https://www.linkedin.com/in/aziza-ony-badu-968a1240b/','icon_class'=>'fa-brands fa-linkedin']
];
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
$linkedinUrl = 'https://www.linkedin.com/in/aziza-ony-badu-968a1240b/';
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
$socialLinks = array_values(array_filter($socialLinks, static fn(array $social): bool => trim((string)($social['url'] ?? '')) !== ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    $values = ['name'=>trim((string)($_POST['name'] ?? '')), 'email'=>trim((string)($_POST['email'] ?? '')), 'phone'=>trim((string)($_POST['phone'] ?? '')), 'subject'=>trim((string)($_POST['subject'] ?? '')), 'message'=>trim((string)($_POST['message'] ?? ''))];
    $errors = [];
    if (!csrf_verify(isset($_POST['csrf_token']) ? (string)$_POST['csrf_token'] : null)) $errors['form'] = 'Sesi formulir kedaluwarsa atau token keamanan tidak valid. Muat ulang halaman, lalu coba lagi.';
    if (trim((string)($_POST['website'] ?? '')) !== '') $errors['form'] = 'Permintaan tidak dapat diproses.';
    if (mb_strlen($values['name']) < 2 || mb_strlen($values['name']) > 100) $errors['name'] = 'Nama wajib diisi (2–100 karakter).';
    if (mb_strlen($values['email']) > 150 || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Masukkan email yang valid (maksimal 150 karakter).';
    if ($values['phone'] !== '' && (mb_strlen($values['phone']) < 6 || mb_strlen($values['phone']) > 20 || !preg_match('/^[0-9 +()\-]+$/', $values['phone']))) $errors['phone'] = 'Telepon hanya boleh berisi angka, spasi, +, -, dan tanda kurung (6–20 karakter).';
    if (mb_strlen($values['subject']) < 3 || mb_strlen($values['subject']) > 150 || preg_match('/[\r\n]/', $values['subject'])) $errors['subject'] = 'Subjek wajib diisi (3–150 karakter) tanpa baris baru.';
    if (mb_strlen($values['message']) < 10 || mb_strlen($values['message']) > 5000) $errors['message'] = 'Pesan wajib berisi 10–5.000 karakter.';
    if (!$db && empty($errors['form'])) $errors['form'] = 'Form kontak sedang tidak tersedia. Silakan hubungi saya melalui media sosial.';
    $ip = substr((string)($_SERVER['REMOTE_ADDR'] ?? 'unknown'), 0, 45);
    if (!$errors && contact_rate_limited($db, $ip)) $errors['form'] = 'Batas pesan tercapai. Silakan coba lagi dalam 10 menit.';
    if (!$errors) {
        try {
            $stmt = $db->prepare('INSERT INTO contact_messages (name,email,phone,subject,message,ip_address,user_agent) VALUES (:name,:email,:phone,:subject,:message,:ip,:agent)');
            $stmt->execute(['name'=>$values['name'],'email'=>$values['email'],'phone'=>$values['phone'] ?: null,'subject'=>$values['subject'],'message'=>$values['message'],'ip'=>$ip,'agent'=>substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''),0,500)]);
            $recipient = getenv('PORTFOLIO_CONTACT_EMAIL');
            if ($recipient && filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                $host = preg_replace('/[^a-zA-Z0-9.-]/', '', (string)($_SERVER['HTTP_HOST'] ?? 'localhost')) ?: 'localhost';
                $headers = "From: portfolio@{$host}\r\nReply-To: {$values['email']}";
                @mail($recipient, str_replace(["\r", "\n"], '', $values['subject']), "Nama: {$values['name']}\nEmail: {$values['email']}\nTelepon: {$values['phone']}\n\n{$values['message']}", $headers);
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
  <link rel="stylesheet" href="assets/css/output.css?v=20261021-intro4">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="icon" href="assets/images/favicon-portfAB.png" type="image/png">
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
  <header class="fixed inset-x-0 top-0 z-50 flex items-center justify-between gap-4 bg-white/80 px-[5%] py-4 shadow-sm backdrop-blur-lg dark:bg-slate-900/85 md:px-[9%] 2xl:grid 2xl:grid-cols-[1fr_auto_1fr]">
    <a href="#home" class="bg-gradient-to-r from-brand to-brand-light bg-clip-text text-2xl font-extrabold text-transparent md:text-3xl 2xl:col-start-1 2xl:row-start-1">Aziza Badu</a>
    <nav id="site-nav" class="absolute inset-x-0 top-full hidden flex-col gap-1 bg-white/95 px-[5%] py-4 shadow-lg backdrop-blur-lg dark:bg-slate-900/95 md:static md:flex md:flex-row md:items-center md:gap-5 md:bg-transparent md:p-0 md:shadow-none dark:md:bg-transparent 2xl:col-start-2 2xl:row-start-1 2xl:justify-self-center" aria-label="Navigasi utama">
      <a class="nav-link" href="#home">Beranda</a><a class="nav-link" href="#about">Tentang</a><a class="nav-link" href="#education">Pendidikan</a><a class="nav-link" href="#skills">Keahlian</a><a class="nav-link" href="#portfolio">Portofolio</a><a class="nav-link" href="#contact">Kontak</a>
      <a href="#contact" class="mobile-contact-link btn-secondary mt-3 md:hidden">Hubungi Saya</a>
    </nav>
    <div class="flex items-center gap-3 2xl:col-start-3 2xl:row-start-1 2xl:justify-self-end">
      <button class="theme-toggle grid h-10 w-10 place-items-center rounded-full border border-brand text-brand transition hover:bg-brand hover:text-white dark:border-brand-light dark:text-brand-light md:hidden" type="button" aria-label="Aktifkan mode gelap" title="Ganti tema"><i class="fa-solid fa-moon" aria-hidden="true"></i></button>
      <button id="menu-button" class="grid h-10 w-10 place-items-center text-2xl text-brand md:hidden" type="button" aria-controls="site-nav" aria-expanded="false" aria-label="Buka menu"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
      <a href="#contact" class="btn-secondary hidden md:flex">Hubungi Saya</a>
      <button class="theme-toggle hidden h-10 w-10 place-items-center rounded-full border border-brand text-brand transition hover:bg-brand hover:text-white dark:border-brand-light dark:text-brand-light md:grid" type="button" aria-label="Aktifkan mode gelap" title="Ganti tema"><i class="fa-solid fa-moon" aria-hidden="true"></i></button>
    </div>
  </header>

  <main>
    <section id="home" class="reveal grid min-h-screen items-center gap-10 pt-32 md:grid-cols-[1.15fr_.85fr] md:pt-28">
      <div class="order-2 motion-safe:animate-hero-enter md:order-1">
        <p class="mb-2 text-lg font-semibold">Halo, saya</p><h1 class="bg-gradient-to-r from-brand to-brand-light bg-clip-text text-5xl font-extrabold leading-tight text-transparent md:text-7xl"><?= e($profile['name']) ?></h1>
        <p class="mt-3 text-xl font-semibold md:text-2xl">Saya seorang <span class="typed-role text-brand dark:text-brand-light">Web Developer</span><span class="ml-1 animate-typing border-r-2 border-brand"></span></p>
        <p class="mt-5 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300"><?= e($profile['bio']) ?></p>
        <p class="mt-3 text-sm text-slate-600 dark:text-slate-400"><i class="fa-solid fa-location-dot mr-2 text-brand dark:text-brand-light" aria-hidden="true"></i><?= e($profile['location']) ?></p>
        <div class="mt-6 flex flex-wrap gap-3" aria-label="Media sosial"><?php foreach ($socialLinks as $social): ?><a class="grid h-11 w-11 place-items-center rounded-full border-2 border-brand text-lg text-brand transition hover:-translate-y-1 hover:bg-brand hover:text-white dark:border-brand-light dark:text-brand-light" href="<?= e($social['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Kunjungi <?= e($social['platform']) ?>"><i class="<?= e($social['icon_class']) ?>" aria-hidden="true"></i></a><?php endforeach; ?></div>
        <div class="mt-3 flex flex-wrap gap-3"><a href="<?= e($profile['cv_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-primary"><i class="fa-solid fa-download mr-2" aria-hidden="true"></i>Lihat CV</a><a href="#contact" class="btn-secondary">Hubungi Saya</a></div>
      </div>
      <div class="order-1 mx-auto w-full max-w-sm motion-safe:animate-hero-enter motion-safe:delay-150 md:order-2 md:max-w-md"><img src="assets/images/<?= e(basename((string)($profile['photo'] ?? 'zaza.png'))) ?>" alt="Foto profil <?= e($profile['name']) ?>" width="700" height="700" fetchpriority="high" class="mx-auto aspect-square w-[75vw] max-w-sm border-4 border-brand object-cover shadow-xl shadow-brand/20 animate-morph md:w-full"></div>
    </section>

    <section id="about" class="reveal grid items-center gap-10 bg-brand-pale dark:bg-slate-800 md:grid-cols-2">
      <img src="assets/images/poto-za.png" alt="<?= e($profile['name']) ?>" width="700" height="700" loading="lazy" class="mx-auto aspect-square w-[70vw] max-w-sm rounded-3xl object-cover shadow-xl md:w-full">
      <div><h2 class="section-title text-left">Tentang <span>Saya</span></h2><h3 class="text-2xl font-semibold">Calon Web Developer</h3><p class="mt-5 text-base leading-8 text-slate-700 dark:text-slate-300">Saya senang membangun pengalaman web yang mudah digunakan dan terus mengembangkan kemampuan melalui latihan serta proyek. Saya antusias belajar dalam tim, menerima masukan, dan berkontribusi pada pekerjaan nyata selama magang.</p><a href="#skills" class="btn-primary mt-6">Lihat Keahlian</a></div>
    </section>

    <section id="education" class="reveal"><h2 class="section-title">Pendidikan <span>Saya</span></h2><div class="mx-auto grid max-w-4xl gap-6 md:grid-cols-2">
      <?php foreach ($education as $i=>$item): ?><article class="card reveal" style="--i:<?= (int)$i ?>"><div class="mb-4 grid h-12 w-12 place-items-center rounded-xl bg-brand/10 text-xl text-brand dark:bg-brand-light/15 dark:text-brand-light"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></div><h3 class="text-xl font-semibold"><?= e($item['school']) ?></h3><?php if (!empty($item['major'])): ?><p class="mt-2 font-medium text-brand dark:text-brand-light"><?= e($item['major']) ?></p><?php endif; ?><p class="mt-2 text-sm text-slate-600 dark:text-slate-300"><?= e($item['start_year']) ?> – <?= e($item['end_year']) ?></p><p class="mt-3 leading-7 text-slate-700 dark:text-slate-300"><?= e($item['description'] ?? '') ?></p></article><?php endforeach; ?>
    </div></section>

    <section id="skills" class="reveal bg-brand-pale dark:bg-slate-800"><h2 class="section-title">Keahlian <span>Saya</span></h2><div class="mx-auto max-w-6xl space-y-10">
      <?php foreach ($skillGroups as $category=>$groupSkills): if (!$groupSkills) continue; ?><div><h3 class="mb-4 text-xl font-semibold"><?= e($category) ?></h3><div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($groupSkills as $i=>$skill): $level = max(0, min(100, (int)$skill['level'])); ?><article class="card reveal" style="--i:<?= (int)$i ?>"><div class="flex items-center gap-4"><i class="<?= e($skill['icon_class']) ?> text-3xl text-brand dark:text-brand-light" aria-hidden="true"></i><div class="min-w-0 flex-1"><div class="flex items-center justify-between gap-3"><h4 class="font-semibold"><?= e($skill['name']) ?></h4><span class="text-sm text-slate-500 dark:text-slate-400"><?= $level ?>%</span></div><div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700"><div class="skill-fill h-full rounded-full bg-brand dark:bg-brand-light" style="--level:<?= $level ?>%" role="progressbar" aria-label="<?= e($skill['name']) ?>" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $level ?>"></div></div></div></div></article><?php endforeach; ?>
      </div></div><?php endforeach; ?>
    </div></section>

    <section id="portfolio" class="reveal"><h2 class="section-title">Proyek <span>Pilihan</span></h2><div class="project-filters mb-8 flex flex-wrap justify-center gap-3" role="group" aria-label="Filter proyek"><button class="filter-btn active" type="button" data-filter="all" aria-pressed="true">Semua</button><?php foreach ($categories as $key=>$label): ?><button class="filter-btn" type="button" data-filter="<?= e($key) ?>" aria-pressed="false"><?= e($label) ?></button><?php endforeach; ?></div>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($projects as $i=>$project): ?>
        <button type="button" class="project-card card group reveal w-full overflow-hidden p-0 text-left" style="--i:<?= (int)$i ?>" data-category="<?= e($project['category']) ?>" data-title="<?= e($project['title']) ?>" data-description="<?= e($project['description']) ?>" data-image="assets/images/<?= e(basename($project['image'])) ?>" data-category-label="<?= e($categories[$project['category']] ?? $project['category']) ?>" data-tech="<?= e($project['tech_stack']) ?>" data-github="<?= e($project['github_url'] ?? '') ?>" data-demo="<?= e($project['demo_url'] ?? '') ?>" data-figma="<?= e($project['figma_url'] ?? '') ?>" aria-haspopup="dialog" aria-label="Lihat detail proyek: <?= e($project['title']) ?>">
          <span class="relative block aspect-[16/10] overflow-hidden"><img src="assets/images/<?= e(basename($project['image'])) ?>" alt="" width="800" height="500" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105"><span class="absolute inset-0 bg-brand/0 transition duration-300 group-hover:bg-brand/15"></span></span>
          <span class="block p-5"><span class="mb-3 flex items-center justify-between gap-2"><span class="rounded-full bg-brand/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand dark:bg-brand-light/15 dark:text-brand-light"><?= e($categories[$project['category']] ?? $project['category']) ?></span><?php if (!empty($project['is_featured'])): ?><span class="text-xs font-semibold text-amber-600"><i class="fa-solid fa-star mr-1" aria-hidden="true"></i>Unggulan</span><?php endif; ?></span><span class="block text-xl font-semibold text-brand-ink dark:text-white"><?= e($project['title']) ?></span><span class="mt-2 block min-h-14 text-sm leading-6 text-slate-600 dark:text-slate-300"><?= e(mb_strimwidth((string)$project['description'], 0, 105, '…', 'UTF-8')) ?></span><span class="mt-5 flex items-center gap-2 text-sm font-semibold text-brand dark:text-brand-light">Lihat detail <i class="fa-solid fa-arrow-right transition group-hover:translate-x-1" aria-hidden="true"></i></span></span>
        </button>
        <?php endforeach; ?>
      </div>
    </section>

    <dialog id="project-modal" class="m-auto max-h-[90vh] w-[min(92vw,48rem)] overflow-y-auto rounded-2xl bg-white p-0 text-brand-ink shadow-2xl backdrop:bg-slate-950/70 dark:bg-slate-800 dark:text-slate-100" aria-labelledby="project-modal-title">
      <div class="relative">
        <button type="button" id="project-modal-close" class="absolute right-4 top-4 z-10 grid h-10 w-10 place-items-center rounded-full bg-white/90 text-xl text-slate-900 shadow transition hover:bg-white" aria-label="Tutup detail proyek"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        <img id="project-modal-image" src="" alt="" class="aspect-[16/9] w-full object-cover">
        <div class="p-6 sm:p-8">
          <span id="project-modal-category" class="rounded-full bg-brand/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand dark:bg-brand-light/15 dark:text-brand-light"></span>
          <h2 id="project-modal-title" class="mt-4 text-2xl font-bold sm:text-3xl"></h2>
          <p id="project-modal-description" class="mt-4 leading-7 text-slate-600 dark:text-slate-300"></p>
          <div id="project-modal-tech" class="mt-5 flex flex-wrap gap-2" aria-label="Teknologi proyek"></div>
          <div class="mt-7 flex flex-wrap gap-3">
            <a id="project-modal-github" class="btn-secondary" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-github mr-2" aria-hidden="true"></i>Source Code</a>
            <a id="project-modal-demo" class="btn-primary" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-arrow-up-right-from-square mr-2" aria-hidden="true"></i>Live Demo</a>
            <a id="project-modal-figma" class="btn-secondary" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-figma mr-2" aria-hidden="true"></i>Lihat Desain Figma</a>
          </div>
        </div>
      </div>
    </dialog>

    <?php
      $contactEmail = trim((string)(getenv('PORTFOLIO_CONTACT_EMAIL') ?: ($profile['email'] ?? '')));
      $contactPhone = preg_replace('/\D+/', '', (string)($profile['phone'] ?? ''));
      $instagram = current(array_filter($socialLinks, static fn(array $social): bool => strtolower((string)$social['platform']) === 'instagram')) ?: null;
    ?>
    <section id="contact" class="reveal bg-brand-pale text-brand-ink dark:bg-slate-800 dark:text-slate-100">
      <h2 class="section-title !text-brand-ink dark:!text-white">Hubungi <span>Saya</span></h2>
      <?php if (is_array($contactFlash)): ?><p class="mx-auto mb-6 max-w-6xl rounded-xl <?= $contactFlash['type']==='success' ? 'bg-emerald-100 text-emerald-900 dark:bg-emerald-900/60 dark:text-emerald-100' : 'bg-red-100 text-red-900 dark:bg-red-900/60 dark:text-red-100' ?> p-4" role="status"><?= e($contactFlash['message']) ?></p><?php endif; ?>
      <div class="mx-auto grid max-w-6xl items-start gap-10 lg:grid-cols-2 lg:gap-12">
        <div class="pt-1">
          <p class="mb-7 max-w-xl text-lg leading-8 text-slate-600 dark:text-slate-300">Saya terbuka untuk proyek website, sistem web, dan kolaborasi jangka panjang. Respons biasanya dalam 24 jam.</p>
          <div class="grid gap-4">
            <?php if ($contactEmail !== '' && filter_var($contactEmail, FILTER_VALIDATE_EMAIL)): ?><a href="mailto:<?= e($contactEmail) ?>" class="group flex items-center gap-5 rounded-3xl border border-slate-200 bg-white p-6 transition hover:border-slate-300 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900/70 dark:hover:border-slate-600 dark:hover:bg-slate-900"><span class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-brand/10 text-xl text-brand dark:bg-slate-800 dark:text-white"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span><span class="min-w-0"><span class="block text-sm text-slate-500 dark:text-slate-400">Email</span><span class="break-all font-semibold text-brand-ink dark:text-white"><?= e($contactEmail) ?></span></span></a><?php endif; ?>
            <?php if ($contactPhone !== ''): ?><a href="https://wa.me/<?= e($contactPhone) ?>" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-5 rounded-3xl border border-slate-200 bg-white p-6 transition hover:border-slate-300 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900/70 dark:hover:border-slate-600 dark:hover:bg-slate-900"><span class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-brand/10 text-xl text-brand dark:bg-slate-800 dark:text-white"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></span><span><span class="block text-sm text-slate-500 dark:text-slate-400">WhatsApp</span><span class="font-semibold text-brand-ink dark:text-white">Chat langsung</span></span></a>
            <?php elseif ($instagram): ?><a href="<?= e($instagram['url']) ?>" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-5 rounded-3xl border border-slate-200 bg-white p-6 transition hover:border-slate-300 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900/70 dark:hover:border-slate-600 dark:hover:bg-slate-900"><span class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-brand/10 text-xl text-brand dark:bg-slate-800 dark:text-white"><i class="fa-brands fa-instagram" aria-hidden="true"></i></span><span><span class="block text-sm text-slate-500 dark:text-slate-400">Instagram</span><span class="font-semibold text-brand-ink dark:text-white">Kirim pesan lewat DM</span></span></a><?php endif; ?>
          </div>
        </div>
        <form action="https://formspree.io/f/mgaawjbb" method="post" class="grid gap-1 rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-brand/10 sm:p-8 dark:border-slate-700 dark:bg-slate-900/70 dark:shadow-black/20" novalidate>
          <input type="hidden" name="_subject" value="Pesan melalui formulir portofolio"><input type="hidden" name="phone" value="<?= e($contactValues['phone'] ?? '') ?>">
          <div class="absolute -left-[10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true"><label for="website">Jangan isi kolom ini</label><input id="website" type="text" name="_gotcha" tabindex="-1" autocomplete="off"></div>
          <div class="mb-3"><label class="mb-2 block text-sm font-semibold text-slate-600 dark:text-slate-400" for="name">Nama</label><input class="w-full rounded-3xl border border-slate-300 bg-white px-5 py-5 text-brand-ink placeholder:text-slate-400 focus:border-brand focus:ring-0 dark:border-slate-700 dark:bg-slate-950/70 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-slate-500" id="name" name="name" autocomplete="name" minlength="2" maxlength="100" required placeholder="Nama lengkap Anda" value="<?= e($contactValues['name'] ?? '') ?>" aria-describedby="name-error"><p id="name-error" class="mt-1 text-sm text-red-700 dark:text-red-300"><?= e($contactErrors['name'] ?? '') ?></p></div>
          <div class="mb-3"><label class="mb-2 block text-sm font-semibold text-slate-600 dark:text-slate-400" for="email">Email</label><input class="w-full rounded-3xl border border-slate-300 bg-white px-5 py-5 text-brand-ink placeholder:text-slate-400 focus:border-brand focus:ring-0 dark:border-slate-700 dark:bg-slate-950/70 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-slate-500" id="email" type="email" name="email" autocomplete="email" maxlength="150" required placeholder="email@contoh.com" value="<?= e($contactValues['email'] ?? '') ?>" aria-describedby="email-error"><p id="email-error" class="mt-1 text-sm text-red-700 dark:text-red-300"><?= e($contactErrors['email'] ?? '') ?></p></div>
          <div class="mb-2"><label class="mb-2 block text-sm font-semibold text-slate-600 dark:text-slate-400" for="message">Pesan</label><textarea class="w-full resize-y rounded-3xl border border-slate-300 bg-white px-5 py-5 text-brand-ink placeholder:text-slate-400 focus:border-brand focus:ring-0 dark:border-slate-700 dark:bg-slate-950/70 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-slate-500" id="message" name="message" rows="4" minlength="10" maxlength="5000" required placeholder="Ceritakan tentang proyek Anda..." aria-describedby="message-error"><?= e($contactValues['message'] ?? '') ?></textarea><p id="message-error" class="mt-1 text-sm text-red-700 dark:text-red-300"><?= e($contactErrors['message'] ?? '') ?></p></div>
          <button class="mt-1 w-full rounded-full bg-brand px-6 py-5 font-semibold text-white transition hover:bg-blue-700 dark:bg-white dark:text-slate-950 dark:hover:bg-slate-200" type="submit">Kirim Pesan</button>
        </form>
      </div>
    </section>
  </main>
  <footer class="bg-white px-[5%] py-8 text-center dark:bg-slate-900"><div class="mb-5 flex justify-center gap-4"><?php foreach ($socialLinks as $social): ?><a class="grid h-10 w-10 place-items-center rounded-full border border-brand text-brand transition hover:bg-brand hover:text-white dark:border-brand-light dark:text-brand-light" href="<?= e($social['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Kunjungi <?= e($social['platform']) ?>"><i class="<?= e($social['icon_class']) ?>" aria-hidden="true"></i></a><?php endforeach; ?></div><p class="text-sm text-slate-600 dark:text-slate-400">&copy; <?= date('Y') ?> Aziza Ony Badu · Hak cipta dilindungi.</p></footer>
  <a href="#home" id="back-to-top" class="fixed bottom-5 right-5 z-40 hidden h-12 w-12 place-items-center rounded-full bg-brand text-white shadow-lg transition hover:-translate-y-1" aria-label="Kembali ke atas"><i class="fa-solid fa-arrow-up" aria-hidden="true"></i></a>
  <script src="assets/js/app.js?v=20261021-intro1" defer></script>
</body>
</html>
