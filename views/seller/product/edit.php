<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Edit Produk</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="/seller/products/edit/<?= $product['id'] ?>" method="post">
        <div class="form-group">
            <label for="nama">Nama Produk:</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($product['nama']) ?>" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi:</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= htmlspecialchars($product['deskripsi']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" class="form-control" id="harga" name="harga" min="0" step="0.01" value="<?= $product['harga'] ?>" required>
        </div>
        <div class="form-group">
            <label for="stok">Stok:</label>
            <input type="number" class="form-control" id="stok" name="stok" min="0" value="<?= $product['stok'] ?>" required>
        </div>
        <div class="form-group">
            <label for="category_id">Kategori:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= ($product['category_id'] == $category['id'] ? 'selected' : '') ?>><?= htmlspecialchars($category['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="/seller/products" class="btn btn-secondary">Batal</a>
    </form>

<?php $this->end(); ?>
