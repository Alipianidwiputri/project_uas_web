<?php
/**
 * Dashboard Controller
 */

class DashboardController {
    private $userModel;
    private $barangModel;
    
    public function __construct() {
        // PENTING: Cek login SEBELUM load model
        AuthController::checkLogin();
        
        $this->userModel = new User();
        $this->barangModel = new Barang();
    }
    
    /**
     * Show dashboard page
     */
    public function index() {
        // Double check login (safety)
        AuthController::checkLogin();
        
        // Get statistics
        $stats = [
            'total_barang' => $this->barangModel->countBarang(),
            'total_users' => $this->userModel->countUsers(),
            'barang_by_kategori' => $this->barangModel->countBarangByKategori()
        ];
        
        $pageTitle = 'Dashboard';
        
        // Load view
        require_once BASE_PATH . '/app/views/layouts/header.php';
        require_once BASE_PATH . '/app/views/dashboard/index.php';
        require_once BASE_PATH . '/app/views/layouts/footer.php';
    }
}