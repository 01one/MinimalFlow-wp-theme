<?php


function custom_theme_enqueue_scripts() {

    // Enqueue Semantic UI CSS
    wp_enqueue_style('semantic-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css');

    // Enqueue Semantic UI JS
    wp_enqueue_script('semantic-ui-js', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.js', array('jquery'), null, true);



    // Enqueue your theme's main stylesheet
    wp_enqueue_style('main-styles', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_scripts'); 














// Add meta box to post editor
function add_meta_description_meta_box() {
    add_meta_box(
        'meta_description_box',          // Unique ID
        'Meta Description',              // Box title
        'meta_description_meta_box_html', // Content callback
        'post'                            // Post type
    );
}
add_action('add_meta_boxes', 'add_meta_description_meta_box');

// Meta box HTML
function meta_description_meta_box_html($post) {
    // Retrieve existing value from the database
    $meta_description = get_post_meta($post->ID, 'meta_description', true);
    ?>
    <label for="meta_description">Meta Description</label>
    <input type="text" id="meta_description" name="meta_description" value="<?php echo esc_attr($meta_description); ?>" style="width:100%;" />
    <?php
}

// Save meta box data
function save_meta_description_meta_box_data($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['meta_description_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['meta_description_nonce'], 'save_meta_description')) {
        return;
    }

    // Check if the user has permissions to save data.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sanitize and save the meta description.
    if (isset($_POST['meta_description'])) {
        $meta_description = sanitize_text_field($_POST['meta_description']);
        update_post_meta($post_id, 'meta_description', $meta_description);
    }
}
add_action('save_post', 'save_meta_description_meta_box_data');

// Add nonce field for security
function meta_description_nonce_field() {
    wp_nonce_field('save_meta_description', 'meta_description_nonce');
}
add_action('edit_form_after_title', 'meta_description_nonce_field');

// Optional: Add a meta description to the head for posts
/*
function add_meta_description_to_head() {
    if (is_single()) {
        global $post;
        $meta_description = get_post_meta($post->ID, 'meta_description', true);
        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        } else {
            // Fallback to the post title if no meta description is set
            echo '<meta name="description" content="' . esc_attr(get_the_title()) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'add_meta_description_to_head');
*/



function mytheme_customize_register($wp_customize) {
    // Add a new section for the Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'mytheme'),
        'priority' => 30,
    ));

    // Hero Section Title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Welcome to Flow',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hero_title_control', array(
        'label' => __('Hero Section Title', 'mytheme'),
        'section' => 'hero_section',
        'settings' => 'hero_title',
        'type' => 'text',
    ));

    // Hero Section Description
    $wp_customize->add_setting('hero_description', array(
        'default' => 'On the flow of programming.',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hero_description_control', array(
        'label' => __('Hero Section Description', 'mytheme'),
        'section' => 'hero_section',
        'settings' => 'hero_description',
        'type' => 'textarea',
    ));

    // Hero Section Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default' => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image_control', array(
        'label' => __('Hero Section Background Image', 'mytheme'),
        'section' => 'hero_section',
        'settings' => 'hero_background_image',
    )));
}
add_action('customize_register', 'mytheme_customize_register');


