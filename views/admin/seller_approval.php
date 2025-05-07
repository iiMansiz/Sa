<?php $data['title'] = 'Persetujuan Penjual'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <?php if (!empty($data['pending_sellers'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nama Toko</th>
                    <th>Tanggal Registrasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['pending_sellers'] as $seller): ?>
                    <tr>
                        <td><?= htmlspecialchars($seller['nama']) ?></td>
                        <td><?= htmlspecialchars($seller['email']) ?></td>
                        <td><?= htmlspecialchars($seller['nama_toko']) ?></td>
                        <td><?= htmlspecialchars($seller['registration_date']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/sellers/approve/<?= $seller['id'] ?>" class="btn btn-sm btn-success">Setujui</a>
                            <a href="<?= BASE_URL ?>/admin/sellers/reject/<?= $seller['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menolak pendaftaran ini?')">Tolak</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada pendaftaran penjual yang menunggu persetujuan.</p>
    <?php endif; ?>
<?php } ?>
