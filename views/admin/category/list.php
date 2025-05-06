<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Manajemen Kategori</h2>

    <a href="/admin/categories/add" class="btn btn-success mb-3">Tambah Kategori</a>

    <?php if (empty($categories)): ?>
        <p>Belum ada kategori.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= htmlspecialchars($category['nama']) ?></td>
                        <td>
                            <a href="/admin/categories/edit/<?= $category['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="/admin/categories/delete/<?= $category['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

<?php $this->end(); ?>
