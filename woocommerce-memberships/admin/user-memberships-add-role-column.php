<?php // only copy if needed!


/**
 * Add a role column to the user memberships list.
 *
 * @param array $columns the list table columns
 * @return array
 */
add_filter( 'manage_edit-wc_user_membership_columns', function( $columns ) {

		$role_column = array( 'role' => __( 'Role', 'my-textdomain' ) );

		if ( isset( $columns['title'] ) ) {
			$columns = sv_wc_array_insert_after( $columns, 'title', $role_column );
		} else {
			$columns = array_merge( $columns, $role_column );
		}

		return $columns;
}, 20 );


/**
 * Add content to the role column in the user memberships list.
 *
 * @param string $column the column slug
 * @param int $user_membership_id the user membership ID (post ID)
 */
add_action( 'manage_wc_user_membership_posts_custom_column', function( $column, $user_membership_id ) {

	if ( 'role' === $column ) {

		$user_id = get_post_field( 'post_author', $user_membership_id );
		$user    = get_userdata( $user_id );

		if ( $user ) {
			echo implode( ', ', $user->roles );
		} else {
			echo '&ndash;';
		}
	}

}, 20, 2 );


if ( ! function_exists( 'sv_wc_array_insert_after' ) ) :

	/**
	 * Insert the given element after the given key in the array
	 *
	 * Sample usage:
	 * array( 'item_1' => 'foo', 'item_2' => 'bar' )
	 *
	 * array_insert_after( $array, 'item_1', array( 'item_1.5' => 'w00t' ) )
	 *
	 * becomes
	 * array( 'item_1' => 'foo', 'item_1.5' => 'w00t', 'item_2' => 'bar' )
	 *
	 * @param array $array array to insert the given element into
	 * @param string $insert_key key to insert given element after
	 * @param array $element element to insert into array
	 * @return array
	 */
	function sv_wc_array_insert_after( Array $array, $insert_key, Array $element ) {

		$new_array = array();

		foreach ( $array as $key => $value ) {

			$new_array[ $key ] = $value;

			if ( $insert_key == $key ) {

				foreach ( $element as $k => $v ) {
					$new_array[ $k ] = $v;
				}
			}
		}

		return $new_array;
	}

endif;
