<?php
$results = $args['results'] ?? null;
?>

<?php if ($results) : ?>
    <table class="data-table">
        <thead class="table-header">
            <tr class="table-row">
                <th class="table-cell">Name</th>
                <th class="table-cell">Domain</th>
                <th class="table-cell">Last modified</th>
                <th class="table-cell"></th>
            </tr>
        </thead>
        <tbody class="table-body">
            <?php foreach ($results as $item) : ?>
                <tr class="table-row">
                    <td class="table-cell"><?= $item['name'] ?></td>
                    <td class="table-cell"><?= $item['domain'] ?></td>
                    <td class="table-cell time-cell"><?= date_format(date_create($item['last_modified_date']), 'M j, Y h:i a') ?></td>
                    <td class="table-cell table-actions">
                        <div class="more-actions">
                            <button class="default-btn">Disable</button>
                            <button class="default-btn">Edit</button>
                        </div>
                        <button class="icon-btn more-actions-btn"><i class="fa-solid fa-ellipsis"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>