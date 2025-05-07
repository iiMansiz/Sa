<?php $data['title'] = 'Manajemen Metode Pengiriman'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <a href="<?= BASE_URL ?>/admin/shipping/add" class="btn btn-primary mb-3">Tambah Metode Pengiriman</a>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Biaya</th>
                <th>COD</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['shipping_methods'] as $sm): ?>
                <tr>
                    <td><?= htmlspecialchars($sm['nama']) ?></td>
                    <td>Rp <?= number_format($sm['biaya'], 0, ',', '.') ?></td>
                    <td><?= $sm['is_cod_available'] ? 'Ya' : 'Tidak' ?></td>
                    <td><?= $sm['is_active'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/shipping/edit/<?= $sm['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= BASE_URL ?>/admin/shipping/delete/<?= $sm['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
