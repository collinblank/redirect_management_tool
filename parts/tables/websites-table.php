<?php
$results = $args['results'] ?? null;
$is_redirects_page = $args['is_redirects_page'] ?? null;
?>

<?php if ($results) : ?>
    <table class="data-table">
        <thead class="table-header">
            <tr class="table-row">
                <th class="table-cell">Name</th>
                <th class="table-cell">Domain</th>
                <th class="table-cell">Prod/Test</th>
                <?php if (!$is_redirects_page) : ?>
                    <th class="table-cell">Last modified</th>
                <?php endif; ?>
                <th class="table-cell"></th>
            </tr>
        </thead>
        <tbody class="table-body">
            <?php foreach ($results as $item) : ?>
                <tr class="table-row <?php echo $item['disabled'] ? "disabled" : "" ?>" data-item-id=<?php echo $item['id']; ?>>
                    <td class="table-cell"><?= $item['name'] ?></td>
                    <td class="table-cell"><?= $item['domain'] ?></td>
                    <td class="table-cell">
                        <span class="table-flag <?= $item['is_prod'] ? 'green' : 'yellow' ?>">
                            <?= $item['is_prod'] ? 'Production' : 'Test' ?>
                        </span>
                    </td>
                    <?php if (!$is_redirects_page) : ?>
                        <td class="table-cell"><?= format_date_to_est($item['last_modified_date']) ?></td>
                    <?php endif; ?>
                    <td class="table-cell table-actions">
                        <?php if (!$is_redirects_page) : ?>
                            <button class="icon-btn more-actions-toggle"><i class="fa-solid fa-ellipsis"></i></button>
                            <div class="more-actions-menu">
                                <div class="more-actions-btns">
                                    <form action="/redirect-rules" method="GET">
                                        <input type="hidden" name="website_id" value="<?php echo $item['id'] ?>">
                                        <button type="submit" class="icon-btn view-more-btn" title="View redirects"><i class="fa-solid fa-arrows-turn-to-dots"></i></button>
                                    </form>
                                    <button class="icon-btn edit-item-btn" title="Edit website"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <?php if ($item['disabled']) : ?>
                                        <button class="icon-btn enable-item-btn" title="Enable website"><i class="fa-regular fa-circle-check"></i></button>
                                    <?php else : ?>
                                        <button class="icon-btn disable-item-btn" title="Disable website"><i class="fa-regular fa-circle-xmark"></i></button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <form action="/redirect-rules" method="GET">
                                <input type="hidden" name="website_id" value="<?php echo $item['id'] ?>">
                                <button type="submit" class="btn view-more-btn">Redirects<i class="fa-solid fa-arrow-right-long"></i></button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>