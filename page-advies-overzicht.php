<?php
/*
Template Name: Advies Overzicht
*/

get_header(); ?>

<div class="mc-advies-wrapper" style="max-width:1200px;margin:0 auto;padding:40px 20px;">

    <header class="mc-advies-header">
        <h1><?php the_title(); ?></h1>
        <?php if ( ! empty( get_the_content() ) ) : ?>
            <div class="mc-advies-intro">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php
    // PAS HIERONDER ALLEEN AAN ALS JE SLUG ANDERS IS
    $advies_query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => 10,            // aantal berichten per pagina
        'paged'          => get_query_var( 'paged' ) ?: 1,
        'category_name'  => 'advies',      // <-- slug van jouw categorie
    ) );
    ?>

    <?php if ( $advies_query->have_posts() ) : ?>

        <div class="mc-advies-grid">
            <?php while ( $advies_query->have_posts() ) : $advies_query->the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('mc-advies-item'); ?>>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" class="mc-advies-thumb">
                            <?php the_post_thumbnail('large'); ?>
                        </a>
                    <?php endif; ?>

                    <div class="mc-advies-content">
                        <span class="mc-advies-date">
                            <?php echo get_the_date('d.m.y'); ?>
                        </span>

                        <h2 class="mc-advies-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <div class="mc-advies-excerpt">
                            <?php the_excerpt(); ?>
                        </div>

                        <a class="mc-advies-readmore" href="<?php the_permalink(); ?>">
                            Lees meer
                        </a>
                    </div>

                </article>

            <?php endwhile; ?>
        </div>

        <div class="mc-advies-pagination">
            <?php
            echo paginate_links( array(
                'total'   => $advies_query->max_num_pages,
                'current' => max( 1, get_query_var('paged') ),
            ) );
            ?>
        </div>

        <?php wp_reset_postdata(); ?>

    <?php else : ?>

        <p>Er zijn nog geen adviesartikelen geplaatst.</p>

    <?php endif; ?>

</div>

<?php get_footer();
