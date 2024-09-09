<article id="post-<?php the_ID(); ?>" <?php post_class('post-article ui segment'); ?> style="margin-bottom: 2rem; padding: 1.5rem;">
    <header class="entry-header ui header" style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e5e5;">
        <?php the_title(sprintf('<h1 class="entry-title" style="font-size: 2.5rem; font-weight: 700; line-height: 1.3; margin-bottom: 0.5rem; color: #333;"><a href="%s" style="color: #6aff40; text-decoration: none;" rel="bookmark">', esc_url(get_permalink())), '</a></h1>'); ?>
        <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished" class="date" style="font-size: 0.875rem; color: #888;"><?php echo get_the_date(); ?></time>
    </header>

    <div class="entry-content" style="font-size: 1.125rem; line-height: 1.8; color: #555;">
        <?php the_content(); ?>
    </div>

    <!-- Display category list -->
    <div class="entry-categories ui segment" style="margin-top: 2rem; padding-top: 1rem;">
        <?php
        $categories = get_the_category();
        if (!empty($categories)) {
            echo '<div class="ui labels">';
            foreach ($categories as $category) {
                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="ui label" style="background-color: #2c3e50; color: #6aff40;">' . esc_html($category->name) . '</a>';
            }
            echo '</div>';
        }
        ?>
    </div>

    <!-- Display related posts -->
    <?php
    $current_post_id = get_the_ID();
    $current_post_category = get_the_category($current_post_id);
    $current_post_category_id = $current_post_category[0]->term_id;

    $related_posts_args = [
        'post_type' => 'post',
        'posts_per_page' => 5,
        'post__not_in' => [$current_post_id],
        'cat' => $current_post_category_id,
    ];

    $related_posts_query = new WP_Query($related_posts_args);

    if ($related_posts_query->have_posts()) :
    ?>
        <div class="related-posts ui segment" style="margin-top: 3rem;">
            <h3 class="ui header" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: #333;">Related Posts</h3>
            <div class="ui relaxed list">
                <?php while ($related_posts_query->have_posts()) : $related_posts_query->the_post(); ?>
                    <div class="item">
                        <a href="<?php the_permalink(); ?>" class="header" style="font-size: 1.125rem; color: #3b5998;"><?php the_title(); ?></a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        wp_reset_postdata();
    endif;
    ?>
</article>
