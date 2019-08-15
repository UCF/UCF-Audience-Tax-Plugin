<?php
/**
 * A collection of shortcodes for displaying
 * content based on audience.
 */
if ( ! class_exists( 'UCF_Audience_Shortcodes' ) ) {
	/**
	 * Static class that contains shortcodes
	 * that take advantage of the audience taxonomy.
	 * @author Jim Barnes
	 * @since 1.0.0
	 */
	class UCF_Audience_Shortcodes {
		/**
		 * Convenience function for registering all shortcodes
		 * at once.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return void
		 */
		public static function add_shortcodes() {
			add_shortcode( 'if-audience', array( self, 'sc_if_audience' ) );
		}

		/**
		 * Shortcode callback that displays inner content
		 * based on if the audience provided is present.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $args The shortcode args.
		 * @param string $content The content to be displayed.
		 * @return string
		 */
		public static function sc_if_audience( $atts, $content='' ) {
			$atts = shortcode_atts(
				array(
					'audiences' => array( 'all' )
				),
				$atts
			);

			$audiences = $atts['audiences'];

			if ( ! is_array( $audiences ) ) {
				/**
				 * If the variable isn't an array, split the string
				 * by commas and trim each value.
				 */
				$audience = array_map( function( $aud ) {
					return trim( $aud );
				}, explode( ',', $audiences ) );
			}

			$usr_audience = UCF_Audience_Common::get_usr_audience();

			if ( UCF_Audience_Common::is_matching_audience( $audiences, $usr_audience ) ) {
				return $content;
			}

			return '';
		}
	}
}
