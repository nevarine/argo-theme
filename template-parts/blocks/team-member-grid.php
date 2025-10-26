<?php

$columns = get_field('grid_columns') ?: 3;
$display_position = get_field('display_position');

$grid_class = 'grid-cols-1';
switch ($columns) {
    case '2':
        $grid_class = 'sm:grid-cols-2';
        break;
    case '3':
        $grid_class = 'sm:grid-cols-2 md:grid-cols-3';
        break;
    case '4':
        $grid_class = 'sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4';
        break;
}

$args = array(
        'post_type' => 'team_member',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
);
$team_members = new WP_Query($args);

if ($team_members->have_posts()):
    ?>
    <div class="team-member-grid grid <?php echo esc_attr($grid_class); ?> gap-8">
        <?php while ($team_members->have_posts()): $team_members->the_post(); ?>
            <?php
            $member_id = get_the_ID();
            $name = get_the_title();
            $position = get_field('position', $member_id);
            $image = get_field('profile_image', $member_id);
            $phone = get_field('phone_number', $member_id);
            ?>
            <div class="team-member-card text-center bg-white p-6 rounded-lg shadow-md transition-shadow hover:shadow-xl">
                <a href="<?php the_permalink(); ?>" class="flex-grow mb-4">
                    <?php if ($image): ?>
                        <img src="<?php echo esc_url($image['sizes']['medium_large']); ?>"
                             alt="<?php echo esc_attr($name); ?>"
                             class="w-32 h-32 rounded-full object-cover mx-auto mb-4 border-4 border-gray-200">
                    <?php else: ?>
                        <div class="w-32 h-32 rounded-full bg-gray-200 mx-auto mb-4 flex items-center justify-center">
                            <span class="text-gray-500"><?php _e('No Image', 'argo-theme') ?></span>
                        </div>
                    <?php endif; ?>

                    <h3 class="text-xl font-bold text-gray-800 hover:text-blue-600"><?php echo esc_html($name); ?></h3>

                    <?php if ($display_position && $position): ?>
                        <p class="text-md text-blue-600"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>
                </a>

                <?php if ($phone): ?>
                    <a href="tel:<?php echo esc_attr($phone); ?>"
                       class="mt-4 inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <span><?php echo esc_html($phone); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
else:
    ?>
    <p><?php _e('No team members found.', 'argo-theme') ?></p>
<?php endif; ?>