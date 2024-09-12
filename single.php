<?php get_header(); ?>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="ui container">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('ui segment padded very'); ?> style="background-color: #ffffff; border-radius: 8px;">
                <header class="entry-header">
                    <h1 class="ui header">
                        <?php the_title(); ?>
                        <div class="sub header">
                            <i class="calendar alternate outline icon"></i>
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                        </div>
                    </h1>
                </header>

                <div class="entry-content">
                    <?php
                    // Display content
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Pages:', 'minimalflow'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer ui divider" style="margin-top: 3em; height: auto;" ;">
                    <div class="ui horizontal list">
                        <div class="item">
                            <i class="folder open outline icon"></i>
                            <?php the_category(', '); ?>
                        </div>
                        <div class="item">
                            <i class="tag icon"></i>
                            <?php the_tags('', ', ', ''); ?>
                        </div>
                    </div>
                </footer>
            </article>

            <!-- Related Posts -->
            <?php
            $current_post_id = get_the_ID();
            $current_post_category = get_the_category($current_post_id);
            $current_post_category_id = isset($current_post_category[0]) ? $current_post_category[0]->term_id : 0;

            $related_posts_args = [
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post__not_in' => [$current_post_id],
                'cat' => $current_post_category_id,
            ];

            $related_posts_query = new WP_Query($related_posts_args);

            if ($related_posts_query->have_posts()) : ?>
                <div class="ui segment" style="margin-top: 3em;">
                    <h3 class="ui header">Related Posts</h3>
                    <div class="ui divided items">
                        <?php while ($related_posts_query->have_posts()) : $related_posts_query->the_post(); ?>
                            <div class="item">
                                <div class="content">
                                    <a class="header" href="<?php echo esc_url(get_permalink()); ?>" style="font-size: 1.2rem;"><?php the_title(); ?></a>
                                    <div class="meta">
                                        <span><i class="calendar outline icon"></i> <?php echo esc_html(get_the_date()); ?></span>
                                    </div>
                                    <div class="description">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
