USE aziza_portfolio;

START TRANSACTION;

-- Add the optional Figma design link for existing databases, only when missing.
SET @has_figma_url = (
  SELECT COUNT(*)
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'projects'
    AND COLUMN_NAME = 'figma_url'
);
SET @add_figma_url_sql = IF(
  @has_figma_url = 0,
  'ALTER TABLE projects ADD COLUMN figma_url VARCHAR(500) NULL AFTER demo_url',
  'SELECT 1'
);
PREPARE add_figma_url_stmt FROM @add_figma_url_sql;
EXECUTE add_figma_url_stmt;
DEALLOCATE PREPARE add_figma_url_stmt;

-- Remove the three projects built with HTML/CSS from the portfolio.
DELETE FROM projects
WHERE slug IN ('box-biodata', 'desain-situs-web', 'situs-web-toko-buku');

-- Keep the remaining projects in a compact display order.
UPDATE projects
SET sort_order = CASE slug
  WHEN 'aplikasi-input-biodata' THEN 4
  WHEN 'aplikasi-kalkulator' THEN 5
  ELSE sort_order
END
WHERE slug IN ('aplikasi-input-biodata', 'aplikasi-kalkulator');

DELETE FROM projects WHERE slug = 'rancangan-ui-ux-figma';

-- Add or refresh the PHP, MySQL, and Tailwind inventory and sales project.
INSERT INTO projects (
  title, slug, description, image, category, tech_stack,
  github_url, demo_url, figma_url, is_featured, sort_order
) VALUES (
  'Sistem Stok & Penjualan Toko Pakaian',
  'sistem-stok-penjualan-toko-pakaian',
  'Sistem web yang dikembangkan setelah melihat langsung kendala UMKM pakaian di Flores Timur dalam mencatat barang masuk dan keluar serta menghitung belanja saat penjualan. Sistem membantu mengelola stok dan transaksi agar pencatatan persediaan lebih rapi dan perhitungan total belanja lebih akurat.',
  'sistem-stok-toko-pakaian.png',
  'php',
  'PHP,MySQL,Tailwind CSS',
  NULL,
  NULL,
  NULL,
  1,
  1
)
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  description = VALUES(description),
  image = VALUES(image),
  category = VALUES(category),
  tech_stack = VALUES(tech_stack),
  figma_url = VALUES(figma_url),
  is_featured = VALUES(is_featured),
  sort_order = VALUES(sort_order);

-- Add or refresh the industry-class final project, POS Beauty.
INSERT INTO projects (
  title, slug, description, image, category, tech_stack,
  github_url, demo_url, figma_url, is_featured, sort_order
) VALUES (
  'POS Beauty — Sistem Kasir Toko Kecantikan',
  'pos-beauty-point-of-sale',
  'Tugas akhir kelas industri berupa aplikasi Point of Sale (POS) untuk membantu proses operasional toko kecantikan. Dashboard menyajikan ringkasan jumlah customer, produk, dan transaksi terbaru. Aplikasi menyediakan pengelolaan customer, kategori, produk, dan admin, serta pencatatan transaksi penjualan dan laporan. Proyek ini menjadi latihan membangun alur kasir dan pengelolaan data toko dalam satu aplikasi web.',
  'pos-beauty.png',
  'php',
  'PHP,MySQL',
  NULL,
  NULL,
  NULL,
  1,
  2
)
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  description = VALUES(description),
  image = VALUES(image),
  category = VALUES(category),
  tech_stack = VALUES(tech_stack),
  figma_url = VALUES(figma_url),
  is_featured = VALUES(is_featured),
  sort_order = VALUES(sort_order);

-- Add the Figma-only Rizky Store design and its prototype link.
INSERT INTO projects (
  title, slug, description, image, category, tech_stack,
  github_url, demo_url, figma_url, is_featured, sort_order
) VALUES (
  'Desain Website Rizky Store di Figma',
  'rizky-store-figma',
  'Desain UI/UX di Figma untuk website Rizky Store, toko peralatan rumah tangga di Larantuka. Rancangan ini dibuat sebagai tahap awal sebelum rencana implementasi menggunakan WordPress. Desain mencakup navigasi Beranda, Produk, Kontak, dan Admin; hero promosi katalog; tombol kontak WhatsApp; serta informasi lokasi toko. Proyek saat ini masih berupa desain Figma dan belum diimplementasikan menjadi website WordPress.',
  'rizky-store-figma.png',
  'design',
  'Figma',
  NULL,
  NULL,
  'https://www.figma.com/design/rKcY8SvGhi7Zhzrb6ebyzG/Untitled?node-id=0-1&t=W7voMhDXMGZiaH3D-1',
  1,
  3
)
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  description = VALUES(description),
  image = VALUES(image),
  category = VALUES(category),
  tech_stack = VALUES(tech_stack),
  figma_url = VALUES(figma_url),
  is_featured = VALUES(is_featured),
  sort_order = VALUES(sort_order);

COMMIT;
