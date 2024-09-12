<?php

add_theme_support('title-tag');
add_theme_support('automatic-feed-links');

function custom_theme_enqueue_scripts() {

    wp_enqueue_style('semantic-ui-css', get_template_directory_uri() . '/semantic-ui-css/semantic.min.css');


    wp_enqueue_script('semantic-ui-js', get_template_directory_uri() . '/semantic-ui-css/semantic.min.js', array('jquery'), null, true);


    wp_enqueue_style('main-styles', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_scripts');


function add_meta_description_meta_box() {
    add_meta_box(
        'meta_description_box',         
        'Meta Description',              
        'meta_description_meta_box_html',
        'post'                           
    );
}
add_action('add_meta_boxes', 'add_meta_description_meta_box');


function meta_description_meta_box_html($post) {

    $meta_description = get_post_meta($post->ID, 'meta_description', true);
    ?>
    <label for="meta_description">Meta Description</label>
    <input type="text" id="meta_description" name="meta_description" value="<?php echo esc_attr($meta_description); ?>" style="width:100%;" />
    <?php
}


function save_meta_description_meta_box_data($post_id) {

    if (!isset($_POST['meta_description_nonce'])) {
        return;
    }


    if (!wp_verify_nonce($_POST['meta_description_nonce'], 'save_meta_description')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }


    if (isset($_POST['meta_description'])) {
        $meta_description = sanitize_text_field($_POST['meta_description']);
        update_post_meta($post_id, 'meta_description', $meta_description);
    }
}
add_action('save_post', 'save_meta_description_meta_box_data');


function meta_description_nonce_field() {
    wp_nonce_field('save_meta_description', 'meta_description_nonce');
}
add_action('edit_form_after_title', 'meta_description_nonce_field');



function minimalflow_customize_register($wp_customize) {

    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'minimalflow'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default' => 'Welcome to Flow',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_title_control', array(
        'label' => __('Hero Section Title', 'minimalflow'),
        'section' => 'hero_section',
        'settings' => 'hero_title',
        'type' => 'text',
    ));


    $wp_customize->add_setting('hero_description', array(
        'default' => 'On the flow of programming.',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hero_description_control', array(
        'label' => __('Hero Section Description', 'minimalflow'),
        'section' => 'hero_section',
        'settings' => 'hero_description',
        'type' => 'textarea',
    ));

  
    $wp_customize->add_setting('hero_background_image', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image_control', array(
        'label' => __('Hero Section Background Image', 'minimalflow'),
        'section' => 'hero_section',
        'settings' => 'hero_background_image',
    )));
}
add_action('customize_register', 'minimalflow_customize_register');
