# Dokumentasi Teknis SatSetSabi

## 1. Project Overview
SatSetSabi adalah website layanan pembelian item/produk digital game (Top-Up). MVP berfokus pada katalog, pemesanan, unggah bukti pembayaran manual, verifikasi admin, dan pelacakan status. Sistem dirancang agar payment gateway dan supplier otomatis dapat ditambahkan melalui service layer.

### Tujuan
- Mempermudah pelanggan membeli nominal Top-Up.
- Menyediakan proses transaksi yang dapat dilacak.
- Memusatkan pengelolaan produk dan pesanan pada admin.
- Menyediakan fondasi yang dapat dikembangkan.

### Batasan MVP
- Tidak ada integrasi supplier Top-Up otomatis.
- Tidak ada verifikasi pembayaran otomatis.
- Metode pembayaran dicatat sebagai instruksi/manual transfer; admin memverifikasi dana di kanal resmi.
- Belum ada refund otomatis, voucher, loyalty point, atau multi-vendor.

## 2. Arsitektur
Arsitektur menggunakan pola Laravel MVC:
1. Browser mengakses route web.
2. Middleware memeriksa autentikasi dan role.
3. Controller memvalidasi request dan mengorkestrasi proses.
4. Eloquent Model berinteraksi dengan MySQL.
5. Blade merender halaman.
6. File bukti pembayaran disimpan pada Laravel Storage disk `public`.

### Komponen
- Presentation: Blade, Tailwind CSS, JavaScript.
- Application: Controllers, middleware, validation, business workflow.
- Domain/data: Eloquent models dan migrations.
- Storage: MySQL dan file storage.
- Integrasi masa depan: payment gateway dan provider top-up melalui service adapter.

## 3. Tech Stack
| Komponen | Teknologi |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, HTML, Tailwind CSS, JavaScript |
| Database | MySQL 8+ |
| ORM | Eloquent |
| Authentication | Laravel session authentication |
| Asset bundling | Vite |
| File storage | Laravel Filesystem |
| API | Laravel JSON endpoints (pengembangan lanjutan) |
| Version control | Git |

## 4. Struktur Database

### `users`
- id (PK)
- name
- email (unique)
- password
- role (`admin` / `user`)
- timestamps

### `categories`
- id (PK)
- name
- slug (unique)
- description (nullable)
- is_active
- timestamps

### `products`
- id (PK)
- category_id (FK -> categories.id)
- name
- slug (unique)
- description (nullable)
- image (nullable)
- is_active
- timestamps

### `denominations`
- id (PK)
- product_id (FK -> products.id)
- name
- price (integer, rupiah)
- is_active
- timestamps

### `orders`
- id (PK)
- user_id (FK -> users.id)
- denomination_id (FK -> denominations.id)
- order_code (unique)
- player_id
- server_id (nullable)
- customer_note (nullable)
- amount (integer, rupiah; snapshot harga saat order)
- payment_method (`bank_transfer` / `qris_manual`)
- payment_status (`unpaid` / `pending_verification` / `paid` / `rejected`)
- order_status (`pending_payment` / `processing` / `completed` / `failed` / `cancelled`)
- payment_proof (nullable)
- paid_at (nullable)
- timestamps

### Relasi
- Category hasMany Products.
- Product belongsTo Category; hasMany Denominations.
- Denomination belongsTo Product; hasMany Orders.
- User hasMany Orders.
- Order belongsTo User and Denomination.

### Indeks dan integritas
Email, slug, dan order_code unik. Foreign key menggunakan cascade/restrict sesuai kebutuhan. Harga disimpan sebagai integer rupiah untuk menghindari floating-point rounding.

## 5. API / Endpoint

MVP menggunakan web routes. Endpoint JSON dapat ditambahkan tanpa mengubah domain model. Endpoint web utama:

| Method | URL | Akses | Fungsi |
|---|---|---|---|
| GET | `/` | Publik | Landing page/katalog |
| GET | `/games/{slug}` | Publik | Detail game |
| GET, POST | `/register` | Guest | Registrasi |
| GET, POST | `/login` | Guest | Login |
| POST | `/logout` | Auth | Logout |
| GET | `/checkout/{denomination}` | Auth | Form checkout |
| POST | `/orders` | Auth | Membuat order |
| GET | `/orders` | Auth | Riwayat order |
| GET | `/orders/{order}` | Pemilik/Admin | Detail order |
| POST | `/orders/{order}/payment-proof` | Pemilik | Upload bukti |
| GET | `/admin` | Admin | Dashboard |
| Resource | `/admin/categories` | Admin | CRUD kategori |
| Resource | `/admin/products` | Admin | CRUD produk |
| Resource | `/admin/denominations` | Admin | CRUD nominal |
| GET | `/admin/orders` | Admin | Daftar order |
| PATCH | `/admin/orders/{order}/status` | Admin | Update status |

### Rancangan API JSON (belum diimplementasikan)
- `GET /api/v1/games`
- `GET /api/v1/games/{slug}`
- `POST /api/v1/orders` (authenticated)
- `GET /api/v1/orders/{orderCode}` (owner/admin)
- `POST /api/v1/orders/{orderCode}/payment-proof` (owner)

Gunakan API Resource, Sanctum, throttling, dan versioning saat endpoint mobile/third-party benar-benar dibutuhkan.

## 6. User Role & Permission

| Fitur | Guest | User | Admin |
|---|---:|---:|---:|
| Lihat katalog | Ya | Ya | Ya |
| Lihat detail produk | Ya | Ya | Ya |
| Buat pesanan | Tidak | Ya | Ya |
| Lihat riwayat sendiri | Tidak | Ya | Ya |
| Upload bukti bayar | Tidak | Ya, order sendiri | Ya |
| Kelola katalog | Tidak | Tidak | Ya |
| Lihat seluruh pesanan | Tidak | Tidak | Ya |
| Verifikasi pembayaran | Tidak | Tidak | Ya |
| Ubah status pemrosesan | Tidak | Tidak | Ya |

## 7. Fitur yang Sudah Selesai (cakupan source MVP)
- Struktur Laravel overlay dan konfigurasi frontend.
- Autentikasi register/login/logout.
- Role admin/user dan middleware admin.
- Katalog kategori, game, dan nominal.
- Pembuatan order dengan snapshot harga.
- Riwayat dan detail order.
- Upload bukti pembayaran.
- Dashboard admin, CRUD katalog, dan pengelolaan status order.
- Seeder akun demo dan data katalog.
- Validasi request dasar dan dokumentasi.

Catatan: daftar ini menjelaskan fitur yang disediakan source code. Status benar-benar berjalan harus dibuktikan dengan instalasi, migrasi, dan pengujian di lingkungan lokal.

## 8. Fitur yang Belum Selesai
- Integrasi payment gateway resmi (Midtrans/Xendit/dll).
- Callback/webhook pembayaran dan signature verification.
- Integrasi supplier/API top-up otomatis.
- Refund dan rekonsiliasi otomatis.
- Notifikasi email/WhatsApp.
- Voucher, promo, referral, dan loyalty.
- Dashboard analitik lanjutan.
- Automated feature tests dan CI/CD.
- Audit log dan monitoring.
- API mobile dengan Laravel Sanctum.

## 9. Business Rules
1. Hanya user terautentikasi yang dapat membuat order.
2. Produk dan nominal harus aktif saat checkout.
3. Harga order disalin ke `orders.amount`; perubahan harga katalog tidak mengubah order lama.
4. `order_code` harus unik dan tidak mudah ditebak.
5. User hanya boleh melihat order miliknya; admin dapat melihat semua.
6. Bukti pembayaran hanya dapat diunggah untuk order milik user dan sebelum pembayaran diverifikasi.
7. Admin hanya menandai `paid` setelah dana benar-benar diterima.
8. Order hanya diproses setelah pembayaran berstatus `paid`.
9. Order selesai hanya setelah layanan top-up berhasil diberikan.
10. Order yang gagal perlu prosedur penanganan/refund manual yang tercatat.
11. Harga disimpan sebagai integer rupiah.
12. Perubahan status harus divalidasi agar tidak melompati tahapan bisnis secara sembarang.

## 10. Bug / Technical Debt
Daftar pekerjaan yang perlu ditinjau sebelum production:
- Tambahkan state machine/transisi status terpusat.
- Tambahkan audit trail untuk perubahan status oleh admin.
- Tambahkan idempotency key pada pembuatan order dan webhook.
- Tambahkan rate limiting login, register, dan upload.
- Validasi MIME dan ukuran file; simpan file di private disk dan gunakan signed/authorized download.
- Tambahkan CSRF, security headers, dan pemeriksaan dependency.
- Tambahkan automated tests untuk ownership, role, harga, dan status.
- Gunakan queue untuk webhook, email, dan pemrosesan supplier.
- Tambahkan log terstruktur dan monitoring error.
- Review race condition stok/kuota jika produk kelak memiliki inventori.

## 11. Decision Log
Lihat `DECISION_LOG.md`. Keputusan utama: Laravel monolith + Blade untuk MVP; MySQL sebagai database utama; pembayaran manual sebagai placeholder; integrasi provider dipisahkan ke service adapter saat fase berikutnya.

## 12. Deployment Notes
Lihat `DEPLOYMENT.md`. Production wajib memakai HTTPS, `APP_DEBUG=false`, secret environment, database backup, storage permission yang tepat, dan queue/cron jika fitur asynchronous ditambahkan.
