# project_uas_web

#  Sistem Manajemen Barang


**Nama: Alipiani Dwi Putri**

**NIM: 312410691**

**Kelas: TI.24.A2**

**Mata Kuliah: Pemrograman Web**

**Dosen: Agung Nugroho, S.Kom., M.Kom.**

---

## Video Dokumentasi

###  Link YouTube

**[Video Demo Aplikasi]** 
```
https://youtu.be/IhNrN6Q6hcA?feature=shared

```

---

## Pengertian Project

Sistem Manajemen Barang adalah aplikasi web berbasis PHP untuk mengelola data inventori barang. Aplikasi ini dibangun menggunakan arsitektur **MVC (Model-View-Controller)** dengan fitur CRUD lengkap, sistem autentikasi berbasis role (Admin & User), pencarian, filter kategori, pagination, dan upload gambar produk.

### Fitur Utama

#### Autentikasi & Authorization
- Login dengan validasi username & password
- Session management untuk keamanan
- Role-based access control (Admin & User)
- Logout dengan clear session

####  Dashboard
- Statistik total barang dan total user
- Grafik distribusi barang per kategori
- Informasi profil user yang login
- Badge role (Admin/User)
- Timestamp login

####  Manajemen Barang
- **Create**: Form tambah barang dengan validasi (Admin only)
- **Read**: Daftar barang dengan gambar produk (All users)
- **Update**: Edit data barang dengan form terisi (Admin only)
- **Delete**: Hapus barang dengan konfirmasi (Admin only)
- Upload gambar produk (JPG, PNG, JPEG, GIF - Max 2MB)
- Preview gambar dalam modal

####  Pencarian & Filter
- Search barang by nama (real-time search)
- Filter by kategori (dropdown dinamis dari database)
- Kombinasi search + filter
- Tombol reset untuk clear semua filter

####  Pagination
- 10 data per halaman
- Navigasi Previous/Next
- Page numbers (current page ±2)
- Info total halaman dan total data
- Preserve search & filter saat pagination

####  Responsive Design
- Sidebar navigation dengan icons
- Mobile-friendly layout (hamburger menu)
- Tablet & desktop optimized
- Smooth transitions & hover effects

---


## Struktur Project
```
project_uas_web/
│
├── .htaccess                      # Apache URL rewriting rules
├── index.php                      # Application entry point
├── README.md                      # Dokumentasi project
│
├── config/
│   └── database.php               # Database configuration (Singleton pattern)
│
├── app/
│   ├── controllers/               # Controller layer (MVC)
│   │   ├── AuthController.php     # Handle login, logout, session
│   │   ├── BarangController.php   # Handle CRUD barang
│   │   └── DashboardController.php # Handle dashboard statistics
│   │
│   ├── models/                    # Model layer (Database interaction)
│   │   ├── User.php               # User model (authentication)
│   │   └── Barang.php             # Barang model (CRUD operations)
│   │
│   └── views/                     # View layer (UI templates)
│       ├── layouts/
│       │   ├── header.php         # Header with sidebar navigation
│       │   └── footer.php         # Footer with scripts
│       ├── auth/
│       │   └── login.php          # Login page
│       ├── dashboard/
│       │   └── index.php          # Dashboard main page
│       └── barang/
│           ├── index.php          # List barang with search/filter
│           ├── create.php         # Form tambah barang
│           └── edit.php           # Form edit barang
│
├── public/                        # Public assets
│   ├── css/
│   │   └── style.css              # Custom styles
│   ├── js/
│   │   └── script.js              # Custom JavaScript
│   └── images/
│       └── barang/                # Product images folder
│           ├── HP_Iphone.jpg
│           ├── Laptop_Asus.jpg
│           └── ... (36 images)
│
└── screenshots/                   # Application screenshots (documentation)
    ├── 01-login-page.png
    ├── 02-dashboard-admin.png
    ├── ... (23 screenshots)
```

### Key Files Explained

| File | Fungsi |
|------|--------|
| `.htaccess` | URL rewriting untuk clean URLs (hide .php extension) |
| `index.php` | Router utama, handle URL parsing & autoload classes |
| `config/database.php` | Koneksi database dengan PDO (Singleton pattern) |
| `AuthController.php` | Authentication logic, session management |
| `BarangController.php` | CRUD operations untuk barang |
| `User.php` | Query database untuk user authentication |
| `Barang.php` | Query database untuk CRUD barang |
| `header.php` | Sidebar navigation, user info |
| `style.css` | Custom styling, responsive breakpoints |

---

## Cara Instalasi

### Requirements

- **XAMPP** (atau LAMP/WAMP/MAMP)
  - Apache 2.4+
  - PHP 7.4+
  - MySQL 5.7+
- **Browser modern** (Chrome, Firefox, Edge)
- **Text Editor** (VS Code, Sublime Text, dll)

### Langkah Instalasi

#### **1. Clone Repository**
```bash
git clone https://github.com/Alipianidwiputri/LabWeb13.git
```

**Atau download ZIP:**
- Klik tombol "Code" → "Download ZIP"
- Extract ke folder `C:\xampp\htdocs\`
- Rename folder jadi `project_uas_web`

#### **2. Setup Database**

Project ini menggunakan database yang **sudah ada**: `latihan1`

**Struktur Tabel:**

**Tabel `users`:**
```sql
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Tabel `data_barang`:**
```sql
CREATE TABLE data_barang (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  harga_beli DECIMAL(15,2) NOT NULL,
  harga_jual DECIMAL(15,2) NOT NULL,
  stok INT NOT NULL,
  gambar VARCHAR(255),
  tanggal_input TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Sample Data:**
- 3 users (admin, alipiani, user)
- 36 barang dengan berbagai kategori
- Gambar produk sudah tersedia di `public/images/barang/`

#### **3. Konfigurasi Database** (Opsional)

Jika database Anda berbeda, edit file `config/database.php`:
```php
define('DB_HOST', 'localhost');    // Host database
define('DB_USER', 'root');         // Username MySQL
define('DB_PASS', '');             // Password MySQL
define('DB_NAME', 'latihan1');     // Nama database
```

#### **4. Enable mod_rewrite Apache**

**Windows (XAMPP):**

1. Buka file: `C:\xampp\apache\conf\httpd.conf`
2. Cari baris:
```
   #LoadModule rewrite_module modules/mod_rewrite.so
```
3. Hapus tanda `#` di depan (uncomment)
4. Cari baris:
```
   AllowOverride None
```
5. Ganti jadi:
```
   AllowOverride All
```
6. **Restart Apache** di XAMPP Control Panel

**Linux/Mac:**
```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

#### **5. Akses Aplikasi**

Buka browser, ketik:
```
http://localhost/project_uas_web
```

Otomatis redirect ke halaman login.

---

##  Login 

### Admin (Full Access)
```
Username: admin
Password: admin123
```

**Hak Akses:**
-  View Dashboard
-  View Daftar Barang
-  Create Barang
-  Edit Barang
-  Delete Barang
-  Search & Filter
-  Upload Gambar

### User (Read Only)
```
Username: alipiani
Password: password123
```

**Atau:**
```
Username: user
Password: user123
```

**Hak Akses:**
-  View Dashboard
-  View Daftar Barang
-  Search & Filter

---

## Screenshot Aplikasi

###  Authentication

#### Login Page
<img width="1919" height="955" alt="login-page" src="https://github.com/user-attachments/assets/247b9d1c-ddfe-4191-ab7e-dab6ef71222b" />

*Halaman login dengan gradient design*

#### Login admin Page
<img width="1919" height="942" alt="login-admin" src="https://github.com/user-attachments/assets/308f28a3-5019-4f30-af70-d1f3d4d79762" />


#### Login user Page
<img width="1914" height="956" alt="login-user (2)" src="https://github.com/user-attachments/assets/bdfd74d4-45c7-4384-a74a-627d8b05ec5c" />


###  Dashboard

#### Dashboard Admin
<img width="1897" height="952" alt="dashboard-admin" src="https://github.com/user-attachments/assets/fcba8172-4a7a-4977-b16e-0599260e4b0c" />

*Dashboard dengan statistik dan role Admin*

#### Dashboard User
<img width="1900" height="939" alt="Dasboard-user" src="https://github.com/user-attachments/assets/3d6721cb-64fe-4061-9dce-51f008ae29d2" />

*Dashboard dengan role User (read-only)*

### Daftar Barang

#### List Barang (Admin View)
<img width="1890" height="949" alt="daftar-barang-admin" src="https://github.com/user-attachments/assets/f478bdc9-1159-4496-911a-e5c892664d3a" />

*Daftar barang dengan tombol Edit & Hapus*

#### List Barang (User View)
<img width="1919" height="956" alt="daftar-barang-user" src="https://github.com/user-attachments/assets/540476fa-72d9-471c-aca0-d091f416f863" />

*Daftar barang tanpa akses CRUD*![Uploading daftar-barang-user.png…]()


###  Search & Filter

#### Search Barang
<img width="1899" height="956" alt="search-barang" src="https://github.com/user-attachments/assets/1f32b6be-f3c5-4ced-994b-3a62caf9cd95" />

*Pencarian barang by nama*

#### Filter Kategori

*Filter barang by kategori*<img width="1900" height="944" alt="filter-barang" src="https://github.com/user-attachments/assets/bd96adca-23db-4972-8b51-2a64a2111f17" />


#### Search + Filter Kombinasi<img width="1903" height="944" alt="search-filter-kombinasi" src="https://github.com/user-attachments/assets/f27baf75-d6ea-4138-919f-e9050191ff13" />


*Kombinasi search dan filter dengan tombol Reset*

###  CRUD Operations (Admin Only)

#### Form Tambah Barang
<img width="1911" height="947" alt="form-tambah-barang" src="https://github.com/user-attachments/assets/02800f40-f57e-41be-a4e0-5d85e95b7231" />

*Form input barang dengan upload gambar*

#### Form Tambah Barang filled
<img width="1899" height="959" alt="form-tambah-filled" src="https://github.com/user-attachments/assets/6a1f404e-b0e7-43aa-8cbc-11f97f3634bb" />


#### Form Edit Barang
<img width="1900" height="938" alt="form-edit-barang" src="https://github.com/user-attachments/assets/472b5bf9-9829-4347-9675-083009bf0fd6" />

*Form edit dengan data existing*

#### Delete Confirmation
<img width="1919" height="595" alt="delete-confirmation" src="https://github.com/user-attachments/assets/8d3cb8be-2e0f-4d3a-9443-109a1148ba27" />

*Konfirmasi sebelum hapus barang*

#### Success Message
<img width="1904" height="474" alt="success-message" src="https://github.com/user-attachments/assets/d278d7d3-fa2e-4b6d-aef8-0a9779d9b169" />

*Alert success setelah operasi berhasil*

### Responsive Mobile View

#### Mobile Login
<img width="1089" height="948" alt="mobile-login" src="https://github.com/user-attachments/assets/6285855b-accf-4a38-944f-9803ba8b19d3" />

*Login page dalam mode mobile*

#### Mobile Dashboard
<img width="1085" height="960" alt="mobile-dashboard" src="https://github.com/user-attachments/assets/0f3a31e3-c7e4-420b-9da1-d2daa0da2ecb" />

*Dashboard responsive dengan card layout*

#### Mobile Sidebar
<img width="1085" height="946" alt="mobile-sidebar-open" src="https://github.com/user-attachments/assets/024af084-c49b-4c12-8ef9-6de96b46de75" />

*Hamburger menu dan sidebar slide*



---


## Kontak

| Platform | Link |
|----------|------|
| **Email** | alifiyanidwiputri@gmail.com |
| **GitHub** | [github.com/Alipianidwiputri](https://github.com/Alipianidwiputri) |


---


