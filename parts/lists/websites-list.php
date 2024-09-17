<?php
$results = $args['results'] ?? null;
$is_redirects_page = $args['is_redirects_page'] ?? null;
?>

<?php if ($results) : ?>
    <div class="table-container">
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
                            <div class="table-flag <?= $item['isProd'] ? 'green' : 'yellow' ?>">
                                <?= $item['isProd'] ? 'Production' : 'Test' ?>
                            </div>
                        </td>
                        <?php if (!$is_redirects_page) : ?>
                            <td class="table-cell"><?= date_format(date_create($item['last_modified_date']), 'M j, Y h:i a') ?></td>
                        <?php endif; ?>
                        <td class="table-cell table-actions">
                            <?php if (!$is_redirects_page) : ?>
                                <button class="icon-btn more-actions-toggle"><i class="fa-solid fa-ellipsis"></i></button>
                                <div class="more-actions-menu">
                                    <div class="more-actions-btns">
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
    </div>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>