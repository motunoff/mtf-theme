<?php get_header() ?>


<!-- .page-content -->
<div class="main-container">

	<div class="container">
		<?php if ( have_posts() ) : ?>
			
			<?php while ( have_posts() ) : the_post(); ?>


				<div class="main-content">

					<div class="post-content">


						<h1><?php the_title(); ?></h1>
						
						<?php the_content(); ?>

					</div>
					
				</div>
			
			<?php endwhile; ?>
		
		<?php endif; ?>
	</div>

</div>
<!-- end .main-container -->


<?php get_footer() ?>
