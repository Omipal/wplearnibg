<?php get_header(); ?>
<?php dynamic_sidebar('home-banner'); ?>
<!-- Intro -->
<?php dynamic_sidebar('home-services'); ?>

<section id="main">
<div class="container">
<div class="row">
	<div class="col-12">

		<!-- Portfolio -->
			<section>
				<header class="major">
					<h2>My Portfolio</h2>
				</header>
				<div class="row">
				<?php 
					$portfolio_args = array(
						'post_type' => 'portfolio',
						'posts_per_page' => 6
					);
					$portfolio_posts = new WP_Query($portfolio_args);
					if ( $portfolio_posts->have_posts() ) :
						while ( $portfolio_posts->have_posts() ) : $portfolio_posts->the_post(); ?>
					<div class="col-4 col-6-medium col-12-small">
						<section class="box">
						<a href="<?php the_permalink(); ?>" class="image featured">
						<?php the_post_thumbnail('home-featured'); ?></a>
							
							<header>
								<h3><?php the_title(); ?></h3>
							</header>
							<?php the_excerpt(); ?>
							<footer>
								<ul class="actions">
									<li><a href="<?php the_permalink(); ?>" class="button alt">Find out more</a></li>
								</ul>
							</footer>
						</section>
					</div>
			<?php endwhile; 
					endif; ?>
    		<?php wp_reset_postdata(); ?>
		</div>
		</section>
	</div>
	<div class="col-12">

		<!-- Blog -->
			<section>
				<header class="major">
					<h2>The Blog</h2>
				</header>
				<div class="row">
					<?php 
					$blog_args = array(
						'post_type' => 'post',
						'posts_per_page' => 2
					);
					$blog_posts = new WP_Query($blog_args);
					if ( $blog_posts->have_posts() ) :
						while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
					<div class="col-6 col-12-small">
						<section class="box">
							<a href="<?php the_permalink(); ?>" class="image featured">
						<?php the_post_thumbnail('home-featured'); ?></a>
							<header>
								<h3><?php the_title(); ?></h3>
								<p>Posted on <?php the_date(); ?> at <?php the_time(); ?></p>
							</header>
							<?php the_excerpt(); ?>
							<footer>
								<ul class="actions">
									<li><a href="<?php the_permalink(); ?>" class="button icon solid fa-file-alt">Continue Reading</a></li>
									<li><a href="<?php comments_link(); ?>" class="button alt icon solid fa-comment"><?php echo get_comments_number(); ?></a></li>
								</ul>
							</footer>
						</section>
					</div>
			<?php endwhile; 
					endif; ?>
    		<?php wp_reset_postdata(); ?>
		</div>
			</section>

	</div>
	<div class="col-12">
	<section>
	<header class="major">
		<h2>Fillter Category</h2>
	</header>
	<div class="row margin-bottom">
	<div class="col-12">
		<div class="category-filter">
			<?php $categories = get_categories() ?>
				<form action="<?php echo site_url(); ?>/wp-admin/admin-ajax.php" method="POST" id="filter" class="flex">
					<select name="category" class="categories">
						<?php
							foreach ($categories as $category) { ?>
							<option value="<?php echo $category->term_id ?>"><?php echo $category->cat_name ?></option>
							<?php 
							}
						?>
					</select>
					<input type="hidden" name="action" value="myfilter">
					<button id="filter-cats">Apply Filter</button>			
				</form>
		</div>
		</div>
		</div>
		<div class="row grid-container">
			<?php 
			$ajaxPosts = new WP_Query([
				'post_type' => 'post',
				'posts_per_page' => 3,
				'order_by' => 'date',
				'order' => 'desc'
			]);

			if($ajaxPosts->have_posts()):
				while($ajaxPosts->have_posts()): $ajaxPosts->the_post(); 
				?>
			<div class="col-4 col-6-medium col-12-small">
				<section class="box">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('single-post'); ?></a>
				<header>
					<h3><?php the_title(); ?></h3>
				</header>
				<span class="posts-cats">
					<?php the_terms(get_the_ID(), 'category', 'Categories: ', '/'); ?>
				</span>
				<?php the_content(); ?>				
				</section>
			</div>
				<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>

		</div>
	
	
	</section>
</div>
</div>
</div>
</section>
<script>
	jQuery(document).ready(function(){
		jQuery('#filter-cats').click(function(){
			let filter = jQuery('#filter');

			jQuery.ajax({
				url:filter.attr("action"),
				data: filter.serialize(),
				type: filter.attr("method"),
				beforeSend: function(xhr){
					filter.find("button").text("Procesing...");
					
				},
				success: function(data){
					
					filter.find("button").text("Applay Filter");
					jQuery(".grid-container").html(data);
				}
			});
			return false;
		})
	})
</script>

<?php get_footer(); ?>
