<?php
/**
 * Barang Model - Sesuai dengan tabel data_barang di latihan1
 */

class Barang {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    /**
     * Get all barang with pagination and search
     */
    public function getAllBarang($page = 1, $limit = 10, $search = '', $kategori = '') {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT * FROM data_barang WHERE 1=1";
        
        $params = [];
        $types = '';
        
        if (!empty($search)) {
            $query .= " AND nama LIKE ?";
            $params[] = "%$search%";
            $types .= 's';
        }
        
        if (!empty($kategori)) {
            $query .= " AND kategori = ?";
            $params[] = $kategori;
            $types .= 's';
        }
        
        $query .= " ORDER BY tanggal_input DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';
        
        $stmt = $this->db->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Count total barang
     */
    public function countBarang($search = '', $kategori = '') {
        $query = "SELECT COUNT(*) as total FROM data_barang WHERE 1=1";
        
        $params = [];
        $types = '';
        
        if (!empty($search)) {
            $query .= " AND nama LIKE ?";
            $params[] = "%$search%";
            $types .= 's';
        }
        
        if (!empty($kategori)) {
            $query .= " AND kategori = ?";
            $params[] = $kategori;
            $types .= 's';
        }
        
        if (!empty($params)) {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->db->query($query);
        }
        
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    /**
     * Get barang by ID
     */
    public function getBarangById($id) {
        $stmt = $this->db->prepare("SELECT * FROM data_barang WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Create new barang
     */
    public function createBarang($nama, $kategori, $harga_beli, $harga_jual, $stok, $gambar = '') {
        $stmt = $this->db->prepare("INSERT INTO data_barang (nama, kategori, harga_beli, harga_jual, stok, gambar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddis", $nama, $kategori, $harga_beli, $harga_jual, $stok, $gambar);
        return $stmt->execute();
    }
    
    /**
     * Update barang
     */
    public function updateBarang($id, $nama, $kategori, $harga_beli, $harga_jual, $stok, $gambar = '') {
        if (!empty($gambar)) {
            $stmt = $this->db->prepare("UPDATE data_barang SET nama = ?, kategori = ?, harga_beli = ?, harga_jual = ?, stok = ?, gambar = ? WHERE id = ?");
            $stmt->bind_param("ssddisi", $nama, $kategori, $harga_beli, $harga_jual, $stok, $gambar, $id);
        } else {
            $stmt = $this->db->prepare("UPDATE data_barang SET nama = ?, kategori = ?, harga_beli = ?, harga_jual = ?, stok = ? WHERE id = ?");
            $stmt->bind_param("ssddii", $nama, $kategori, $harga_beli, $harga_jual, $stok, $id);
        }
        return $stmt->execute();
    }
    
    /**
     * Delete barang
     */
    public function deleteBarang($id) {
        $stmt = $this->db->prepare("DELETE FROM data_barang WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    /**
     * Get distinct categories
     */
    public function getAllKategori() {
        $query = "SELECT DISTINCT kategori FROM data_barang ORDER BY kategori ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Count barang by category
     */
    public function countBarangByKategori() {
        $query = "SELECT kategori, COUNT(*) as total FROM data_barang GROUP BY kategori";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}