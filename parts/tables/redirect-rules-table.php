<?php
$results = $args['results'] ?? null;
// $website_domain = $args['website_domain'] ?? '';
?>

<?php if ($results) : ?>
    <table class="data-table">
        <thead class="table-header">
            <tr class="table-row">
                <th class="table-cell">Status</th>
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
                if ($item['disabled']) {
                    $status = 'disabled';
                    $flag_color = 'red';
                } elseif (empty($item['committed'])) {
                    $status = 'staged';
                    $flag_color = 'yellow';
                } else {
                    $status = 'committed';
                    $flag_color = 'green';
                }
                ?>
                <tr class="table-row <?= $status ?>" data-item-id=<?php echo $item['id']; ?>>
                    <td class="table-cell status">
                        <span class="table-flag <?= $flag_color ?>">
                            <?= $status ?>
                        </span>
                    </td>
                    <td class="table-cell"><?= $item['name'] ?></td>
                    <td class="table-cell"><?= '/' . get_from_path($item) ?></td>
                    <td class="table-cell"><?= $item['to_url'] ?></td>
                    <td class="table-cell"><?= format_date_to_est($item['last_modified_date']) ?></td>
                    <td class="table-cell table-actions">
                        <button class="icon-btn more-actions-toggle"><i class="fa-solid fa-ellipsis"></i></button>
                        <div class="more-actions-menu">
                            <div class="more-actions-btns">
                                <?php if ($status == 'active') : ?>
                                    <a href="<?= get_full_from_url($item) ?>" class="icon-link" title="Test rule" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-flask"></i></a>
                                <?php endif; ?>
                                <button class="icon-btn edit-item-btn" title="Edit rule"><i class="fa-regular fa-pen-to-square"></i></button>
                                <?php if ($item['disabled']) : ?>
                                    <button class="icon-btn enable-item-btn" title="Enable rule"><i class="fa-regular fa-circle-check"></i></button>
                                <?php else : ?>
                                    <button class="icon-btn disable-item-btn" title="Disable rule"><i class="fa-regular fa-circle-xmark"></i></button>
                                <?php endif; ?>
                                <?php if (!$item['committed']) : ?>
                                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                                        <input type="hidden" name="action" value="commit_single_rule">
                                        <?php wp_nonce_field('commit_single_rule_form_nonce', 'commit_single_rule_form_nonce_field'); ?>
                                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                        <input type="hidden" name="website_id" value="<?= $item['website_id'] ?>">
                                        <button type="submit" class="icon-btn enable-item-btn" title="Commit rule"><i class="fa-regular fa-circle-check"></i></button>
                                    </form>
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