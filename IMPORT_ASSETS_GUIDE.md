# PANDUAN IMPORT ASSET DARI EXCEL

## Ringkasan
Anda sekarang bisa import data asset dari Excel langsung ke dalam aplikasi Manajemen Asset dengan mudah melalui fitur Import Assets.

## Cara Menggunakan

### 1. **Download Template CSV**
- Buka halaman Assets Management
- Klik tombol "Import Assets" (tombol biru)
- Di halaman Import, klik tombol "Download Template"
- File `asset_import_template.csv` akan terunduh

### 2. **Persiapkan Data Excel Anda**
**Opsi A: Menggunakan Template yang Diunduh**
- Buka file `asset_import_template.csv` dengan Excel/Google Sheets
- Template sudah berisi:
  - Header untuk setiap kolom
  - 1 contoh baris yang sudah diisi
  - Sesuaikan dengan data asset Anda

**Opsi B: Menggunakan Data Excel Existing**
- Buka file Excel Anda
- Pastikan kolom sudah dalam urutan yang benar (lihat "Urutan Kolom" di bawah)
- Hapus header lama, ganti dengan header template

### 3. **Format Data yang Benar**

#### Urutan Kolom (PENTING!):
```
1.  Company                          (Nama Perusahaan)
2.  Asset Code *                     (Kode Asset - WAJIB diisi)
3.  Serial Number                    (Nomor Seri)
4.  Model                             (Model Perangkat)
5.  Brand                             (Merek/Brand)
6.  Type                              (Jenis: Laptop, Desktop, Printer, dll)
7.  Status                            (active, inactive, expired_soon, expired)
8.  Location                          (Lokasi: nama lokasi di sistem)
9.  Department                        (Departemen: nama departemen di sistem)
10. Person In Charge                  (PIC: Nama orang yang ber-tanggung jawab)
11. Purchase Date                     (Tanggal Beli: YYYY-MM-DD)
12. Warranty Expiration               (Tanggal Garansi Berakhir: YYYY-MM-DD)
13. Processor                         (Prosesor: Intel i7, AMD Ryzen 5, dll)
14. Storage Type                      (Jenis Storage: SSD, HDD)
15. Storage Size                      (Ukuran Storage: 512GB, 1TB, dll)
16. RAM                               (RAM: 8GB, 16GB, dll)
17. Specification Upgraded            (0 atau 1: 0=Tidak, 1=Ya)
18. Notes                             (Catatan tambahan)
19. Is Active                         (yes atau no)
```

#### Contoh Data yang Benar:
```
PT Indonesia|ASSET001|SN123456789|ThinkPad X1|Lenovo|Laptop|active|Floor 1 - Office A|IT Department|John Doe|2024-01-15|2026-01-15|Intel i7|SSD|512GB|16GB|1|Recently upgraded|yes
```

#### Format Tanggal:
- **Wajib**: YYYY-MM-DD (contoh: 2024-01-15)
- Alternatif: DD/MM/YYYY (contoh: 15/01/2024)
- Jika kosong: biarkan cell kosong (jangan diisi)

#### Status Asset:
- `active` = Aktif
- `inactive` = Tidak Aktif
- `expired_soon` = Segera Kadaluarsa
- `expired` = Kadaluarsa

#### Is Active:
- `yes` atau `1` = Aktif
- `no` atau `0` = Tidak Aktif

### 4. **Konversi ke CSV**

**Jika menggunakan Excel (.xlsx):**
1. Buka file di Excel
2. Klik File → Save As
3. Pilih Format: **CSV (Comma delimited) (.csv)**
4. Simpan dengan nama file yang mudah diingat

**Jika menggunakan Google Sheets:**
1. Buka file di Google Sheets
2. Klik File → Download → Comma-separated values (.csv)
3. File akan terunduh otomatis

**Jika menggunakan LibreOffice Calc:**
1. Buka file
2. Klik File → Save As
3. Pilih Format: CSV
4. Klik OK

### 5. **Upload File CSV**

1. Kembali ke halaman "Import Assets"
2. Drag & drop file CSV ke area upload, ATAU klik area upload dan pilih file
3. Pastikan file terdeteksi dengan benar
4. Klik tombol "Import Assets"
5. Tunggu proses import selesai

### 6. **Verifikasi Hasil Import**

Setelah import selesai:
- **Jika berhasil**: Akan muncul notifikasi "Successfully imported X assets"
- **Jika ada error**: Dibagian bawah akan menampilkan row mana yang error dan alasannya
- Periksa list assets untuk memverifikasi data yang diimport

## Validasi Data

### Field yang WAJIB Diisi:
- **Asset Code**: Tidak boleh kosong dan harus unik

### Field Auto-Match (Fuzzy Search):
Sistem akan mencari kecocokan untuk:
- **Type** (Jenis Asset): Mencari nama jenis yang mirip
- **Department** (Departemen): Mencari nama departemen yang mirip
- **Location** (Lokasi): Mencari nama lokasi yang mirip

Contoh: Jika Anda tulis "IT Dept" dan ada "IT Department" di sistem, sistem akan otomatis cocokkan.

### Field yang Opsional (Boleh Kosong):
- Semua field kecuali Asset Code

## Troubleshooting

### Error: "File tidak valid"
- Pastikan file sudah dalam format **CSV (.csv)**
- Ukuran file maksimal 10MB
- Cek encoding file adalah UTF-8

### Error: "Asset Code is required" pada Row 2
- Pastikan column 2 (Asset Code) tidak kosong
- Setiap asset harus punya kode unik

### Error: "Type not found" 
- Field Type tidak cocok dengan daftar Jenis Asset di sistem
- Buka menu Settings → Asset Types untuk melihat jenis yang tersedia
- Sesuaikan nama di Excel dengan yang di sistem

### Error: "Department not found"
- Field Department tidak cocok dengan daftar Departemen
- Buka menu Settings → Departments untuk melihat daftar
- Sesuaikan nama di Excel

### Error: "Location not found"
- Field Location tidak cocok dengan daftar Lokasi
- Buka menu Settings → Locations untuk melihat daftar
- Sesuaikan nama di Excel

## Tips & Best Practices

1. **Backup Data Lama**
   - Sebelum import, backup file Excel lama Anda
   - Jika ada error, Anda bisa cek file original

2. **Test dengan Data Kecil Dulu**
   - Import 5-10 asset terlebih dahulu
   - Verifikasi hasilnya
   - Jika berhasil, naikkan jumlah data

3. **Validasi Sebelum Import**
   - Pastikan tidak ada duplikat Asset Code
   - Periksa format tanggal konsisten
   - Pastikan nama Type/Department/Location valid

4. **Gunakan Fuzzy Matching**
   - Sistem cukup cerdas mencocokkan nama yang sedikit berbeda
   - Contoh: "IT" akan ketemu "IT Department"
   - "Office A" akan ketemu "Floor 1 - Office A"

5. **Kolom Optional**
   - Tidak perlu isi semua kolom
   - Isi hanya yang relevan, sisanya biarkan kosong
   - System akan handle NULL values dengan baik

## Contoh File CSV Lengkap

```csv
Company,Asset Code,Serial Number,Model,Brand,Type,Status,Location,Department,Person In Charge,Purchase Date,Warranty Expiration,Processor,Storage Type,Storage Size,RAM,Specification Upgraded,Notes,Is Active
PT Tech Indonesia,ASSET001,SN123456789,ThinkPad X1 Carbon,Lenovo,Laptop,active,Floor 1 - Office A,IT Department,John Doe,2024-01-15,2026-01-15,Intel Core i7,SSD,512GB,16GB,1,Recently upgraded to SSD,yes
PT Tech Indonesia,ASSET002,SN987654321,HP Pavilion,HP,Laptop,active,Floor 2,Administration,Jane Smith,2024-02-20,2026-02-20,Intel Core i5,SSD,256GB,8GB,0,Office laptop,yes
PT Tech Indonesia,DESKTOP001,SN111222333,Dell Optiplex,Dell,Desktop,active,Floor 1,IT Department,John Doe,2023-06-10,2025-06-10,Intel Core i9,SSD,1TB,32GB,1,High performance server,yes
```

## Support

Jika ada masalah atau pertanyaan:
1. Cek dokumentasi ini kembali
2. Buka halaman Import Assets untuk melihat instruksi
3. Hubungi IT Support dengan file CSV yang bermasalah

---
**Versi Dokumentasi**: 1.0  
**Terakhir Diperbarui**: Februari 2026
