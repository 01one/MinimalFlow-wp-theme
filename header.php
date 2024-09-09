<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    if (is_single()) {
        $meta_description = get_post_meta(get_the_ID(), 'meta_description', true);
        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">';
        } else {
            echo '<meta name="description" content="' . esc_attr(get_the_title()) . '">';
        }
    }
    ?>

    <title><?php wp_title(); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- Semantic UI Navbar -->
<header>
    <div class="ui menu">
        <div class="ui container">
             <a class="header item" href="<?php echo home_url('/'); ?>"><?php echo get_bloginfo('name'); ?></a>

            <div class="right menu">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'parent'  => 0
                ));

                $main_categories = [];
                $sub_categories = [];

                foreach ($categories as $category) {
                    $children = get_categories(array(
                        'child_of' => $category->term_id,
                        'hide_empty' => 0
                    ));
                    if (count($children) > 0) {
                        $main_categories[$category->term_id] = $category;
                    } else {
                        $sub_categories[] = $category;
                    }
                }

                // Display main categories (with most subcategories)
                foreach ($main_categories as $category) {
                    echo '<div class="ui simple dropdown item">';
                    echo $category->name . ' <i class="dropdown icon"></i>';
                    echo '<div class="menu">';
                    
                    // Display subcategories under each main category
                    $children = get_categories(array(
                        'child_of' => $category->term_id,
                        'hide_empty' => 0
                    ));
                    foreach ($children as $child) {
                        echo '<a class="item" href="' . get_category_link($child->term_id) . '">' . $child->name . '</a>';
                    }

                    echo '</div>';
                    echo '</div>';
                }

                // Display remaining categories as individual menu items
                if (!empty($sub_categories)) {
                    echo '<div class="ui simple dropdown item">';
                    echo 'More <i class="dropdown icon"></i>';
                    echo '<div class="menu">';
                    foreach ($sub_categories as $category) {
                        echo '<a class="item" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                ?>
                
                <div class="item">
                    <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="ui action input">
                        <input type="text" name="s" placeholder="Search..." value="<?php echo get_search_query(); ?>">
                        <button class="ui button" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
