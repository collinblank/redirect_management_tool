<div class="sidebar">
    <?php
    wp_nav_menu(
        array(
            'menu' => 'Main Menu',
            'container' => 'div',
            'container_class' => 'main-menu-container',
            'menu_class' => 'main-menu',
            'walker' => new Icon_Walker_Nav_Menu()
        )
    );
    ?>
</div>