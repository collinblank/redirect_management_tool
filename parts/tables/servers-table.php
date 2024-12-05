<?php
$results = $args['results'] ?? null;
?>

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
            <tr class="table-row <?php echo $item['disabled'] ? "disabled" : "" ?>" data-item-id=<?php echo $item['id']; ?>>
                <td class="table-cell"><?= $item['name'] ?></td>
                <td class="table-cell"><?= $item['domain'] ?></td>
                <td class="table-cell"><?= format_date_to_est($item['last_modified_date']) ?></td>
                <td class="table-cell table-actions">
                    <button class="icon-btn more-actions-toggle"><i class="fa-solid fa-ellipsis"></i></button>
                    <div class="more-actions-menu">
                        <div class="more-actions-btns">
                            <button class="icon-btn edit-item-btn" title="Edit server"><i class="fa-regular fa-pen-to-square"></i></button>
                            <?php if ($item['disabled']) : ?>
                                <button class="icon-btn enable-item-btn" title="Enable server"><i class="fa-regular fa-circle-check"></i></button>
                            <?php else : ?>
                                <button class="icon-btn disable-item-btn" title="Disable server"><i class="fa-regular fa-circle-xmark"></i></button>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>