# Dokumentasi Form Actions di Views

Berikut adalah daftar lengkap semua form dengan action di seluruh file view:

## 1. AUTH (Authentication)

### `/login`

-   **File**: `resources/views/auth/login.blade.php`
-   **Baris**: 139
-   **Method**: POST
-   **Deskripsi**: Form login

### `/register`

-   **File**: `resources/views/auth/register.blade.php`
-   **Baris**: 129
-   **Method**: POST
-   **Deskripsi**: Form registrasi

---

## 2. LOGOUT

### `/logout` (POST)

Form logout muncul di banyak halaman:

#### Dosen:

1. `resources/views/dosen/dashboard.blade.php` - Baris 60, 121
2. `resources/views/dosen/profil.blade.php` - Baris 95, 140
3. `resources/views/dosen/mahasiswas/index.blade.php` - Baris 59, 104
4. `resources/views/dosen/mahasiswas/create.blade.php` - Baris 61, 106
5. `resources/views/dosen/mahasiswas/edit.blade.php` - Baris 61, 106
6. `resources/views/dosen/mahasiswas/password.blade.php` - Baris 61, 106
7. `resources/views/dosen/matakuliahs/index.blade.php` - Baris 61, 106
8. `resources/views/dosen/matakuliahs/create.blade.php` - Baris 61, 106
9. `resources/views/dosen/matakuliahs/edit.blade.php` - Baris 61, 106
10. `resources/views/dosen/komponen-penilaian/index.blade.php` - Baris 61, 106
11. `resources/views/dosen/komponen-penilaian/edit.blade.php` - Baris 61, 106
12. `resources/views/dosen/komponen-penilaian/atur.blade.php` - Baris 61, 106
13. `resources/views/dosen/nilai-mahasiswa/index.blade.php` - Baris 61, 106
14. `resources/views/dosen/nilai_mahasiswas/index.blade.php` - Baris 61, 106
15. `resources/views/dosen/laporan/index.blade.php` - Baris 57, 102

#### Mahasiswa:

16. `resources/views/mahasiswa/dashboard.blade.php` - Baris 66, 110
17. `resources/views/mahasiswa/profil.blade.php` - Baris 165, 208
18. `resources/views/mahasiswa/nilai-akademik.blade.php` - Baris 68, 111
19. `resources/views/mahasiswa/khs-transkrip.blade.php` - Baris 68, 111

---

## 3. DOSEN - PROFIL

### `/dosen/profil` (POST)

-   **File**: `resources/views/dosen/profil.blade.php`
-   **Baris**: 236, 298
-   **Method**: POST
-   **Enctype**: multipart/form-data
-   **Deskripsi**:
    -   Baris 236: Form upload foto profil (hidden)
    -   Baris 298: Form edit profil

---

## 4. DOSEN - MAHASISWA

### `/dosen/mahasiswas` (POST)

-   **File**: `resources/views/dosen/mahasiswas/create.blade.php`
-   **Baris**: 166
-   **Method**: POST
-   **Deskripsi**: Form create/tambah mahasiswa

### `/dosen/mahasiswas/1` (POST)

-   **File**: `resources/views/dosen/mahasiswas/edit.blade.php`
-   **Baris**: 168
-   **Method**: POST
-   **Deskripsi**: Form edit/update mahasiswa

### `/dosen/mahasiswas/1/password` (POST)

-   **File**: `resources/views/dosen/mahasiswas/password.blade.php`
-   **Baris**: 184
-   **Method**: POST
-   **Deskripsi**: Form ubah password mahasiswa

---

## 5. DOSEN - MATA KULIAH

### `/dosen/matakuliahs` (POST)

-   **File**: `resources/views/dosen/matakuliahs/create.blade.php`
-   **Baris**: 170
-   **Method**: POST
-   **Deskripsi**: Form create/tambah mata kuliah

### `/dosen/matakuliahs/1` (POST)

-   **File**: `resources/views/dosen/matakuliahs/edit.blade.php`
-   **Baris**: 168
-   **Method**: POST
-   **Deskripsi**: Form edit/update mata kuliah

### `/dosen/matakuliahs` (GET)

-   **File**: `resources/views/dosen/matakuliahs/index.blade.php`
-   **Baris**: 180
-   **Method**: GET
-   **Deskripsi**: Form search/filter mata kuliah

---

## 6. DOSEN - KOMPONEN PENILAIAN

### `/dosen/komponen-penilaian` (POST)

-   **File**: `resources/views/dosen/komponen-penilaian/atur.blade.php`
-   **Baris**: 190
-   **Method**: POST
-   **Deskripsi**: Form atur komponen penilaian

### `/dosen/komponen-penilaian/1` (POST)

-   **File**: `resources/views/dosen/komponen-penilaian/edit.blade.php`
-   **Baris**: 190
-   **Method**: POST
-   **Deskripsi**: Form edit komponen penilaian

### `/dosen/komponen-penilaian` (GET)

-   **File**: `resources/views/dosen/komponen-penilaian/index.blade.php`
-   **Baris**: 208
-   **Method**: GET
-   **Deskripsi**: Form search/filter komponen penilaian

---

## 7. DOSEN - NILAI MAHASISWA

### `/dosen/nilai-mahasiswa` (POST)

-   **File**: `resources/views/dosen/nilai_mahasiswas/index.blade.php`
-   **Baris**: 197
-   **Method**: POST
-   **Deskripsi**: Form input/simpan nilai mahasiswa

### `/dosen/nilai-mahasiswa` (GET)

-   **File**: `resources/views/dosen/nilai-mahasiswa/index.blade.php`
-   **Baris**: 208
-   **Method**: GET
-   **Deskripsi**: Form search/filter nilai mahasiswa

---

## 8. DOSEN - LAPORAN

### `/dosen/laporan-nilai` (GET)

-   **File**: `resources/views/dosen/laporan/index.blade.php`
-   **Baris**: 157
-   **Method**: GET
-   **Deskripsi**: Form filter laporan nilai

---

## 9. MAHASISWA - PROFIL

### `/mahasiswa/profil` (POST)

-   **File**: `resources/views/mahasiswa/profil.blade.php`
-   **Baris**: 306, 326, 337, 408
-   **Method**: POST
-   **Enctype**: multipart/form-data (baris 326, 337, 408)
-   **Deskripsi**:
    -   Baris 306: Form hapus foto profil
    -   Baris 326: Form upload foto (hidden, view mode)
    -   Baris 337: Form upload foto (hidden, empty view)
    -   Baris 408: Form edit profil

### `/mahasiswa/profil/foto` (POST)

-   **File**: `resources/views/mahasiswa/profil.blade.php`
-   **Baris**: 306
-   **Method**: POST
-   **Deskripsi**: Form hapus foto profil

---

## 10. MAHASISWA - NILAI AKADEMIK

### `/mahasiswa/nilai` (GET)

-   **File**: `resources/views/mahasiswa/nilai-akademik.blade.php`
-   **Baris**: 170
-   **Method**: GET
-   **Deskripsi**: Form filter nilai akademik

---

## RINGKASAN

### Total Form Actions:

-   **POST**: 20 form
-   **GET**: 4 form
-   **Total**: 24 form action unik (tidak termasuk logout yang duplikat)

### Kategori:

1. **Auth**: 2 form (login, register)
2. **Logout**: 19 file (setiap halaman memiliki 2 form logout)
3. **Dosen - Profil**: 2 form
4. **Dosen - Mahasiswa**: 3 form
5. **Dosen - Mata Kuliah**: 3 form
6. **Dosen - Komponen Penilaian**: 3 form
7. **Dosen - Nilai Mahasiswa**: 2 form
8. **Dosen - Laporan**: 1 form
9. **Mahasiswa - Profil**: 4 form
10. **Mahasiswa - Nilai Akademik**: 1 form

---

**Catatan**: Form logout muncul di setiap halaman (navbar dan sidebar), sehingga total form logout adalah 38 form (19 file × 2 form per file).





