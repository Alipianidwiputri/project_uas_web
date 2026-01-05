<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="<?php echo BASE_URL; ?>/barang" class="btn btn-light me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h2><i class="bi bi-plus-circle"></i> Tambah Barang Baru</h2>
                    <p class="text-muted mb-0">Lengkapi form di bawah untuk menambahkan barang</p>
                </div>
            </div>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle"></i> Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                <i class="bi bi-box"></i> Nama Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="nama" name="nama" 
                                   placeholder="Contoh: HP Samsung" 
                                   value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kategori" class="form-label">
                                <i class="bi bi-tag"></i> Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="kategori" name="kategori" 
                                   placeholder="Contoh: Elektronik" 
                                   list="kategoriList"
                                   value="<?php echo isset($_POST['kategori']) ? htmlspecialchars($_POST['kategori']) : ''; ?>" 
                                   required>
                            <datalist id="kategoriList">
                                <?php foreach ($kategoriList as $kat): ?>
                                    <option value="<?php echo $kat['kategori']; ?>">
                                <?php endforeach; ?>
                            </datalist>
                            <small class="text-muted">Ketik kategori baru atau pilih dari list</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga_beli" class="form-label">
                                        <i class="bi bi-currency-dollar"></i> Harga Beli <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" 
                                               placeholder="0" step="0.01" min="0"
                                               value="<?php echo isset($_POST['harga_beli']) ? htmlspecialchars($_POST['harga_beli']) : ''; ?>" 
                                               required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga_jual" class="form-label">
                                        <i class="bi bi-currency-dollar"></i> Harga Jual <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" 
                                               placeholder="0" step="0.01" min="0"
                                               value="<?php echo isset($_POST['harga_jual']) ? htmlspecialchars($_POST['harga_jual']) : ''; ?>" 
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stok" class="form-label">
                                <i class="bi bi-boxes"></i> Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="stok" name="stok" 
                                   placeholder="0" min="0"
                                   value="<?php echo isset($_POST['stok']) ? htmlspecialchars($_POST['stok']) : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="gambar" class="form-label">
                                <i class="bi bi-image"></i> Upload Gambar Produk
                            </label>
                            <input type="file" class="form-control" id="gambar_file" name="gambar_file" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, JPEG (Max 2MB). Atau ketik nama file manual di bawah</small>
                            
                            <div class="mt-2">
                                <label for="gambar" class="form-label">Atau ketik nama file gambar:</label>
                                <input type="text" class="form-control" id="gambar" name="gambar" 
                                       placeholder="Contoh: hp_samsung.jpg" 
                                       value="<?php echo isset($_POST['gambar']) ? htmlspecialchars($_POST['gambar']) : ''; ?>">
                            </div>
                            
                            <!-- Preview gambar -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <p class="text-muted">Preview:</p>
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Barang
                            </button>
                            <a href="<?php echo BASE_URL; ?>/barang" class="btn btn-light">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview image before upload
document.getElementById('gambar_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
        
        // Auto-fill nama file
        document.getElementById('gambar').value = file.name;
    }
});
</script>