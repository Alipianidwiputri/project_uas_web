<?php
/**
 * Auth Controller - Handle login dan logout
 */

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
     * Show login page
     */
    public function login() {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
        
        // Handle login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Validation
            if (empty($username) || empty($password)) {
                $error = "Username dan password harus diisi!";
            } else {
                // Get user from database
                $user = $this->userModel->getUserByUsername($username);
                
                if ($user) {
                    // Cek password (support hash dan plain text)
                    $isPasswordCorrect = false;
                    
                    // Cek jika password di-hash (starts with $2y$)
                    if (strpos($user['password'], '$2y$') === 0) {
                        // Password is hashed, use password_verify
                        if (password_verify($password, $user['password'])) {
                            $isPasswordCorrect = true;
                        }
                    } else {
                        // Password is plain text, direct comparison
                        if ($password === $user['password']) {
                            $isPasswordCorrect = true;
                        }
                    }
                    
                    if ($isPasswordCorrect) {
                        // Login successful
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['nama'] = $user['nama'];
                        $_SESSION['email'] = $user['email'];
                        
                        // Cek apakah user adalah admin (username = admin)
                        $_SESSION['role'] = ($user['username'] === 'admin') ? 'admin' : 'user';
                        
                        header('Location: ' . BASE_URL . '/dashboard');
                        exit;
                    } else {
                        $error = "Username atau password salah!";
                    }
                } else {
                    $error = "Username atau password salah!";
                }
            }
        }
        
        // Show login view
        require_once BASE_PATH . '/app/views/auth/login.php';
    }
    
    /**
     * Logout
     */
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
    
    /**
     * Check if user is logged in
     */
    public static function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }
    
    /**
     * Check if user is admin
     */
    public static function checkAdmin() {
        self::checkLogin();
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = "Anda tidak memiliki akses ke halaman ini!";
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }
}