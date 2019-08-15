<?php
/**
 * Common utility functions
 */
if ( ! class_exists( 'UCF_Audience_Common' ) ) {
	class UCF_Audience_Common {
		/**
		 * Gets an array of audience terms.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return array
		 */
		public static function get_audience_term_slugs( $args ) {
			$args = shortcode_atts( array(
				'hide_empty' => false,
				'fields'     => 'id=>slug'
			), $args );

			$args['taxonomy'] = 'audience';

			return get_terms( $args );
		}

		/**
		 * Determines if the current user is in the audiences array
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $audiences An array of audiences to match against
		 * @param string|null The user audience to check
		 * @return bool
		 */
		public static function is_matching_audience( $audiences, $usr_audience = null ) {
			if ( ! $usr_audience ) {
				$usr_audience = self::get_usr_audience();
			}

			if ( in_array( $usr_audience, $audiences ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Creates default audiences
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return void
		 */
		public static function add_default_terms() {
			wp_insert_term(
				'All',
				'audience',
				array(
					'description' => 'Used when content should be displayed to all audiences.',
					'slug'        => 'all'
				)
			);

			wp_insert_term(
				'Not Set',
				'audience',
				array(
					'description' => 'Used when the user\'s audience is not set.',
					'slug'        => 'not-set'
				)
			);
		}

		/**
		 * Determines if the audience passed in is valid.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param string $audience The slug of the audience being checked.
		 * @return bool
		 */
		private static function is_valid_audience( $audience ) {
			if ( in_array( $audience, array_values( self::get_audience_term_slugs() ) ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Returns the user's audience value.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return string
		 */
		private static function get_usr_audience() {
			$usr_audience = 'not-set';

			if ( isset( $_GET['audience'] ) && ! empty( $_GET['audience'] ) ) {
				$usr_audience = $_GET['audience'];
			} else if ( isset( $_COOKIE['ucf_audience'] ) && ! empty( $_COOKIE['ucf_audience'] ) ) {
				$usr_audience = $_COOKIE['ucf_audience'];
			}

			if ( self::is_valid_audience( $usr_audience ) ) {
				return $usr_audience;
			} else {
				$usr_audience = 'not-set';
			}

			return $usr_audience;
		}
	}
}
