<?php
/**
 * Defines the UCF Audience Taxonomy
 */
if ( ! class_exists( 'UCF_Audience_Taxonomy' ) ) {
	/**
	 * Class that is used to add the Audience taxonomy
	 * to WordPress.
	 * @author Jim Barnes
	 * @since 1.0.0
	 */
	class UCF_Audience_Taxonomy {
		private static
			/**
			 * @var array The array of default labels.
			 */
			$label_defaults = array(
				'singular' => 'Audience',
				'plural'   => 'Audiences',
				'slug'     => 'audience'
			),
			/**
			 * @var array The array of default post types to assign the tax to.
			 */
			$post_type_defaults = array();

		/**
		 * Registers the audience taxonomy
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return void
		 */
		public static function register() {
			/**
			 * Filter for modifying the default label parts
			 * @author Jim Barnes
			 * @since 1.0.0
			 * @param array The default label array. Includes:
			 * 					* singular | default Audience
			 * 					* plural   | default Audiences
			 * 					* slug     | default audience
			 * @return array
			 */
			$labels = apply_filters(
				'ucf_audience_label_defaults',
				self::$label_defaults
			);

			/**
			 * Filter for modifying the default post types
			 * the taxonomy will be added to.
			 * @author Jim Barnes
			 * @since 1.0.0
			 * @param array The default array of post types. Defaults empty.
			 * @return array
			 */
			$post_types = apply_filters(
				'ucf_audience_post_types',
				self::$post_type_defaults
			);

			register_taxonomy( 'audience', $post_types, self::args( $labels ) );
		}

		public static function labels( $labels ) {
			$singular = self::label_or_default( $labels, 'singular' );
			$plural   = self::label_or_default( $labels, 'plural' );
			$slug     = self::label_or_default( $labels, 'slug' );

			$plural_lower = strtolower( $plural );

			$retval = array(
				'name'                      => _x( $plural, 'Taxonomy General Name', $slug ),
				'singular_name'             => _x( $singular, 'Taxonomy Singular Name', $slug ),
				'menu_name'                 => __( $plural, $slug ),
				'all_items'                 => __( "All $plural", $slug ),
				'parent_item'               => __( "Parent $singular", $slug ),
				'parent_item_colon'         => __( "Parent $singular: ", $slug ),
				'new_item_name'             => __( "New $singular", $slug ),
				'add_new_item'              => __( "Add New $singular", $slug ),
				'edit_item'                 => __( "Edit $singular", $slug ),
				'update_item'               => __( "Update $singular", $slug ),
				'view_item'                 => __( "View $singular", $slug ),
				'separate_items_with_comma' => __( "Separate $plural_lower with commas", $slug ),
				'add_or_remove_items'       => __( "Add or remove $plural_lower", $slug ),
				'choose_from_most_used'     => __( "Choose from most used $plural_lower", $slug ),
				'popular_items'             => __( "Popular $plural_lower", $slug ),
				'search_items'              => __( "Search $plural", $slug ),
				'not_found'                 => __( 'Not Found', $slug ),
				'no_terms'                  => __( 'No Items', $slug ),
				'items_list'                => __( "$plural list", $slug ),
				'items_list_navigation'     => __( "$plural list navigation", $slug )
			);

			/**
			 * Filter allows the labels array to be overriden
			 * @author Jim Barnes
			 * @since 1.0.0
			 * @param array $retval The array to be modified
			 * @param array $labels The labels array which includes (if
			 * 						not modified in an earler filter):
			 * 						* singular | default Audience
			 * 						* plural   | default Audiences
			 * 						* slug     | default audience
			 * @return array
			 */
			$retval = apply_filters( 'ucf_audience_labels', $retval, $labels );

			return $retval;
		}

		/**
		 * Generates the the args used to register the taxonomy
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $labels The array of labels to use
		 * @return array
		 */
		public static function args( $labels ) {
			$singular = self::label_or_default( $labels, 'singular' );
			$plural   = self::label_or_default( $labels, 'plural' );
			$slug     = self::label_or_default( $labels, 'slug' );

			$args = array(
				'labels'            => self::labels( $labels ),
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => false,
				'show_tagcloud'     => false,
				'rewrite'           => array(
					'slug'         => $slug,
					'hierarchical' => true,
					'ep_mask'      => EP_PERMALINK | EP_PAGES
				)
			);

			/**
			 * Filter allow arguments to be overridden
			 * @author Jim Barnes
			 * @since 1.0.0
			 * @param array $args The array to be modified
			 * @param array $labels The labels array which includes (if
			 * 						not modified in an earler filter):
			 * 						* singular | default Audience
			 * 						* plural   | default Audiences
			 * 						* slug     | default audience
			 * @return array
			 */
			$args = apply_filters( 'ucf_audience_args', $args, $labels );

			return $args;
		}

		/**
		 * Helper function to get the label or default
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param string $label The key of the label to retrieve.
		 * @return string
		 */
		private static function label_or_default( $labels, $key ) {
			if ( isset( $labels[$key] ) && ! empty( $labels[$key] ) ) {
				return $labels[$key];
			}

			if ( isset( self::$label_defaults[$key] ) && ! empty( self::$label_defaults[$key] ) ) {
				return self::$label_defaults[$key];
			}

			return '';
		}
	}
}
