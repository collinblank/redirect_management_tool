<?php
$results = $args['results'] ?? null;
$is_redirects_page = $args['is_redirects_page'] ?? null;
?>

<?php if ($results) : ?>
    <ul class="list-view">
        <?php
        foreach ($results as $item) { ?>
            <li class="list-view__item <?php echo $item['disabled'] ? "disabled" : "" ?>" data-item-id=<?php echo $item['id']; ?>>
                <div class="list-view__item__info">
                    <h4><?php echo $item['name']; ?></h4>
                    <p class="list-view__item__description"><?php echo $item['domain']; ?></p>
                </div>
                <div class="list-view__item__flags-container">
                    <?php if ($item['disabled']) : ?>
                        <div class="list-view__item__flag red">
                            <p>Disabled</p>
                        </div>
                    <?php endif; ?>
                    <div class="list-view__item__flag <?php echo ($item['isProd']) ? "green" : "yellow" ?>">
                        <p><?php echo ($item['isProd']) ? "Production" : "Test" ?></p>
                    </div>
                </div>
                <div class="list-view__item__btns-container">
                    <?php if (!$is_redirects_page) : ?>
                        <button class="icon-btn edit-item-btn" title="Edit Website"><i class="fa-regular fa-pen-to-square"></i></button>
                        <?php if ($item['disabled']) : ?>
                            <button class="icon-btn enable-item-btn" title="Enable Website"><i class="fa-regular fa-circle-check"></i></button>
                        <?php else : ?>
                            <button class="icon-btn disable-item-btn" title="Disable Website"><i class="fa-regular fa-circle-xmark"></i></button>
                        <?php endif; ?>
                    <?php endif; ?>
                    <form action="/redirect-rules" method="GET">
                        <input type="hidden" name="website_id" value="<?php echo $item['id'] ?>">
                        <button type="submit" class="btn view-more-btn">View Redirects<i class="fa-solid fa-arrow-right-long"></i></button>
                    </form>
                </div>
            </li>
        <?php } ?>
    </ul>
    <!-- originally the below was and else if for the following condition -->
    <!-- if no filter, no search, but there are no results -->
    <!-- ($_SERVER['REQUEST_METHOD'] != 'GET' && !isset($search_text) && empty($results))  -->
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>