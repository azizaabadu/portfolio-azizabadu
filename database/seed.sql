USE aziza_portfolio;

INSERT INTO profile (id, name, headline, bio, email, phone, location, cv_url, open_to_internship, photo) VALUES
(1, 'Aziza Ony Badu', 'Siswa PPLG · Web Developer', 'Siswa PPLG di MAKN Ende yang belajar pengembangan web full stack, termasuk Tailwind CSS, JavaScript, PHP, MySQL, dan Laravel. Mencari kesempatan magang untuk menerapkan keterampilan serta belajar dari tim pengembang profesional.', NULL, NULL, 'Ende, Nusa Tenggara Timur', 'assets/cv/cv-aziza-badu.pdf', 1, 'zaza.png')
ON DUPLICATE KEY UPDATE name=VALUES(name), bio=VALUES(bio);

INSERT INTO skills (name, icon_class, category, level, sort_order) VALUES
('HTML', 'fa-brands fa-html5', 'Frontend', 85, 1),
('CSS', 'fa-brands fa-css3-alt', 'Frontend', 80, 2),
('Tailwind CSS', 'fa-solid fa-wind', 'Frontend', 65, 3),
('JavaScript', 'fa-brands fa-js', 'Frontend', 65, 4),
('PHP', 'fa-brands fa-php', 'Backend', 60, 5),
('MySQL', 'fa-solid fa-database', 'Database & Tools', 60, 6),
('Java', 'fa-brands fa-java', 'Backend', 60, 7),
('Git & GitHub', 'fa-brands fa-github', 'Database & Tools', 65, 8),
('Laravel', 'fa-brands fa-laravel', 'CMS/Framework', 58, 9),
('WordPress', 'fa-brands fa-wordpress', 'CMS/Framework', 58, 10),
('Figma', 'fa-brands fa-figma', 'Database & Tools', 65, 11);

INSERT INTO education (school, major, start_year, end_year, description, sort_order) VALUES
('MAKN ENDE', 'Pengembangan Perangkat Lunak dan Gim (PPLG)', 2024, 'Sekarang', 'Sedang menempuh pendidikan dan mengembangkan keterampilan perangkat lunak.', 1),
('MTs N 1 ALOR', NULL, 2021, '2024', 'Pendidikan menengah pertama.', 2);

INSERT INTO projects (title, slug, description, image, category, tech_stack, github_url, demo_url, figma_url, is_featured, sort_order) VALUES
('Sistem Stok & Penjualan Toko Pakaian', 'sistem-stok-penjualan-toko-pakaian', 'Sistem web yang dikembangkan setelah melihat langsung kendala UMKM pakaian di Flores Timur dalam mencatat barang masuk dan keluar serta menghitung belanja saat penjualan. Sistem membantu mengelola stok dan transaksi agar pencatatan persediaan lebih rapi dan perhitungan total belanja lebih akurat.', 'sistem-stok-toko-pakaian.png', 'php', 'PHP,MySQL,Tailwind CSS', NULL, NULL, NULL, 1, 1),
('POS Beauty — Sistem Kasir Toko Kecantikan', 'pos-beauty-point-of-sale', 'Tugas akhir kelas industri berupa aplikasi Point of Sale (POS) untuk membantu proses operasional toko kecantikan. Dashboard menyajikan ringkasan jumlah customer, produk, dan transaksi terbaru. Aplikasi menyediakan pengelolaan customer, kategori, produk, dan admin, serta pencatatan transaksi penjualan dan laporan. Proyek ini menjadi latihan membangun alur kasir dan pengelolaan data toko dalam satu aplikasi web.', 'pos-beauty.png', 'php', 'PHP,MySQL', NULL, NULL, NULL, 1, 2),
('Desain Website Rizky Store di Figma', 'rizky-store-figma', 'Desain UI/UX di Figma untuk website Rizky Store, toko peralatan rumah tangga di Larantuka. Rancangan ini dibuat sebagai tahap awal sebelum rencana implementasi menggunakan WordPress. Desain mencakup navigasi Beranda, Produk, Kontak, dan Admin; hero promosi katalog; tombol kontak WhatsApp; serta informasi lokasi toko. Proyek saat ini masih berupa desain Figma dan belum diimplementasikan menjadi website WordPress.', 'rizky-store-figma.png', 'design', 'Figma', NULL, NULL, 'https://www.figma.com/design/rKcY8SvGhi7Zhzrb6ebyzG/Untitled?node-id=0-1&t=W7voMhDXMGZiaH3D-1', 1, 3),
('Aplikasi Input Biodata', 'aplikasi-input-biodata', 'Aplikasi Java untuk menerima dan menampilkan data biodata.', '3-2.png', 'java', 'Java', NULL, NULL, NULL, 0, 4),
('Aplikasi Kalkulator', 'aplikasi-kalkulator', 'Kalkulator sederhana untuk operasi aritmetika dasar.', '4-2.png', 'java', 'Java', NULL, NULL, NULL, 0, 5);

INSERT INTO social_links (platform, url, icon_class, sort_order) VALUES
('GitHub', 'https://github.com/azizaabadu', 'fa-brands fa-github', 1),
('X', 'https://x.com/AzhinanN55825', 'fa-brands fa-x-twitter', 2),
('Instagram', 'https://www.instagram.com/azizaabadu/', 'fa-brands fa-instagram', 3),
('LinkedIn', '', 'fa-brands fa-linkedin', 4);
