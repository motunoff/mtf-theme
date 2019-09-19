<?php

/**
 *
 * Core theme functions
 *
 * @since 1.0.0
 *
 */


if ( ! function_exists( 'add_theme_style' ) ) {
	
	function add_theme_style() {
		
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		
	}
	
	
	add_action( 'get_footer', 'add_theme_style', 100 );
	
} // end add_theme_style()


if ( ! function_exists( 'add_theme_scripts' ) ) {
	
	function add_theme_scripts() {
		
		wp_deregister_script( 'jquery' );
		
		wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', FALSE, NULL, FALSE );
		
		wp_localize_script( 'main', 'theme_options',
			[
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			
			] );
		
	}
	
	
	add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );
	
} // end add_theme_scripts()


if ( ! function_exists( 'text_trim_latin_chars' ) ) {
	
	function text_trim_latin_chars( $text ) {
		
		return preg_replace( '/[a-zA-Z]/', '', $text );
	}
	
	
	add_filter( 'trim_latin_chars', 'text_trim_latin_chars' );
	
}// end text_trim_latin_chars()


if ( ! function_exists( 'post_new_bet' ) ) {
	
	
	function post_new_bet() {
		
		check_ajax_referer( 'new-bet-action', 'security' );
		
		$bet_title = sanitize_text_field( $_POST[ 'bet_title' ] );
		
		$bet_content = sanitize_text_field( $_POST[ 'bet_content' ] );
		
		// uncomment line below to trim all latin chars from $bet_content 
		//$bet_content = apply_filters( 'trim_latin_chars', $bet_content );
		
		$post_data = [
			'post_title'   => $bet_title,
			'post_content' => $bet_content,
			'post_status'  => 'pending',
			'post_author'  => 1,
			'post_type'    => 'bets',
		
		];
		
		// insert bet in db
		$post_id = wp_insert_post( $post_data, TRUE );
		
		if ( $post_id ) {
			
			/* 
			* if success in adding new bet
			* set bet term
			*/
			
			$term = wp_set_object_terms( $post_id, (int) $_POST[ 'bet_type' ], 'bets_type' );
			
			if ( $term ) {
				
				echo json_encode( [ 'msg' => 'Ваша ставка успешно добавлена' ] );
				
			} else {
				
				echo json_encode( [ 'msg' => 'Произошла ошибка' ] );
			}
			
		} else {
			
			//if is error in insert new bet, show error
			echo json_encode( [ 'msg' => 'Произошла ошибка ' . $post_id->get_error_message() ] );
			
		}
		
		
		die();
	}
	
	
	add_action( 'wp_ajax_add_new_bet', 'post_new_bet' );
	add_action( 'wp_ajax_nopriv_add_new_bet', 'post_new_bet' );
	
} // end add_theme_scripts()


if ( ! function_exists( 'write_bet_vote' ) ) {
	
	function write_bet_vote() {
		
		check_ajax_referer( 'set-bet-vote-action', 'security' );
		
		$result = update_post_meta( (int) $_POST[ 'bet_id' ], 'bet_vote', $_POST[ 'bet_vote' ] );
		
		if ( $result ) {
			
			echo json_encode( [ 'msg' => 'Вы сделали ставку' ] );
			
		} else {
			
			echo json_encode( [ 'msg' => 'Произошла ошибка' ] );
		}
		
		die();
	}
	
	
	add_action( 'wp_ajax_set_bet_vote', 'write_bet_vote' );
	add_action( 'wp_ajax_nopriv_set_bet_vote', 'write_bet_vote' );
	
} // end write_bet_vote()