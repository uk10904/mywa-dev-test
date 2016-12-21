<?php
/**
 * Beans Actions extends WordPress Actions by registering each action with a unique ID.
 *
 * While WordPress requires two or three arguments to remove an action, Beans
 * actions can be modified, replaced, removed or reset using only the ID as a reference.
 *
 * @package API\Actions
 */

/**
 * Hooks a function on to a specific action.
 *
 * This function is similar to {@link http://codex.wordpress.org/Function_Reference/add_action add_action()}
 * with the exception of being registered by ID in order to be manipulated by the other Beans Actions functions.
 *
 * @since 1.0.0
 *
 * @param string   $id       A unique string used as a reference.
 * @param string   $hook     The name of the action to which the $callback is hooked.
 * @param callback $callback The name of the function you wish to be called.
 * @param int      $priority Optional. Used to specify the order in which the functions
 *                           associated with a particular action are executed. Default 10.
 *                           Lower numbers correspond with earlier execution,
 *                           and functions with the same priority are executed
 *                           in the order in which they were added to the action.
 * @param int      $args     Optional. The number of arguments the function accepts. Default 1.
 *
 * @return bool Will always return true.
 */
function beans_add_action( $id, $hook, $callback, $priority = 10, $args = 1 ) {

	$action = array(
		'hook'     => $hook,
		'callback' => $callback,
		'priority' => $priority,
		'args'     => $args,
	);

	// Replace original if set.
	if ( $replaced = _beans_get_action( $id, 'replaced' ) ) {
		$action = array_merge( $action, $replaced );
	}

	$action = _beans_set_action( $id, $action, 'added', true );

	// Stop here if removed.
	if ( _beans_get_action( $id, 'removed' ) ) {
		return;
	}

	// Merge modified.
	if ( $modified = _beans_get_action( $id, 'modified' ) ) {
		$action = array_merge( $action, $modified );
	}

	// Validate action arguments.
	if ( count( $action ) == 4 ) {
		add_action( $action['hook'], $action['callback'], $action['priority'], $action['args'] );
	}

	return true;

}

/**
 * Set {@see beans_add_action()} using the callback argument as the action ID.
 *
 * This function is a shortcut of {@see beans_add_action()}. It does't require an ID
 * to be specified and uses the callback argument instead.
 *
 * @since 1.0.0
 *
 * @param string   $hook     The name of the action to which the $callback is hooked.
 * @param callback $callback The name of the function you wish to be called. Used to set the action ID.
 * @param int      $priority Optional. Used to specify the order in which the functions
 *                           associated with a particular action are executed. Default 10.
 *                           Lower numbers correspond with earlier execution,
 *                           and functions with the same priority are executed
 *                           in the order in which they were added to the action.
 * @param int      $args     Optional. The number of arguments the function accept. Default 1.
 *
 * @return bool Will always return true.
 */
function beans_add_smart_action( $hook, $callback, $priority = 10, $args = 1 ) {

	return beans_add_action( $callback, $hook, $callback, $priority, $args );

}

/**
 * Modify an action.
 *
 * This function modifies an action registered using {@see beans_add_action()} or
 * {@see beans_add_smart_action()}. Each optional argument must be set to NULL to keep the orginal value.
 *
 * The original action can be reset using {@see beans_reset_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id         The action ID.
 * @param string $hook       Optional. The name of the new action to which the $callback is hooked.
 *                           Use NULL to keep the original value.
 * @param callback $callback Optional. The name of the new function you wish to be called.
 *                           Use NULL to keep the original value.
 * @param int $priority      Optional. The new priority.
 *                           Use NULL to keep the original value.
 * @param int $args          Optional. The new number of arguments the function accept.
 *                           Use NULL to keep the original value.
 *
 * @return bool Will always return true.
 */
function beans_modify_action( $id, $hook = null, $callback = null, $priority = null, $args = null ) {

	// Remove action.
	if ( $current = _beans_get_current_action( $id ) ) {
		remove_action( $current['hook'], $current['callback'], $current['priority'], $current['args'] );
	}

	$action = array_filter( array(
		'hook'     => $hook,
		'callback' => $callback,
		'priority' => $priority,
		'args'     => $args,
	) );

	// Merge modified.
	$action = _beans_merge_action( $id, $action, 'modified' );

	// Replace if needed.
	if ( $current ) {

		$action = array_merge( $current, $action );

		add_action( $action['hook'], $action['callback'], $action['priority'], $action['args'] );

	}

	return true;

}

/**
 * Modify an action hook.
 *
 * This function is a shortcut of {@see beans_modify_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id   The action ID.
 * @param string $hook Optional. The name of the new action to which the $callback is hooked. Use NULL to
 *                     keep the original value.
 *
 * @return bool Will always return true.
 */
function beans_modify_action_hook( $id, $hook ) {

	return beans_modify_action( $id, $hook );

}

/**
 * Modify an action callback.
 *
 * This function is a shortcut of {@see beans_modify_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id       The action ID.
 * @param string $callback Optional. The name of the new function you wish to be called. Use NULL to keep
 *                         the original value.
 *
 * @return bool Will always return true.
 */
function beans_modify_action_callback( $id, $callback ) {

	return beans_modify_action( $id, null, $callback );

}

/**
 * Modify an action priority.
 *
 * This function is a shortcut of {@see beans_modify_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id    The action ID.
 * @param int $priority Optional. The new priority. Use NULL to keep the original value.
 *
 * @return bool Will always return true.
 */
function beans_modify_action_priority( $id, $callback ) {

	return beans_modify_action( $id, null, null, $callback );

}

/**
 * Modify an action arguments.
 *
 * This function is a shortcut of {@see beans_modify_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id The action ID.
 * @param int $args  Optional. The new number of arguments the function accepts. Use NULL to keep the
 *                   original value.
 *
 * @return bool Will always return true.
 */
function beans_modify_action_arguments( $id, $args ) {

	return beans_modify_action( $id, null, null, null, $args );

}

/**
 * Replace an action.
 *
 * This function replaces an action registered using {@see beans_add_action()} or
 * {@see beans_add_smart_action()}. Each optional argument must be set to NULL to keep
 * the orginal value.
 *
 * While {@see beans_modify_action()} will keep the original value registered, this function
 * will overwrite the original action. If the action is reset using {@see beans_reset_action()},
 * the replaced values will be used.
 *
 * @since 1.0.0
 *
 * @param string $id         The action ID.
 * @param string $hook       Optional. The name of the new action to which the $callback is hooked.
 *                           Use NULL to keep the original value.
 * @param callback $callback Optional. The name of the new function you wish to be called.
 *                           Use NULL to keep the original value.
 * @param int $priority      Optional. The new priority.
 *                           Use NULL to keep the original value.
 * @param int $args          Optional. The new number of arguments the function accepts.
 *                           Use NULL to keep the original value.
 *
 * @return bool Will always return true.
 */
function beans_replace_action( $id, $hook = null, $callback = null, $priority = null, $args = null ) {

	$action = array(
		'hook'     => $hook,
		'callback' => $callback,
		'priority' => $priority,
		'args'     => $args,
	);

	// Set and get the latest replaced.
	$action = _beans_merge_action( $id, array_filter( $action ), 'replaced' );

	// Set and get the latest added.
	$action = _beans_merge_action( $id, $action, 'added' );

	return beans_modify_action( $id, $hook, $callback, $priority, $args );

}

/**
 * Replace an action hook.
 *
 * This function is a shortcut of {@see beans_replace_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id   The action ID.
 * @param string $hook Optional. The name of the new action to which the $callback is hooked. Use NULL to keep
 *                     the original value.
 *
 * @return bool Will always return true.
 */
function beans_replace_action_hook( $id, $hook ) {

	return beans_replace_action( $id, $hook );

}

/**
 * Replace an action callback.
 *
 * This function is a shortcut of {@see beans_replace_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id       The action ID.
 * @param string $callback Optional. The name of the new function you wish to be called. Use NULL to keep
 *                         the original value.
 *
 * @return bool Will always return true.
 */
function beans_replace_action_callback( $id, $callback ) {

	return beans_replace_action( $id, null, $callback );

}

/**
 * Replace an action priority.
 *
 * This function is a shortcut of {@see beans_replace_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id    The action ID.
 * @param int $priority Optional. The new priority. Use NULL to keep the original value.
 *
 * @return bool Will always return true.
 */
function beans_replace_action_priority( $id, $callback ) {

	return beans_replace_action( $id, null, null, $priority );

}

/**
 * Replace an action argument.
 *
 * This function is a shortcut of {@see beans_replace_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id The action ID.
 * @param int $args  Optional. The new number of arguments the function accepts. Use NULL to keep the original
 *                   value.
 *
 * @return bool Will always return true.
 */
function beans_replace_action_arguments( $id, $args ) {

	return beans_replace_action( $id, null, null, null, $args );

}

/**
 * Remove an action.
 *
 * This function removes an action registered using {@see beans_add_action()} or
 * {@see beans_add_smart_action()}. The original action can be re-added using {@see beans_reset_action()}.
 *
 * @since 1.0.0
 *
 * @param string $id The action ID.
 *
 * @return bool Will always return true.
 */
function beans_remove_action( $id ) {

	// Remove.
	if ( $action = _beans_get_current_action( $id ) ) {
		remove_action( $action['hook'], $action['callback'], $action['priority'], $action['args'] );
	}

	// Register as removed.
	_beans_set_action( $id, $action, 'removed' );

	return true;

}

/**
 * Reset an action.
 *
 * This function resets an action registered using {@see beans_add_action()} or
 * {@see beans_add_smart_action()}. If the original values were replaced using
 * {@see beans_replace_action()}, these values will be used.
 *
 * @since 1.0.0
 *
 * @param string $id The action ID.
 *
 * @return bool Will always return true.
 */
function beans_reset_action( $id ) {

	_beans_unset_action( $id, 'modified' );
	_beans_unset_action( $id, 'removed' );

	$action = _beans_get_action( $id, 'added' );

	if ( $current = _beans_get_current_action( $id ) ) {

		remove_action( $current['hook'], $current['callback'], $current['priority'], $current['args'] );
		add_action( $action['hook'], $action['callback'], $action['priority'], $action['args'] );

	}

	return $action;

}

/**
 * Initialize action globals.
 *
 * @ignore
 */
global $_beans_registered_actions;

if ( ! isset( $_beans_registered_actions ) ) {
	$_beans_registered_actions = array(
		'added'    => array(),
		'modified' => array(),
		'removed'  => array(),
		'replaced' => array(),
	);
}

/**
 * Get action.
 *
 * @ignore
 */
function _beans_get_action( $id, $status ) {

	global $_beans_registered_actions;

	$id = _beans_unique_action_id( $id );

	if ( ! $registered = beans_get( $status, $_beans_registered_actions ) ) {
		return false;
	}

	if ( ! $action = beans_get( $id, $registered ) ) {
		return false;
	}

	return (array) json_decode( $action );

}

/**
 * Set action.
 *
 * @ignore
 */
function _beans_set_action( $id, $action, $status, $overwrite = false ) {

	global $_beans_registered_actions;

	$id = _beans_unique_action_id( $id );

	// Return action which already exist unless overwrite is set to true.
	if ( ! $overwrite && ( $_action = _beans_get_action( $id, $status ) ) ) {
		return $_action;
	}

	$_beans_registered_actions[ $status ][ $id ] = json_encode( $action );

	return $action;

}

/**
 * Unset action.
 *
 * @ignore
 */
function _beans_unset_action( $id, $status ) {

	global $_beans_registered_actions;

	$id = _beans_unique_action_id( $id );

	// Stop here if the action doesn't exist.
	if ( ! _beans_get_action( $id, $status ) ) {
		return false;
	}

	unset( $_beans_registered_actions[ $status ][ $id ] );

	return true;

}

/**
 * Merge action.
 *
 * @ignore
 */
function _beans_merge_action( $id, $action, $status ) {

	global $_beans_registered_actions;

	$id = _beans_unique_action_id( $id );

	if ( $_action = _beans_get_action( $id, $status ) ) {
		$action = array_merge( $_action, $action );
	}

	return _beans_set_action( $id, $action, $status, true );

}

/**
 * Check all action status and return the current action.
 *
 * @ignore
 */
function _beans_get_current_action( $id ) {

	$action = array();

	if ( _beans_get_action( $id, 'removed' ) ) {
		return false;
	}

	if ( $added = _beans_get_action( $id, 'added' ) ) {
		$action = $added;
	}

	if ( $modified = _beans_get_action( $id, 'modified' ) ) {
		$action = array_merge( $action, $modified );
	}

	// Stop here if the action is invalid.
	if ( 4 != count( $action ) ) {
		return false;
	}

	return $action;

}

/**
 * Add anonymous callback using a class since php 5.2 is still supported.
 *
 * @ignore
 */
function _beans_add_anonymous_action( $hook, $callback, $priority = 10, $args = 1 ) {

	require_once( BEANS_API_PATH . 'actions/class.php' );

	new _Beans_Anonymous_Actions( $hook, $callback, $priority, $args );

}

/**
 * Render action which can therefore be stored in a variable.
 *
 * @ignore
 */
function _beans_render_action( $hook ) {

	$args = func_get_args();

	// Return simple action if no sub-hook is set.
	if ( ! preg_match_all( '#\[(.*?)\]#', $args[0], $matches ) ) {

		if ( has_filter( $args[0] ) ) {
			return call_user_func_array( 'beans_render_function', array_merge( array( 'do_action' ), $args ) );
		} else {
			return false;
		}
	}

	$output = null;
	$prefix = current( explode( '[', $args[0] ) );
	$variable_prefix = $prefix;
	$suffix = preg_replace( '/^.*\]\s*/', '', $args[0] );

	// Base hook.
	$args[0] = $prefix . $suffix;

	if ( has_filter( $args[0] ) ) {
		$output .= call_user_func_array( 'beans_render_function', array_merge( array( 'do_action' ), $args ) );
	}

	foreach ( $matches[0] as $i => $subhook ) {

		$variable_prefix = $variable_prefix . $subhook;
		$levels = array( $prefix . $subhook . $suffix );

		// Cascade sub-hooks.
		if ( $i > 0 ) {

			$levels[] = str_replace( $subhook, '', $hook );
			$levels[] = $variable_prefix . $suffix;

		}

		// Apply sub-hooks.
		foreach ( $levels as $level ) {

			$args[0] = $level;

			if ( has_filter( $args[0] ) ) {
				$output .= call_user_func_array( 'beans_render_function', array_merge( array( 'do_action' ), $args ) );
			}

			// Apply filter whithout square brackets for backwards compatibility.
			$args[0] = preg_replace( '#(\[|\])#', '', $args[0] );

			if ( has_filter( $args[0] ) ) {
				$output .= call_user_func_array( 'beans_render_function', array_merge( array( 'do_action' ), $args ) );
			}
		}
	}

	return $output;

}

/**
 * Make sure the action ID is unique.
 *
 * @ignore
 */
function _beans_unique_action_id( $callback ) {

	if ( is_string( $callback ) ) {
		return $callback;
	}

	if ( is_object( $callback ) ) {
		$callback = array( $callback, '' );
	} else {
		$callback = (array) $callback;
	}

	// Treat object.
	if ( is_object( $callback[0] ) ) {

		if ( function_exists( 'spl_object_hash' ) ) {
			return spl_object_hash( $callback[0] ) . $callback[1];
		}

		return get_class( $callback[0] ) . $callback[1];

	} elseif ( is_string( $callback[0] ) ) { // Treat static method.

		return $callback[0] . '::' . $callback[1];

	}

	return md5( $callback );

}
