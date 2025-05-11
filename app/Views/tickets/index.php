<!DOCTYPE html>
<html>
<head>
    <title>Daftar Tiket</title>
</head>
<body>
    <h1>Daftar Tiket Anda</h1>

    <?php if (!empty($tickets)) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subjek</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket) : ?>
                    <tr>
                        <td><?= htmlspecialchars($ticket['id']) ?></td>
                        <td><?= htmlspecialchars($ticket['subject']) ?></td>
                        <td><?= htmlspecialchars($ticket['status']) ?></td>
                        <td><?= htmlspecialchars($ticket['created_at']) ?></td>
                        <td>
                            <a href="/tickets/view/<?= htmlspecialchars($ticket['id']) ?>">Lihat</a>
                            <a href="/tickets/reply/<?= htmlspecialchars($ticket['id']) ?>">Balas</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Belum ada tiket.</p>
    <?php endif; ?>

    <p><a href="/tickets/create">Buat Tiket Baru</a></p>
</body>
</html>
