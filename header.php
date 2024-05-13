<?php
$page_title = get_the_title();
if (str_contains($page_title, "Private: ")) {
    $page_title = str_replace("Private: ", "", $page_title);
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <!-- Start Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- End Google Font Inter -->
    <script src="https://kit.fontawesome.com/3feedd961e.js" crossorigin="anonymous"></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="wrapper" class="hfeed">
        <header id="header" role="banner">
            <nav class="nav">
                <a href="<?php echo get_home_url(); ?>"><i class="fa-solid fa-house"></i></a>
                <?php
                if (!is_front_page()) { ?>
                    <a class="nav-link" href="<?php echo get_page_link(); ?>"><?php echo $page_title; ?></a>
                <?php }
                ?>
            </nav>
            <!-- <nav id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                <?php
                // wp_nav_menu(
                //     array(
                //         'menu' => 'Main Menu',
                //         'container' => 'div',
                //         'container_class' => 'main-menu-container',
                //         'menu_class' => 'main-menu'
                //     )
                // );
                ?>
            </nav> -->
        </header>
        <div id="container">
            <main id="content" role="main">