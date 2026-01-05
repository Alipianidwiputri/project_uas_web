<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
                    <p class="text-muted mb-0">Selamat datang, <strong><?php echo $_SESSION['nama']; ?></strong>!</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-box-seam" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Barang</h6>
                            <h3 class="mb-0"><?php echo $stats['total_barang']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info text-white rounded-circle p-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-people" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total User</h6>
                            <h3 class="mb-0"><?php echo $stats['total_users']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning text-white rounded-circle p-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-badge" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Role Anda</h6>
                            <h3 class="mb-0"><?php echo ucfirst($_SESSION['role']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Barang by Category -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Barang per Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($stats['barang_by_kategori'])): ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Belum ada data</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($stats['barang_by_kategori'] as $item): ?>
                                    <tr>
                                        <td>
                                            <i class="bi bi-tag"></i> <?php echo $item['kategori']; ?>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-primary"><?php echo $item['total']; ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Sistem</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person-circle"></i> Username</span>
                            <strong><?php echo $_SESSION['username']; ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-envelope"></i> Email</span>
                            <strong><?php echo $_SESSION['email']; ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-shield-check"></i> Role</span>
                            <span class="badge bg-<?php echo $_SESSION['role'] === 'admin' ? 'danger' : 'info'; ?>">
                                <?php echo ucfirst($_SESSION['role']); ?>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-calendar"></i> Login</span>
                            <strong><?php echo date('d M Y, H:i'); ?></strong>
                        </li>
                    </ul>
                    
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <div class="mt-3">
                        <a href="<?php echo BASE_URL; ?>/barang/create" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Tambah Barang Baru
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>