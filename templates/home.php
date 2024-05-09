<section id="home-page" class="page-section">
    <?php
    wp_nav_menu(
        array(
            'menu' => 'Main Menu',
            'container' => 'div',
            'container_class' => 'main-menu-container',
            'menu_class' => 'main-menu'
        )
    );
    ?>
</section>