# Setup Google OAuth untuk Login Customer

## 1. Install Laravel Socialite

Jalankan perintah berikut di terminal:

```bash
composer require laravel/socialite
```

## 2. Setup Google OAuth Credentials

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang sudah ada
3. Enable Google+ API
4. Buat OAuth 2.0 Client ID:
   - Buka "Credentials" > "Create Credentials" > "OAuth client ID"
   - Application type: Web application
   - Authorized redirect URIs: `http://localhost:8000/auth/google/callback` (untuk development)
   - Untuk production, tambahkan: `https://yourdomain.com/auth/google/callback`
5. Copy Client ID dan Client Secret

## 3. Update .env File

Tambahkan konfigurasi berikut ke file `.env`:

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## 4. Run Migration

Jalankan migration untuk menambahkan kolom `role`, `google_id`, dan `avatar`:

```bash
php artisan migrate
```

## 5. Update Existing Users (Optional)

Jika ada user yang sudah ada, update role mereka:

```bash
php artisan tinker
```

Kemudian jalankan:
```php
// Set default role untuk user yang belum punya role
\App\Models\User::whereNull('role')->update(['role' => 'customer']);

// Buat user admin (ganti email dengan email admin Anda)
\App\Models\User::where('email', 'admin@gmail.com')->update(['role' => 'admin']);

// Buat user super admin (ganti email dengan email super admin Anda)
\App\Models\User::where('email', 'superadmin@example.com')->update(['role' => 'super_admin']);
```

## Catatan Penting

- **Customer** hanya bisa login dengan Google OAuth atau email/password dengan role "customer"
- **Admin** dan **Super Admin** hanya bisa login dengan email/password (tidak bisa menggunakan Google OAuth)
- Customer yang login dengan Google akan otomatis dibuat sebagai user dengan role "customer"
- Customer tidak bisa mengakses halaman backend (dashboard, categories, products, orders management)

