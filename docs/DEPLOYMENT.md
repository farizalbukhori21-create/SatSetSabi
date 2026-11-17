# Deployment Notes

## Local development
1. Install PHP 8.2+, Composer, MySQL, Node.js.
2. Buat Laravel 12 project dan salin overlay sesuai README.
3. Konfigurasikan `.env`.
4. Jalankan `composer install`, `npm install`, `php artisan key:generate`.
5. Jalankan `php artisan migrate --seed`, `npm run build`, `php artisan storage:link`.
6. Jalankan `php artisan serve`.

## Production checklist
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL` memakai HTTPS
- `php artisan config:cache`
- `php artisan route:cache`
- `php artisan view:cache`
- Jalankan `php artisan migrate --force`
- Jalankan `npm ci && npm run build` pada pipeline build
- Web root harus menunjuk ke folder `public/`, bukan root repository
- Pastikan `storage/` dan `bootstrap/cache/` writable oleh web process
- Gunakan secret manager/environment variables; jangan upload `.env` ke repository
- Aktifkan TLS, firewall, database backup, log rotation, dan monitoring
- Atur scheduler cron jika ada scheduled tasks
- Jalankan queue worker sebagai service supervisor jika queue digunakan
- Batasi akses file bukti pembayaran dan jangan expose file sensitif secara publik

## Rollback
Siapkan backup database dan file sebelum deployment. Migration yang destruktif harus memiliki rencana rollback/restore. Jangan mengandalkan `migrate:rollback` sebagai satu-satunya strategi pemulihan data transaksi.
