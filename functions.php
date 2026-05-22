<?php
/**
 * Elif Center Perú - Theme functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme setup - support, image sizes, etc.
 */
function elif_center_setup() {
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo', array(
        'height'      => 92,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'elif_center_setup' );

/**
 * Enqueue Google Fonts (Fraunces + Mulish) and theme stylesheet.
 * Uses enqueue_block_assets so fonts load in the editor too.
 */
function elif_center_enqueue_assets() {
    wp_enqueue_style(
        'elif-center-fonts',
        'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght,SOFT,WONK@9..144,300..700,30..100,0..1&family=Mulish:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'elif-center-style',
        get_stylesheet_uri(),
        array( 'elif-center-fonts' ),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'enqueue_block_assets', 'elif_center_enqueue_assets' );

/**
 * Register block pattern category.
 */
function elif_center_register_pattern_category() {
    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category(
            'elif-center',
            array( 'label' => __( 'Elif Center', 'elif-center' ) )
        );
    }
}
add_action( 'init', 'elif_center_register_pattern_category' );

/**
 * Enqueue front-end scripts (scroll-reveal and mobile nav).
 */
function elif_center_enqueue_scripts() {
    $version = wp_get_theme()->get( 'Version' );

    wp_enqueue_script(
        'elif-center-scroll-reveal',
        get_stylesheet_directory_uri() . '/assets/scroll-reveal.js',
        array(),
        $version,
        array( 'in_footer' => true, 'strategy' => 'defer' )
    );

    wp_enqueue_script(
        'elif-center-mobile-nav',
        get_stylesheet_directory_uri() . '/assets/mobile-nav.js',
        array(),
        $version,
        array( 'in_footer' => true, 'strategy' => 'defer' )
    );
}
add_action( 'wp_enqueue_scripts', 'elif_center_enqueue_scripts' );
