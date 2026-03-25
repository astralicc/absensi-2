# Setup Google OAuth Login

## Langkah-langkah Konfigurasi

### 1. Buat Project di Google Cloud Console

1. Kunjungi [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang sudah ada
3. Aktifkan **Google+ API** dan **Google OAuth2 API**

### 2. Buat OAuth 2.0 Credentials

1. Pergi ke **APIs & Services** > **Credentials**
2. Klik **Create Credentials** > **OAuth 2.0 Client ID**
3. Pilih **Web application** sebagai application type
4. Isi **Authorized redirect URIs** dengan:
   ```
   http://localhost:8000/auth/google/callback
   ```
   (Untuk production, tambahkan domain Anda)

### 3. Tambahkan ke File .env

Tambahkan baris berikut ke file `.env` Anda:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 4. Cara Kerja Login Google

1. User klik tombol "Masuk dengan Google" di halaman login
2. Diarahkan ke Google untuk autentikasi
3. Setelah berhasil, Google mengirim token ke callback URL
4. Sistem mencari user berdasarkan email Google
5. Jika user ditemukan, login berhasil
6. Jika tidak ditemukan, user harus didaftarkan terlebih dahulu oleh admin

### 5. Keamanan

- Hanya user yang sudah terdaftar di sistem yang bisa login dengan Google
- Tidak ada auto-create account untuk keamanan
- Admin harus mendaftarkan user terlebih dahulu dengan email yang sama dengan akun Google

### 6. Troubleshooting

Jika mengalami error "redirect_uri_mismatch":
- Pastikan redirect URI di Google Cloud Console sama dengan GOOGLE_REDIRECT_URI di .env
- Untuk local development, gunakan `http://localhost:8000/auth/google/callback`

Jika user tidak ditemukan:
- Pastikan email user sudah terdaftar di database
- Email di database harus sama persis dengan email Google
