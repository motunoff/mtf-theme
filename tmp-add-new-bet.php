<?php
/*
  Template Name: Новая ставка
*/


get_header(); ?>


<!-- .main-container -->
<div class="main-container">

	<div class="container">
		
		
		<?php if ( have_posts() ) : ?>
		
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php if ( is_user_logged_in() ): ?>


					<h1><?php the_title() ?></h1>


					<form id="add-new-bet" name="add_new_bet" action="#" method="post" enctype="multipart/form-data">
						
						<?php wp_nonce_field( 'new-bet-action', 'new-bet-security' ); ?>

						<fieldset>
							<label for="bet-title">Заголовок</label>
							<input type="text" id="bet-title" class="field" name="bet_title">
						</fieldset>

						<fieldset>
							<label for="bet-content">Описание</label>
							<textarea id="bet-content" class="field" name="bet_content" rows="5"></textarea>
						</fieldset>

						<fieldset>
							<label for="bet-type">Тип ставки</label>
							
							
							<?php
							
							$terms = get_terms( [
								'taxonomy'   => 'bets_type',
								'hide_empty' => FALSE,
							] );
							
							
							if ( $terms && ! is_wp_error( $terms ) ) {
								
								echo "<select id='bet-type' name='bet_type' class='field'   >";
								
								echo "<option value=''>Выберите тип ставки</option>";
								
								foreach ( $terms as $term ) {
									
									echo "<option value='$term->term_id'>" . $term->name . "</option>";
								}
								
								echo "</select>";
							}
							
							?>


						</fieldset>

						<button type="submit" id="submit-new-bet">отправить</button>

						<div class="result"></div>

					</form>
				
				<?php else: ?>


					<h1>Вы должны быть авторизованы для просмотра формы</h1>
				
				
				<?php endif; ?>
			
			<?php endwhile; ?>
		
		<?php endif; ?>

		 
	</div>

</div>
<!-- end .main-container -->

<?php get_footer(); ?>
