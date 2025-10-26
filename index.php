<?php
get_header(); ?>

    <main id="main" class="site-main">
        <div class="container mx-auto p-4">

            <?php if (is_home() && !is_front_page()) : ?>
                <header class="page-header mb-8 border-b pb-4">
                    <h1 class="page-title text-4xl font-bold"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <?php if (have_posts()) : ?>

                <div class="space-y-12">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content/content', get_post_format());
                    endwhile;
                    ?>
                </div>

                <?php
                the_posts_pagination(array(
                        'prev_text' => '&laquo; <span class="hidden sm:inline">Předchozí</span>',
                        'next_text' => '<span class="hidden sm:inline">Následující</span> &raquo;',
                        'screen_reader_text' => ' ',
                ));

            else :
                get_template_part('template-parts/content/content-none');
            endif;
            ?>

        </div>
    </main>

<?php get_footer(); ?>