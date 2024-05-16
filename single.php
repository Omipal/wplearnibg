<?php 
/**
 * The template for displaying all single posts
 */
get_header();
?>
<!-- Main -->
<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-8 col-12-medium">
                <?php 
                    if(have_posts()){
                        while(have_posts()){
                            the_post(); ?>
                    <article class="box post">
                    <a href="<?php the_permalink(); ?>" class="image featured">
						<?php the_post_thumbnail('single-post'); ?></a>
                        <header>
                            <h2><?php the_title(); ?></h2>
                            <?php the_content(); ?>
                        </header>
                    </article>
                           
                        <?php }
                    }
                ?>

                </div>
           <?php get_sidebar(); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>