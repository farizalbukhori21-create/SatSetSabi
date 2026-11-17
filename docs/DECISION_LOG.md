# Decision Log

| ID | Keputusan | Alasan | Konsekuensi |
|---|---|---|---|
| ADR-001 | Laravel 12 monolith | Satu codebase lebih mudah dikembangkan dan dioperasikan untuk MVP | Frontend dan backend berada dalam satu aplikasi |
| ADR-002 | Blade + Tailwind | Cepat untuk UI server-rendered, minim kompleksitas | SPA interaktif dapat dipertimbangkan kemudian |
| ADR-003 | MySQL 8 | Relasional, umum di hosting Laravel, cocok untuk transaksi | Perlu backup dan indexing |
| ADR-004 | Harga integer rupiah | Menghindari error floating-point | Format rupiah dilakukan pada presentation layer |
| ADR-005 | Pembayaran manual pada MVP | Tidak mengarang integrasi gateway tanpa kredensial merchant | Admin wajib verifikasi pembayaran |
| ADR-006 | Supplier top-up belum otomatis | API provider dan kontrak belum ditentukan | Admin memproses pesanan secara manual |
| ADR-007 | Role sederhana `admin` dan `user` | Memadai untuk MVP | Permission granular dapat memakai package/Policy di fase berikutnya |
| ADR-008 | Harga disnapshot ke order | Histori transaksi harus konsisten walau harga berubah | Order lama tetap menyimpan harga saat dibuat |

## Perubahan keputusan
Setiap perubahan arsitektur, database, integrasi pembayaran, atau alur status harus ditambahkan sebagai ADR baru beserta tanggal, konteks, opsi, dan konsekuensinya.
