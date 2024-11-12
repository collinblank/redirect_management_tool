<?php
$results = $args['results'] ?? null;
?>

<?php if ($results) : ?>
    <table class="data-table">
        <thead class="table-header">
            <tr class="table-row">
                <th class="table-cell">Flag</th>
                <th class="table-cell">Name</th>
                <th class="table-cell">Description</th>
                <th class="table-cell"></th>
            </tr>
        </thead>
        <tbody class="table-body flag-table">
            <?php foreach ($results as $item) : ?>
                <tr class="table-row" data-item-id=<?php echo $item['id']; ?>>
                    <td class="table-cell"><?= $item['flags'] ?></td>
                    <td class="table-cell"><?= $item['name'] ?></td>
                    <td class="table-cell <?php if (strlen($item['description']) > 50) echo "word-wrap_cell"; ?>"><?= $item['description'] ?></td>
                    <td class="table-cell table-actions">
                        <button class="icon-btn more-actions-toggle"><i class="fa-solid fa-ellipsis"></i></button>
                        <div class="more-actions-menu">
                            <div class="more-actions-btns">
                                <button class="icon-btn edit-item-btn" title="Edit Redirect Flag"><i class="fa-regular fa-pen-to-square"></i></button>
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