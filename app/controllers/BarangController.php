<?php
/**
 * Barang Controller - Handle CRUD operations
 */

class BarangController {
    private $barangModel;
    
    public function __construct() {
        // PENTING: Cek login dulu
        AuthController::checkLogin();
        
        $this->barangModel = new Barang();
    }
    
    /**
     * Show list of barang
     */
    public function index() {
        // Double check login
        AuthController::checkLogin();
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
        $limit = 10;
        
        $barang = $this->barangModel->getAllBarang($page, $limit, $search, $kategori);
        $totalBarang = $this->barangModel->countBarang($search, $kategori);
        $totalPages = ceil($totalBarang / $limit);
        
        $kategoriList = $this->barangModel->getAllKategori();
        
        $pageTitle = 'Daftar Barang';
        
        require_once BASE_PATH . '/app/views/layouts/header.php';
        require_once BASE_PATH . '/app/views/barang/index.php';
        require_once BASE_PATH . '/app/views/layouts/footer.php';
    }
    
    /**
     * Show create form
     */
    public function create() {
        AuthController::checkAdmin();
        
        $kategoriList = $this->barangModel->getAllKategori();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $kategori = trim($_POST['kategori'] ?? '');
            $harga_beli = (float)($_POST['harga_beli'] ?? 0);
            $harga_jual = (float)($_POST['harga_jual'] ?? 0);
            $stok = (int)($_POST['stok'] ?? 0);
            $gambar = trim($_POST['gambar'] ?? '');
            
            // Handle file upload
            if (isset($_FILES['gambar_file']) && $_FILES['gambar_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/images/barang/';
                
                // Create directory if not exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = $_FILES['gambar_file']['name'];
                $fileTmpName = $_FILES['gambar_file']['tmp_name'];
                $fileSize = $_FILES['gambar_file']['size'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // Allowed extensions
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array($fileExt, $allowedExts) && $fileSize <= 2097152) { // 2MB
                    // Generate unique filename
                    $newFileName = uniqid() . '_' . $fileName;
                    $uploadPath = $uploadDir . $newFileName;
                    
                    if (move_uploaded_file($fileTmpName, $uploadPath)) {
                        $gambar = $newFileName;
                    }
                } else {
                    $errors[] = "Format gambar tidak valid atau ukuran terlalu besar!";
                }
            }
            
            $errors = [];
            if (empty($nama)) $errors[] = "Nama barang harus diisi!";
            if (empty($kategori)) $errors[] = "Kategori harus diisi!";
            if ($harga_beli <= 0) $errors[] = "Harga beli harus lebih dari 0!";
            if ($harga_jual <= 0) $errors[] = "Harga jual harus lebih dari 0!";
            if ($stok < 0) $errors[] = "Stok tidak boleh negatif!";
            
            if (empty($errors)) {
                if ($this->barangModel->createBarang($nama, $kategori, $harga_beli, $harga_jual, $stok, $gambar)) {
                    $_SESSION['success'] = "Barang berhasil ditambahkan!";
                    header('Location: ' . BASE_URL . '/barang');
                    exit;
                } else {
                    $errors[] = "Gagal menambahkan barang!";
                }
            }
        }
        
        $pageTitle = 'Tambah Barang';
        
        require_once BASE_PATH . '/app/views/layouts/header.php';
        require_once BASE_PATH . '/app/views/barang/create.php';
        require_once BASE_PATH . '/app/views/layouts/footer.php';
    }
    
    /**
     * Show edit form
     */
    public function edit($id = null) {
        AuthController::checkAdmin();
        
        if (!$id) {
            header('Location: ' . BASE_URL . '/barang');
            exit;
        }
        
        $barang = $this->barangModel->getBarangById($id);
        
        if (!$barang) {
            $_SESSION['error'] = "Barang tidak ditemukan!";
            header('Location: ' . BASE_URL . '/barang');
            exit;
        }
        
        $kategoriList = $this->barangModel->getAllKategori();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $kategori = trim($_POST['kategori'] ?? '');
            $harga_beli = (float)($_POST['harga_beli'] ?? 0);
            $harga_jual = (float)($_POST['harga_jual'] ?? 0);
            $stok = (int)($_POST['stok'] ?? 0);
            $gambar = trim($_POST['gambar'] ?? $barang['gambar']);
            
            // Handle file upload
            if (isset($_FILES['gambar_file']) && $_FILES['gambar_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/public/images/barang/';
                
                // Create directory if not exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = $_FILES['gambar_file']['name'];
                $fileTmpName = $_FILES['gambar_file']['tmp_name'];
                $fileSize = $_FILES['gambar_file']['size'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // Allowed extensions
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array($fileExt, $allowedExts) && $fileSize <= 2097152) { // 2MB
                    // Delete old image if exists
                    if (!empty($barang['gambar'])) {
                        $oldImagePath = $uploadDir . $barang['gambar'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    
                    // Generate unique filename
                    $newFileName = uniqid() . '_' . $fileName;
                    $uploadPath = $uploadDir . $newFileName;
                    
                    if (move_uploaded_file($fileTmpName, $uploadPath)) {
                        $gambar = $newFileName;
                    }
                } else {
                    $errors[] = "Format gambar tidak valid atau ukuran terlalu besar!";
                }
            }
            
            $errors = [];
            if (empty($nama)) $errors[] = "Nama barang harus diisi!";
            if (empty($kategori)) $errors[] = "Kategori harus diisi!";
            if ($harga_beli <= 0) $errors[] = "Harga beli harus lebih dari 0!";
            if ($harga_jual <= 0) $errors[] = "Harga jual harus lebih dari 0!";
            if ($stok < 0) $errors[] = "Stok tidak boleh negatif!";
            
            if (empty($errors)) {
                if ($this->barangModel->updateBarang($id, $nama, $kategori, $harga_beli, $harga_jual, $stok, $gambar)) {
                    $_SESSION['success'] = "Barang berhasil diupdate!";
                    header('Location: ' . BASE_URL . '/barang');
                    exit;
                } else {
                    $errors[] = "Gagal mengupdate barang!";
                }
            }
        }
        
        $pageTitle = 'Edit Barang';
        
        require_once BASE_PATH . '/app/views/layouts/header.php';
        require_once BASE_PATH . '/app/views/barang/edit.php';
        require_once BASE_PATH . '/app/views/layouts/footer.php';
    }
    
    /**
     * Delete barang
     */
    public function delete($id = null) {
        AuthController::checkAdmin();
        
        if (!$id) {
            header('Location: ' . BASE_URL . '/barang');
            exit;
        }
        
        // Get barang info untuk hapus gambar
        $barang = $this->barangModel->getBarangById($id);
        
        if ($this->barangModel->deleteBarang($id)) {
            // Hapus gambar jika ada
            if (!empty($barang['gambar'])) {
                $imagePath = BASE_PATH . '/public/images/barang/' . $barang['gambar'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $_SESSION['success'] = "Barang berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus barang!";
        }
        
        header('Location: ' . BASE_URL . '/barang');
        exit;
    }
}