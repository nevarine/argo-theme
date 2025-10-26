<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-gray-100 text-gray-800'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site flex flex-col min-h-screen">
    <header id="masthead" class="site-header bg-blue-600 text-white shadow-md">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <h1 class="site-title text-2xl font-bold">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                    <p class="site-description text-sm opacity-75"><?php bloginfo('description'); ?></p>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'flex space-x-4',
                        'container' => false,
                        'fallback_cb' => false,
                ));
                ?>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content container mx-auto p-4 flex-grow">