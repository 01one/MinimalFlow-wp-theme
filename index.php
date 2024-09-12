<?php
get_header();

function enqueue_custom_styles_and_scripts() {
    // Enqueue your custom styles and scripts here
    // Example:
    // wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom-style.css');
    // wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles_and_scripts');
?>

<main class="ui container" style="margin-top: 5rem;">
    <?php
    if (is_page()) {
        while (have_posts()) : the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('ui segment'); ?> style="margin-bottom: 2rem;">
            <header class="entry-header ui header" style="margin-bottom: 1.5rem;">
                <?php the_title( sprintf( '<h1 class="entry-title" style="font-size: 2.5rem; color: #333;"><a href="%s" rel="bookmark" style="color: #6aff40; text-decoration: none;">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished" class="date" style="font-size: 0.875rem; color: #888;"><?php echo esc_html(get_the_date()); ?></time>
            </header>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php
        endwhile;
    } elseif (is_category() || is_tag()) {
        $term = get_queried_object();
    ?>
        <div class="term-info ui segment" style="margin-bottom: 3rem;">
            <h1 class="ui header" style="font-size: 3rem;"><?php echo esc_html($term->name); ?></h1>
            <div class="term-description" style="margin-bottom: 1.5rem;"><?php echo esc_html($term->description); ?></div>
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => $term->taxonomy,
                        'field' => 'id',
                        'terms' => $term->term_id,
                    ),
                ),
            );
            $term_posts = new WP_Query($args);
            if ($term_posts->have_posts()) :
                while ($term_posts->have_posts()) : $term_posts->the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('ui segment'); ?> style="margin-bottom: 2rem;">
                    <header class="entry-header">
                        <h2 class="ui header" style="font-size: 2rem;"><a href="<?php echo esc_url(get_permalink()); ?>" ><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No posts found</p>';
            endif;
            ?>
        </div>
    <?php
    } elseif (is_search()) {
        get_template_part('search');
    } elseif (is_front_page() || is_home()) {
        include(locate_template('landing-page.php'));
    } else {
    ?>
        <div class="latest-posts ui segment" style="margin-bottom: 3rem;">
            <?php
            $latest_post_query = new WP_Query(array(
                'posts_per_page' => 10,
                'post_status' => 'publish',
            ));

            if ($latest_post_query->have_posts()) :
                while ($latest_post_query->have_posts()) : $latest_post_query->the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('ui segment'); ?> style="margin-bottom: 2rem;">
                    <header class="entry-header">
                        <h2 class="ui header" style="font-size: 2rem;"><a href="<?php echo esc_url(get_permalink()); ?>" ><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No posts found</p>';
            endif;
            ?>
        </div>
    <?php
    }
    ?>
</main>

<?php
get_footer();
?>
