<section id="home-page" class="page-section">
    <p>What would you like to work on?</p>
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