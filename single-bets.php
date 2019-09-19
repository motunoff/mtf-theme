<?php get_header() ?>

	<!-- .main-container -->
	<div class="main-container">

		<div class="container">
			
			
			<?php if ( have_posts() ) : ?>
				
				<?php while ( have_posts() ) : the_post(); ?>


					<div class="main-content">

						<div class="post-content">
							
							
							<?php the_content(); ?>


						</div>

						<div class="bet-status">
							<span>Статус:</span><strong><?php echo $post->post_status ?></strong>
						</div>

 
						<form id="set-bet-vote" name="set_bet_vote" action="#" method="post" enctype="multipart/form-data" data-bet-id="<?php the_ID() ?>">
							
							
							<?php wp_nonce_field( 'set-bet-vote-action', 'set-bet-vote-security' ); ?>


							<fieldset>
								<input type="number" id="bet-vote" name="bet_vote" class="field" min="100" max="1000" required>
							</fieldset>

							<button type="submit" id="submit-set-vote">Ставка пройдет!</button>

							<div class="result"></div>

						</form>

					</div>
				
				
				<?php endwhile; ?>
			
			<?php endif; ?>


		</div>

	</div>
	<!-- end .main-container -->


<?php get_footer() ?>