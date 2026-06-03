# Dokumentasi AJAX Implementation

## Deskripsi

Fitur AJAX telah diimplementasikan untuk memungkinkan operasi CRUD (Create, Read, Update, Delete) pada artikel tanpa perlu reload halaman.

## File-File yang Dibuat/Dimodifikasi

### 1. Controller: `app/Controllers/Ajax.php`

Menghandle semua request AJAX dengan methods:

- `index()` - Menampilkan halaman AJAX
- `getData()` - Mengambil semua data artikel
- `getDetail($id)` - Mengambil detail artikel tertentu
- `add()` - Menambah artikel baru
- `update($id)` - Mengubah artikel
- `delete($id)` - Menghapus artikel

### 2. View: `app/Views/ajax/index.php`

View utama yang menampilkan:

- Form untuk tambah/edit artikel
- Tabel daftar artikel
- Script jQuery untuk AJAX requests

### 3. Routes: `app/Config/Routes.php`

Route grup untuk AJAX:

```
/ajax/ - Menampilkan halaman AJAX
/ajax/getData - GET semua artikel
/ajax/getDetail/{id} - GET detail artikel
/ajax/add - POST tambah artikel
/ajax/update/{id} - POST update artikel
/ajax/delete/{id} - DELETE artikel
```

### 4. Template: `app/Views/template/header.php` dan `footer.php`

Ditambahkan Bootstrap 5 dan FontAwesome untuk styling yang lebih baik

## Cara Menggunakan

### Mengakses Halaman AJAX

1. Buka URL: `http://localhost/ci4/ajax/`
2. Akan menampilkan halaman dengan tabel artikel dan form

### Menambah Artikel

1. Isi form dengan judul, isi, penulis, dan status
2. Klik tombol "Simpan"
3. Data akan tersimpan dan tabel akan refresh otomatis

### Edit Artikel

1. Klik tombol "Edit" pada artikel yang ingin diubah
2. Form akan terisi dengan data artikel
3. Ubah data sesuai kebutuhan
4. Klik tombol "Update"
5. Data akan diperbarui dan tabel akan refresh

### Hapus Artikel

1. Klik tombol "Hapus" pada artikel yang ingin dihapus
2. Konfirmasi penghapusan
3. Artikel akan dihapus dan tabel akan refresh

## Fitur-Fitur

✓ Form validasi real-time dengan pesan error  
✓ Loading indicator saat fetch data  
✓ Auto-refresh table setelah operasi  
✓ Konfirmasi sebelum menghapus  
✓ Smooth scroll ke form saat edit  
✓ Status badge (Publish/Draft)  
✓ Responsive design dengan Bootstrap 5  
✓ FontAwesome icons

## AJAX Requests

### 1. Load Data (GET)

```javascript
$.ajax({
  url: "<?= base_url('ajax/getData') ?>",
  type: "GET",
  dataType: "json",
  // ...
});
```

### 2. Tambah Data (POST)

```javascript
$.ajax({
  url: "<?= base_url('ajax/add') ?>",
  type: "POST",
  data: formData,
  dataType: "json",
  // ...
});
```

### 3. Edit Data (POST)

```javascript
$.ajax({
  url: "<?= base_url('ajax/update/' + id) ?>",
  type: "POST",
  data: formData,
  dataType: "json",
  // ...
});
```

### 4. Hapus Data (DELETE)

```javascript
$.ajax({
  url: "<?= base_url('ajax/delete/' + id) ?>",
  type: "DELETE",
  dataType: "json",
  // ...
});
```

## Model yang Digunakan

- `ArtikelModel` - Model untuk tabel articles

### Fields Database

- id (Primary Key)
- judul
- isi
- gambar (optional)
- status (0 = Draft, 1 = Publish)
- slug
- author
- created_at
- updated_at

## Teknologi yang Digunakan

- CodeIgniter 4
- jQuery 3.6.0
- Bootstrap 5
- FontAwesome 6
- JSON untuk data exchange

## Error Handling

- Validasi data di server-side
- Error messages ditampilkan ke user
- Console log untuk debugging
- HTTP status codes (200, 400, 404)

## Notes

- Semua request menggunakan JSON format
- CSRF protection dapat diaktifkan jika diperlukan
- Routes dapat dikustomisasi sesuai kebutuhan
- View dapat disesuaikan dengan design project
