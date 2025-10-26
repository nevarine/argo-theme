<?php

get_header(); ?>

    <main id="main" class="site-main">
        <div class="container mx-auto p-4">
            <?php
            while (have_posts()) :
                the_post();

                $member_id = get_the_ID();
                $name = get_the_title();
                $position = get_field('position');
                $description = get_field('description');
                $image = get_field('profile_image');
                $phone = get_field('phone_number');
                $email = get_field('email');
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="team-member-detail bg-white p-8 rounded-lg shadow-lg max-w-3xl mx-auto">
                        <div class="flex flex-col sm:flex-row items-center gap-8">
                            <?php if ($image): ?>
                                <div class="flex-shrink-0">
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                         alt="<?php echo esc_attr($name); ?>"
                                         class="w-40 h-40 rounded-full object-cover border-4 border-blue-500">
                                </div>
                            <?php endif; ?>
                            <div class="text-center sm:text-left">
                                <h1 class="text-4xl font-bold text-gray-800"><?php echo esc_html($name); ?></h1>
                                <?php if ($position): ?>
                                    <p class="text-2xl text-blue-600 font-semibold"><?php echo esc_html($position); ?></p>
                                <?php endif; ?>
                                <div class="mt-4 flex flex-col sm:flex-row gap-4 justify-center sm:justify-start">
                                    <?php if ($phone): ?>
                                        <a href="tel:<?php echo esc_attr($phone); ?>"
                                           class="flex items-center gap-2 text-gray-600 hover:text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                            </svg>
                                            <span><?php echo esc_html($phone); ?></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($email): ?>
                                        <a href="mailto:<?php echo esc_attr($email); ?>"
                                           class="flex items-center gap-2 text-gray-600 hover:text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                            </svg>
                                            <span><?php echo esc_html($email); ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($description): ?>
                            <div class="prose max-w-none mt-8 pt-6 border-t">
                                <?php echo wp_kses_post($description); ?>
                            </div>
                        <?php endif; ?>

                        <?php

                        $args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 5,
                                'meta_query' => array(
                                        array(
                                                'key' => 'reviewer',
                                                'value' => $member_id,
                                                'compare' => '=',
                                        )
                                )
                        );
                        $reviewed_posts = new WP_Query($args);

                        if ($reviewed_posts->have_posts()):
                            ?>
                            <div class="mt-8 pt-6 border-t">
                                <h3 class="text-xl font-semibold mb-4"><?php _e('Reviewed Posts:', 'argo-theme') ?></h3>
                                <ul class="list-disc list-inside">
                                    <?php while ($reviewed_posts->have_posts()): $reviewed_posts->the_post(); ?>
                                        <li><a href="<?php the_permalink(); ?>"
                                               class="text-blue-600 hover:underline"><?php the_title(); ?></a></li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                            <?php
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </article>

            <?php endwhile; ?>
        </div>
    </main>

<?php get_footer(); ?>