<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Viewer</title>
</head>
<body>
    <h2>Database Viewer</h2>

    <form method="post" action="<?= site_url('data/fetch_table'); ?>">
        <label for="table_name">Pilih Tabel:</label>
        <select name="table_name" id="table_name">
            <option value="">-- Pilih Tabel --</option>
            <?php foreach ($tables as $table): ?>
                <option value="<?= $table; ?>" <?= ($table == $selected_table) ? 'selected' : ''; ?>><?= $table; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Tampilkan</button>
    </form>

    <?php if ($selected_table): ?>

        <h3>Tambah Data ke <?= $selected_table; ?></h3>
        <form method="post" action="<?= site_url('data/insert'); ?>">
            <input type="hidden" name="table_name" value="<?= $selected_table; ?>">
            <?php foreach ($columns as $column): ?>
                <label for="<?= $column; ?>"><?= $column; ?>:</label>
                <input type="text" name="<?= $column; ?>" required>
                <br>
            <?php endforeach; ?>
            <button type="submit">Tambah</button>
        </form>
        <h3>Data dari tabel: <?= $selected_table; ?></h3>
        
        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?= $error_message; ?></p>
        <?php endif; ?>

        <table border="1">
            <tr>
                <?php foreach ($columns as $column): ?>
                    <th><?= $column; ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($records as $record): ?>
                <tr>
                    <?php foreach ($columns as $column): ?>
                        <td><?= isset($record[$column]) ? $record[$column] : ''; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>

        
    <?php endif; ?>
</body>
</html>
