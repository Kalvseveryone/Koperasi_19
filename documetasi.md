# Dokumentasi Sistem Koperasi

## 📋 Daftar Isi
1. [Overview Sistem](#overview-sistem)
2. [Arsitektur Sistem](#arsitektur-sistem)
3. [Database Design](#database-design)
4. [API Documentation](#api-documentation)
5. [Authentication & Authorization](#authentication--authorization)
6. [User Roles & Permissions](#user-roles--permissions)
7. [Implementation Guide](#implementation-guide)
8. [Deployment Guide](#deployment-guide)
9. [Troubleshooting](#troubleshooting)

---

## 🏗️ Overview Sistem

### Deskripsi
Sistem Koperasi adalah aplikasi web berbasis Laravel yang mengelola operasional koperasi termasuk manajemen anggota, pinjaman, simpanan, dan pembayaran. Sistem ini mendukung tiga jenis pengguna: Admin, Kolektor, dan Anggota.

### Fitur Utama
- **Manajemen Anggota**: Pendaftaran, update, dan monitoring anggota koperasi
- **Sistem Pinjaman**: Pengajuan, approval, dan tracking pinjaman
- **Sistem Simpanan**: Pencatatan dan monitoring simpanan anggota
- **Sistem Pembayaran**: Pencatatan pembayaran angsuran oleh kolektor
- **Laporan Keuangan**: Generate laporan keuangan dan export Excel
- **Notifikasi**: Sistem notifikasi untuk update status pembayaran
- **API Mobile**: Endpoint API untuk aplikasi mobile

### Teknologi yang Digunakan
- **Backend**: Laravel 10.x
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Frontend**: Blade Templates + Bootstrap
- **File Storage**: Laravel Storage
- **Export**: Laravel Excel

---

## 🏛️ Arsitektur Sistem

### Struktur Folder
```
sistemkoperasinew/
├── app/
│   ├── Http/Controllers/     # Controller untuk web & API
│   ├── Models/              # Eloquent Models
│   ├── Notifications/       # Notification Classes
│   └── Exports/            # Excel Export Classes
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/views/        # Blade templates
├── routes/                 # Route definitions
│   ├── web.php            # Web routes
│   ├── api.php            # API routes
│   └── kolektor.php       # Kolektor specific routes
└── public/                # Public assets
```

### Flow Sistem
1. **Login Flow**: User login → Role detection → Redirect ke dashboard sesuai role
2. **Pinjaman Flow**: Anggota ajukan → Admin review → Approval/Rejection
3. **Pembayaran Flow**: Kolektor input → Admin verify → Update saldo anggota
4. **Simpanan Flow**: Admin input → Update saldo → Generate transaksi

---

## 🗄️ Database Design

### Entity Relationship Diagram

#### Tabel Utama
1. **users** - Admin users
2. **anggotas** - Data anggota koperasi
3. **kolektors** - Data kolektor
4. **pinjaman** - Data pinjaman anggota
5. **transaksis** - Transaksi keuangan
6. **simpanan_transactions** - Transaksi simpanan
7. **payment_submissions** - Pengajuan pembayaran
8. **notifications** - Notifikasi sistem

### Struktur Tabel

#### Tabel `anggotas`
```sql
- id (Primary Key)
- nama (VARCHAR)
- nik (VARCHAR, Unique)
- no_telepon (VARCHAR)
- email (VARCHAR, Unique)
- password (VARCHAR)
- alamat (TEXT)
- saldo_simpanan (DECIMAL)
- kolektor_id (Foreign Key)
- total_pinjaman (DECIMAL)
- total_denda (DECIMAL)
- created_at, updated_at
```

#### Tabel `pinjaman`
```sql
- id (Primary Key)
- anggota_id (Foreign Key)
- jumlah (DECIMAL)
- jangka_waktu (INTEGER)
- tujuan (VARCHAR)
- status (ENUM: pending, aktif, lunas, ditolak)
- tanggal_pinjam (DATE)
- tanggal_lunas (DATE, Nullable)
- denda (DECIMAL)
- catatan (TEXT)
- created_at, updated_at
```

#### Tabel `payment_submissions`
```sql
- id (Primary Key)
- anggota_id (Foreign Key)
- kolektor_id (Foreign Key)
- jumlah_pembayaran (DECIMAL)
- tanggal_pembayaran (DATE)
- metode_pembayaran (ENUM: tunai, transfer)
- bukti_pembayaran (VARCHAR)
- status (ENUM: pending, approved, rejected)
- bulan_pembayaran (INTEGER)
- tahun_pembayaran (INTEGER)
- created_at, updated_at
```

---

## 📡 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication
Semua endpoint (kecuali login) memerlukan token Bearer di header:
```
Authorization: Bearer {token}
```

### 1. Authentication Endpoints

#### POST `/api/auth/login`
**Description**: Login user (Admin/Kolektor/Anggota)

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response Success:**
```json
{
  "success": true,
  "message": "Login berhasil",
  "role": "admin|kolektor|anggota",
  "user": {
    "id": 1,
    "nama": "User Name",
    "email": "user@example.com"
  },
  "token": "1|abc123def456..."
}
```

**Response Error:**
```json
{
  "success": false,
  "message": "Email atau password salah"
}
```

#### POST `/api/auth/logout`
**Description**: Logout user

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

#### GET `/api/auth/user`
**Description**: Get current user data

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "user": {
    "id": 1,
    "nama": "User Name",
    "email": "user@example.com",
    "role": "admin"
  }
}
```

### 2. Anggota Endpoints

#### GET `/api/anggota/{id}`
**Description**: Get anggota detail

**Parameters:**
- `id` (path) - Anggota ID

**Response:**
```json
{
  "id": 1,
  "nama": "Budi Santoso",
  "nik": "123456789",
  "no_telepon": "08123456789",
  "email": "budi@email.com",
  "alamat": "Jl. Merdeka No. 123",
  "saldo_simpanan": 1000000,
  "total_pinjaman": 5000000,
  "total_denda": 0
}
```

#### POST `/api/anggota`
**Description**: Create new anggota

**Request Body:**
```json
{
  "nama": "Budi Santoso",
  "nik": "123456789",
  "no_telepon": "08123456789",
  "email": "budi@email.com",
  "password": "password123",
  "alamat": "Jl. Merdeka No. 123",
  "saldo_simpanan": 0
}
```

**Response:**
```json
{
  "message": "Anggota berhasil ditambahkan"
}
```

#### PUT `/api/anggota/{id}`
**Description**: Update anggota data

**Parameters:**
- `id` (path) - Anggota ID

**Request Body:** Same as POST

**Response:**
```json
{
  "message": "Anggota berhasil diperbarui"
}
```

#### DELETE `/api/anggota/{id}`
**Description**: Delete anggota (Admin only)

**Parameters:**
- `id` (path) - Anggota ID

**Response:**
```json
{
  "message": "Anggota berhasil dihapus"
}
```

#### GET `/api/anggota/{id}/simpanan`
**Description**: Get anggota simpanan balance

**Parameters:**
- `id` (path) - Anggota ID

**Response:**
```json
{
  "saldo_simpanan": 1000000
}
```

#### GET `/api/anggota/history`
**Description**: Get anggota transaction history

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "anggota_id": 1,
      "jumlah": 500000,
      "jenis_transaksi": "simpanan",
      "status": "sukses",
      "tanggal_transaksi": "2024-01-15T10:30:00Z",
      "keterangan": "Setoran simpanan"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 20,
    "total": 100
  }
}
```

### 3. Kolektor Endpoints

#### GET `/api/kolektor/{id}`
**Description**: Get kolektor detail

**Parameters:**
- `id` (path) - Kolektor ID

**Response:**
```json
{
  "id": 1,
  "nama": "Kolektor A",
  "email": "kolektor@email.com",
  "anggota": [
    {
      "id": 1,
      "nama": "Budi Santoso"
    }
  ]
}
```

#### POST `/api/kolektor`
**Description**: Create new kolektor

**Request Body:**
```json
{
  "nama": "Kolektor Baru",
  "email": "kolektor@email.com",
  "password": "password123",
  "anggota_id": 1
}
```

**Response:**
```json
{
  "message": "Kolektor berhasil ditambahkan",
  "kolektor": {...}
}
```

#### POST `/api/kolektor/payment`
**Description**: Record payment by kolektor

**Request Body:**
```json
{
  "anggota_id": 1,
  "jumlah_pembayaran": 500000,
  "tanggal_pembayaran": "2024-01-15",
  "bukti_pembayaran": "file_upload"
}
```

**Response:**
```json
{
  "message": "Pembayaran berhasil diajukan",
  "payment": {
    "id": 1,
    "anggota_id": 1,
    "kolektor_id": 1,
    "jumlah_pembayaran": 500000,
    "status": "pending"
  }
}
```

#### POST `/api/kolektor/payment/submit`
**Description**: Submit payment for verification

**Request Body:**
```json
{
  "anggota_id": 1,
  "jumlah_pembayaran": 500000,
  "metode_pembayaran": "tunai",
  "bukti_pembayaran": "file_upload",
  "tanggal_pembayaran": "2024-01-15",
  "bulan_pembayaran": 1,
  "tahun_pembayaran": 2024
}
```

**Response:**
```json
{
  "message": "Pengajuan pembayaran berhasil disubmit",
  "submission": {...}
}
```

#### GET `/api/kolektor/payment/history/{anggotaId}`
**Description**: Get payment history for specific anggota

**Parameters:**
- `anggotaId` (path) - Anggota ID

**Response:**
```json
{
  "payments": [
    {
      "id": 1,
      "anggota_id": 1,
      "kolektor_id": 1,
      "jumlah_pembayaran": 500000,
      "status": "approved",
      "tanggal_pembayaran": "2024-01-15",
      "created_at": "2024-01-15T10:30:00Z"
    }
  ]
}
```

#### GET `/api/kolektor/payment/form/{anggotaId}`
**Description**: Get payment form data for anggota

**Parameters:**
- `anggotaId` (path) - Anggota ID

**Response:**
```json
{
  "anggota": {
    "id": 1,
    "nama": "Budi Santoso",
    "saldo_simpanan": 1000000
  },
  "pinjaman": [
    {
      "id": 1,
      "jumlah": 5000000,
      "status": "aktif"
    }
  ]
}
```

### 4. Pinjaman Endpoints

#### GET `/api/pinjaman`
**Description**: Get pinjaman list (for anggota: their own pinjaman)

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Pinjaman data retrieved successfully",
  "data": [
    {
      "id": 1,
      "anggota_id": 1,
      "jumlah": 1000000,
      "jangka_waktu": 12,
      "tujuan": "Modal usaha",
      "status": "aktif",
      "tanggal_pinjam": "2024-01-15T10:30:00Z",
      "denda": 0,
      "anggota": {
        "id": 1,
        "nama": "Budi Santoso"
      }
    }
  ]
}
```

#### GET `/api/pinjaman/{id}`
**Description**: Get specific pinjaman detail

**Parameters:**
- `id` (path) - Pinjaman ID

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Pinjaman detail retrieved successfully",
  "data": {
    "id": 1,
    "anggota_id": 1,
    "jumlah": 1000000,
    "jangka_waktu": 12,
    "tujuan": "Modal usaha",
    "status": "aktif",
    "tanggal_pinjam": "2024-01-15T10:30:00Z",
    "denda": 0,
    "catatan": null
  }
}
```

#### POST `/api/pinjaman`
**Description**: Create new pinjaman application

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "jumlah": 1000000,
  "jangka_waktu": 12,
  "tujuan": "Modal usaha"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Pinjaman application submitted successfully",
  "data": {
    "id": 1,
    "anggota_id": 1,
    "jumlah": 1000000,
    "jangka_waktu": 12,
    "tujuan": "Modal usaha",
    "status": "pending",
    "tanggal_pinjam": "2024-01-15T10:30:00Z"
  }
}
```

### 5. Laporan Keuangan Endpoints

#### GET `/api/laporan-keuangan`
**Description**: Generate financial report

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "total_simpanan": 50000000,
  "total_pinjaman": 30000000,
  "total_kolektor": 5,
  "total_transaksi": 150,
  "periode": "2024-01-01 to 2024-12-31"
}
```

#### GET `/api/laporan-keuangan/export`
**Description**: Export financial report to Excel

**Headers:**
```
Authorization: Bearer {token}
```

**Response:** Excel file download

### 6. Admin Panel Endpoints

#### GET `/api/admin/dashboard`
**Description**: Get admin dashboard data

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "total_anggota": 100,
  "total_kolektor": 5,
  "total_simpanan": 50000000,
  "total_pinjaman": 30000000,
  "total_transaksi": 150
}
```

#### GET `/api/admin/payments/pending`
**Description**: Get pending payment submissions

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "payments": [
    {
      "id": 1,
      "anggota": {
        "id": 1,
        "nama": "Budi Santoso"
      },
      "kolektor": {
        "id": 1,
        "nama": "Kolektor A"
      },
      "jumlah_pembayaran": 500000,
      "tanggal_pembayaran": "2024-01-15",
      "status": "pending",
      "created_at": "2024-01-15T10:30:00Z"
    }
  ]
}
```

#### POST `/api/admin/payments/{id}/verify`
**Description**: Verify payment submission

**Parameters:**
- `id` (path) - Payment submission ID

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "status": "approved"
}
```

**Response:**
```json
{
  "message": "Verifikasi pembayaran berhasil"
}
```

#### GET `/api/admin/payments/history`
**Description**: Get payment history

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "payments": [
    {
      "id": 1,
      "anggota": {
        "id": 1,
        "nama": "Budi Santoso"
      },
      "kolektor": {
        "id": 1,
        "nama": "Kolektor A"
      },
      "jumlah_pembayaran": 500000,
      "status": "approved",
      "tanggal_pembayaran": "2024-01-15",
      "created_at": "2024-01-15T10:30:00Z"
    }
  ]
}
```

---

## 🔐 Authentication & Authorization

### Laravel Sanctum
Sistem menggunakan Laravel Sanctum untuk API authentication dengan token-based authentication.

### Token Generation
```php
// Generate token for user
$token = $user->createToken('token_name', ['role:admin'])->plainTextToken;
```

### Token Validation
```php
// Middleware untuk validasi token
Route::middleware('auth:sanctum')->group(function () {
    // Protected routes
});
```

### Role-based Authorization
```php
// Middleware untuk role-based access
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Admin only routes
});
```

---

## 👥 User Roles & Permissions

### 1. Admin
**Permissions:**
- Full access to all features
- Manage anggota, kolektor, pinjaman
- Verify payment submissions
- Generate reports
- Export data

**Accessible Endpoints:**
- All admin panel endpoints
- CRUD operations for all entities
- Payment verification
- Report generation

### 2. Kolektor
**Permissions:**
- View assigned anggota
- Record payments
- Submit payment for verification
- View payment history

**Accessible Endpoints:**
- `/api/kolektor/payment/*`
- `/api/anggota/{id}` (assigned anggota only)
- Payment submission and history

### 3. Anggota
**Permissions:**
- View own profile and data
- Apply for pinjaman
- View transaction history
- Check simpanan balance