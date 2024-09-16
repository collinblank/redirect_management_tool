<?php
$results = $args['results'] ?? null;
?>

<?php if ($results) : ?>
    <div class="table-container">
        <table class="data-table">
            <thead class="table-header">
                <tr class="table-row">
                    <th class="table-cell">Name</th>
                    <th class="table-cell">From</th>
                    <th class="table-cell">To</th>
                    <th class="table-cell">Last modified</th>
                    <th class="table-cell"></th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php foreach ($results as $item) : ?>
                    <?php
                    $prefix_pattern = '/\^\S*\)/';
                    $suffix_pattern = '/\?\$/';
                    $from_url = '/' . preg_replace($suffix_pattern, '', preg_replace($prefix_pattern, '', $item['fromURLRegex']));
                    ?>
                    <tr class="table-row">
                        <td class="table-cell"><?= $item['name'] ?></td>
                        <td class="table-cell"><?= $from_url ?></td>
                        <td class="table-cell"><?= $item['toURL'] ?></td>
                        <td class="table-cell"><?= date_format(date_create($item['last_modified_date']), 'M j, Y h:i a') ?></td>
                        <td class="table-cell table-actions">
                            <div class="more-actions">
                                <button class="btn">Disable</button>
                                <button class="btn">Edit</button>
                            </div>
                            <button class="icon-btn more-actions-btn"><i class="fa-solid fa-ellipsis"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>