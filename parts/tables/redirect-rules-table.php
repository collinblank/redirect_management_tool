<?php
$results = $args['results'] ?? null;
?>

<?php if ($results) : ?>
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
                <tr class="table-row <?php echo $item['disabled'] ? "disabled" : "" ?>" data-item-id=<?php echo $item['id']; ?>>
                    <td class="table-cell"><?= $item['name'] ?></td>
                    <td class="table-cell"><?= $from_url ?></td>
                    <td class="table-cell"><?= $item['toURL'] ?></td>
                    <td class="table-cell"><?= date_format(date_create($item['last_modified_date']), 'M j, Y g:i a') ?></td>
                    <td class="table-cell table-actions">
                        <button class="icon-btn more-actions-toggle"><i class="fa-solid fa-ellipsis"></i></button>
                        <div class="more-actions-menu">
                            <div class="more-actions-btns">
                                <button class="icon-btn edit-item-btn" title="Edit rule"><i class="fa-regular fa-pen-to-square"></i></button>
                                <?php if ($item['disabled']) : ?>
                                    <button class="icon-btn enable-item-btn" title="Enable rule"><i class="fa-regular fa-circle-check"></i></button>
                                <?php else : ?>
                                    <button class="icon-btn disable-item-btn" title="Disable rule"><i class="fa-regular fa-circle-xmark"></i></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>