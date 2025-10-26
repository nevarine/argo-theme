<?php get_header(); ?>

    <main id="main" class="site-main">
        <div class="container mx-auto p-4">

            <header class="page-header mb-8 border-b pb-4">
                <h1 class="text-4xl font-bold">
                    <?php post_type_archive_title(); ?>
                </h1>
            </header>

            <?php if (have_posts()) : ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <?php

                    while (have_posts()) :
                        the_post();

                        $name = get_the_title();
                        $position = get_field('position');
                        $image = get_field('profile_image');
                        ?>
                        <div class="team-member-card text-center bg-white p-6 rounded-lg shadow-md transition-shadow hover:shadow-xl">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ($image): ?>Ł
                                    <img src="<?php echo esc_url($image['sizes']['medium_large']); ?>"
                                         alt="<?php echo esc_attr($name); ?>"
                                         class="w-32 h-32 rounded-full object-cover mx-auto mb-4 border-4 border-gray-200">
                                <?php else: ?>
                                    <div class="w-32 h-32 rounded-full bg-gray-200 mx-auto mb-4"></div>
                                <?php endif; ?>

                                <h3 class="text-xl font-bold text-gray-800"><?php echo esc_html($name); ?></h3>

                                <?php if ($position): ?>
                                    <p class="text-md text-blue-600"><?php echo esc_html($position); ?></p>
                                <?php endif; ?>
                            </a>
                        </div>

                    <?php endwhile; ?>
                </div>

                <?php

                the_posts_pagination();

            else :
                echo '<p>' . __('No team members found.', 'argo-theme') . '</p>';
            endif;
            ?>

        </div>
    </main>

<?php get_footer(); ?>