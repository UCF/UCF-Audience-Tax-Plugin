<?php
/**
 * Admin scripts
 */
if ( ! class_exists( 'UCF_Audience_Admin' ) ) {
	class UCF_Audience_Admin {
		/**
		 * All admin scripts and styles are enqueued here.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return void
		 */
		public static function admin_enqueue_scripts() {
			wp_register_script( 'ucf_audience_admin_script', UCF_AUDIENCE__JS_URL . '/admin-script.min.js', array( 'jquery' ), UCF_AUDIENCE__VERSION, true );

			$translation_array = array(
				'wpse_link_audience' => self::get_audience_field_markup()
			);

			wp_localize_script( 'ucf_audience_admin_script', 'UCF_AUDIENCE', $translation_array );

			wp_enqueue_script( 'ucf_audience_admin_script' );
		}

		/**
		 * Helper function for create audience select dropdown
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return string
		 */
		private static function get_audience_field_markup() {
			$audiences = self::get_audiences_as_options();
			ob_start();
		?>
			<div>
				<label>Select Audience</label>
				<select name="wpse-link-audience" id="wpse-link-audience">
					<option value=''>--- None ---</option>
				<?php foreach( $audiences as $key => $val ) : ?>
					<option value='<?php echo $key; ?>'><?php echo $val; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
		<?php
			return ob_get_clean();
		}

		/**
		 * Returns audiences as slug=>name array
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return array
		 */
		private static function get_audiences_as_options() {
			$all_audiences = get_terms( array(
				'taxonomy'   => 'audience',
				'hide_empty' => false
			) );

			$retval = array();

			foreach( $all_audiences as $audience ) {
				$retval[$audience->slug] = $audience->name;
			}

			return $retval;
		}
	}
}
