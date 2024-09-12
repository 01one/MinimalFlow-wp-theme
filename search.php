<?php get_header(); ?>

<div class="ui container" style="margin-top: 2em;">

    <?php if ( have_posts() ) : ?>

        <header class="ui header">
            <h1 class="ui header">
                <?php printf( esc_html__( 'Search Results for: %s', 'minimalflow' ), '<span>' . get_search_query() . '</span>' ); ?>
            </h1>
        </header>

        <div class="ui divided items">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="item">
                    <div class="content">
                        <header class="header">
                            <h2 class="ui header"><a href="<?php the_permalink(); ?>" class="ui header"><?php the_title(); ?></a></h2>
                        </header>
                        <div class="description">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    <?php else : ?>

        <header class="ui header">
            <h1 class="ui header"><?php esc_html_e( 'Nothing Found', 'minimalflow' ); ?></h1>
        </header>
        <div class="ui message">
            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'minimalflow' ); ?></p>
            <?php get_search_form(); ?>
        </div>

    <?php endif; ?>

</div>

<?php get_footer(); ?>
