<?php

/**
 * Vendor autoload
 */
require 'vendor/autoload.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/nevarine/argo-theme',
    __FILE__,
    'argo-theme'
);


/**
 * Enqueue scripts and styles
 *
 * @return void
 */
function vite_enqueue_assets(): void
{
    $vite_dev_server_url = 'http://localhost:5173';

    $is_vite_dev = false;
    if (defined('WP_DEBUG') && WP_DEBUG) {
        if (!file_exists(get_theme_file_path('dist/.vite/manifest.json'))) {
            $is_vite_dev = true;
        }
    }

    if ($is_vite_dev) {
        wp_enqueue_script('vite-client', $vite_dev_server_url . '/@vite/client', [], null, ['type' => 'module']);
        wp_enqueue_script('main-js', $vite_dev_server_url . '/src/main.js', [], null, ['type' => 'module']);
    } else {
        $manifest_path = get_theme_file_path('dist/.vite/manifest.json');
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);

            if (is_array($manifest)) {
                if (isset($manifest['src/main.js']['file'])) {
                    $js_file = $manifest['src/main.js']['file'];
                    var_dump($js_file);
                    var_dump(get_template_directory_uri() . '/dist/' . $js_file);
                    wp_enqueue_script('main-js', get_template_directory_uri() . '/dist/' . $js_file, [], time(), true);
                }

                if (isset($manifest['src/main.js']['css'])) {
                    foreach ($manifest['src/main.js']['css'] as $css_file) {
                        var_dump(get_template_directory_uri() . '/dist/' . $css_file);
                        wp_enqueue_style('main-css', get_template_directory_uri() . '/dist/' . $css_file, [], time());
                    }
                }
            }
        }
    }
}

add_action('wp_enqueue_scripts', 'vite_enqueue_assets');

function add_type_attribute($tag, $handle, $src)
{
    if (in_array($handle, ['vite-client', 'main-js'])) {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}

add_filter('script_loader_tag', 'add_type_attribute', 10, 3);

/**
 * Register navigation menu
 *
 * @return void
 */
function argo_theme_setup(): void
{
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'argo-theme'),
    ));
}

add_action('after_setup_theme', 'argo_theme_setup');