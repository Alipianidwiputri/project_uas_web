<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="bi bi-box"></i> Daftar Barang</h2>
                    <p class="text-muted mb-0">Kelola data barang Anda</p>
                </div>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <div>
                    <a href="<?php echo BASE_URL; ?>/barang/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Barang
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Search & Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-search"></i> Cari Barang</label>
                    <input type="text" class="form-control" name="search" 
                           placeholder="Masukkan nama barang..." 
                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="bi bi-funnel"></i> Filter Kategori</label>
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($kategoriList as $kat): ?>
                            <option value="<?php echo $kat['kategori']; ?>" 
                                    <?php echo (isset($_GET['kategori']) && $_GET['kategori'] == $kat['kategori']) ? 'selected' : ''; ?>>
                                <?php echo $kat['kategori']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Barang Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 10%;">Gambar</th>
                            <th style="width: 18%;">Nama Barang</th>
                            <th style="width: 12%;">Kategori</th>
                            <th style="width: 12%;" class="text-end">Harga Beli</th>
                            <th style="width: 12%;" class="text-end">Harga Jual</th>
                            <th style="width: 8%;" class="text-center">Stok</th>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                            <th style="width: 13%;" class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($barang)): ?>
                            <tr>
                                <td colspan="<?php echo $_SESSION['role'] === 'admin' ? '8' : '7'; ?>" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Tidak ada data barang</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            $no = ($page - 1) * $limit + 1;
                            foreach ($barang as $item): 
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php 
                                        $imagePath = BASE_URL . '/public/images/barang/' . $item['gambar'];
                                        $imageExists = !empty($item['gambar']) && file_exists(BASE_PATH . '/public/images/barang/' . $item['gambar']);
                                        ?>
                                        
                                        <?php if ($imageExists): ?>
                                            <img src="<?php echo $imagePath; ?>" 
                                                 alt="<?php echo htmlspecialchars($item['nama']); ?>" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                                 onclick="showImageModal('<?php echo $imagePath; ?>', '<?php echo htmlspecialchars($item['nama']); ?>')">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 5px;">
                                                <i class="bi bi-image text-muted" style="font-size: 1.5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['nama']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo htmlspecialchars($item['kategori']); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <small class="text-muted">Rp <?php echo number_format($item['harga_beli'], 0, ',', '.'); ?></small>
                                    </td>
                                    <td class="text-end">
                                        <strong>Rp <?php echo number_format($item['harga_jual'], 0, ',', '.'); ?></strong>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['stok'] > 10): ?>
                                            <span class="badge bg-success"><?php echo $item['stok']; ?></span>
                                        <?php elseif ($item['stok'] > 0): ?>
                                            <span class="badge bg-warning"><?php echo $item['stok']; ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?php echo $item['stok']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?php echo BASE_URL; ?>/barang/edit/<?php echo $item['id']; ?>" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/barang/delete/<?php echo $item['id']; ?>" 
                                               class="btn btn-danger" 
                                               onclick="return confirm('Yakin ingin menghapus barang ini?')" 
                                               title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['kategori']) ? '&kategori=' . urlencode($_GET['kategori']) : ''; ?>">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        
                        <?php
                        $start = max(1, $page - 2);
                        $end = min($totalPages, $page + 2);
                        
                        for ($i = $start; $i <= $end; $i++):
                        ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['kategori']) ? '&kategori=' . urlencode($_GET['kategori']) : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['kategori']) ? '&kategori=' . urlencode($_GET['kategori']) : ''; ?>">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                    
                    <p class="text-center text-muted">
                        Menampilkan halaman <?php echo $page; ?> dari <?php echo $totalPages; ?> 
                        (Total <?php echo $totalBarang; ?> barang)
                    </p>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal untuk preview gambar -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid" style="max-height: 500px;">
            </div>
        </div>
    </div>
</div>

<script>
function showImageModal(imageSrc, imageName) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = imageName;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>