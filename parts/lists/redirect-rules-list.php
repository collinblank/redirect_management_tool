<?php
$results = $args['results'] ?? null;
?>

<?php if ($results) : ?>
    <ul class="list-view">
        <?php
        foreach ($results as $item) {
            $prefix_pattern = '/\^\S*\)/';
            $suffix_pattern = '/\?\$/';
            $fromURL = '/' . preg_replace($suffix_pattern, '', preg_replace($prefix_pattern, '', $item['fromURLRegex']));
        ?>
            <li class="list-view__item <?php echo $item['disabled'] ? "disabled" : "" ?>" data-item-id=<?php echo $item['id']; ?>>
                <div class="list-view__item__info">
                    <h4><?php echo $item['name']; ?></h4>
                    <p class="list-view__item__description"><?php echo $item['description']; ?></p>
                    <p class="list-view__item__description"><?php echo $fromURL . '<i class="fa-solid fa-arrow-right-long"></i>' . $item['toURL']; ?></p>
                </div>
                <?php if ($item['disabled']) : ?>
                    <div class="list-view__item__flags-container">
                        <div class="list-view__item__flag red">
                            <p>Disabled</p>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="list-view__item__btns-container">
                    <button class="icon-btn edit-item-btn" title="Edit Redirect"><i class="fa-regular fa-pen-to-square"></i></button>
                    <?php if ($item['disabled']) : ?>
                        <button class="icon-btn enable-item-btn" title="Enable Redirect"><i class="fa-regular fa-circle-check"></i></button>
                    <?php else : ?>
                        <button class="icon-btn disable-item-btn" title="Disable Redirect"><i class="fa-regular fa-circle-xmark"></i></button>
                    <?php endif; ?>
                </div>
            </li>
        <?php } ?>
    </ul>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>