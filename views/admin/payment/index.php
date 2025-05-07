<?php $data['title'] = 'Manajemen Metode Pembayaran'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <a href="<?= BASE_URL ?>/admin/payment/add" class="btn btn-primary mb-3">Tambah Metode Pembayaran</a>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kode</th>
                <th>Otomatis</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['payment_methods'] as $pm): ?>
                <tr>
                    <td><?= htmlspecialchars($pm['nama']) ?></td>
                    <td><?= htmlspecialchars($pm['code']) ?></td>
                    <td><?= $pm['is_automatic'] ? 'Ya' : 'Tidak' ?></td>
                    <td><?= $pm['is_active'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/payment/edit/<?= $pm['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= BASE_URL ?>/admin/payment/delete/<?= $pm['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
