<?php get_header(); ?>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="ui container" style="margin-top: 3em; margin-bottom: 3em;">

    <!-- Hero Section -->
    <?php

    $hero_image = get_theme_mod('hero_background_image');
    $hero_title = get_theme_mod('hero_title');
    $hero_description = get_theme_mod('hero_description');

    // Default to blog title and description if not set
    if (empty($hero_title)) {
        $hero_title = get_bloginfo('name');
    }
    if (empty($hero_description)) {
        $hero_description = get_bloginfo('description');
    }

    if ($hero_image) : ?>
        <div class="ui vertical masthead center aligned segment" style="background-image: url('<?php echo esc_url($hero_image); ?>'); background-size: cover; background-position: center; height: 500px; position: relative; color: white;">
            <div class="ui text container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
                <?php if ($hero_title) : ?>
                    <h1 class="ui inverted header"><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>
                <?php if ($hero_description) : ?>
                    <p class="ui inverted large text"><?php echo esc_html($hero_description); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>


    <?php if (!$hero_image && ($hero_title || $hero_description)) : ?>
        <div class="ui vertical segment">
            <div class="ui container">
                <div class="ui stackable center aligned grid">
                    <div class="column">
                        <?php if ($hero_title) : ?>
                            <h1 class="ui header"><?php echo esc_html($hero_title); ?></h1>
                        <?php endif; ?>
                        <?php if ($hero_description) : ?>
                            <p class="ui large text"><?php echo esc_html($hero_description); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <div class="ui vertical segment">
        <div class="ui container">
            <div class="ui stackable three column grid">
                <?php
                $categories = get_categories();
                foreach ($categories as $category) {
                    echo '
                    <div class="column">
                        <div class="ui segment">
                            <a href="' . esc_url(get_category_link($category->term_id)) . '" class="ui fluid primary button">
                                ' . esc_html($category->name) . '
                            </a>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>


    <div class="ui vertical segment">
        <div class="ui container">
            <h2 class="ui header">Explore Pages</h2>
            <div class="ui stackable three column grid">
                <?php
                $pages = get_pages();
                foreach ($pages as $page) {
                    echo '
                    <div class="column">
                        <div class="ui segment">
                            <a href="' . esc_url(get_page_link($page->ID)) . '" class="ui fluid secondary button">
                                <i class="icon file alternate"></i> ' . esc_html($page->post_title) . '
                            </a>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>

</div>

<?php get_footer(); ?>
