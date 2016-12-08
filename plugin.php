<?php
/**
 * Plugin Name: Redis Object Group Cache
 * Plugin URI: https://github.com/devgeniem/wp-redis-object-group-cache
 * Description: A plugin extending the Redis Object Cache for WordPress with a group cache functionality.
 * Version: 1.0.0
 * Author: Geniem Oy / Ville Siltala
 * Author URI: http://www.geniem.com
 */

namespace Geniem;

require_once( __DIR__ . '/classes/cache.php' );

global $wp_object_cache;

// Use this plugin only if Redis is enabled in WP Object Cache.
if ( true === $wp_object_cache->redis_status() ) {
    Cache::set_redis_instance( $wp_object_cache->redis_instance() );
} else {
    return;
}

/**
 * Hook to cache setting to enable group handling.
 */
add_action( 'redis_object_cache_set', __NAMESPACE__ . '\\Cache::add_to_group', 1, 3 );

/**
 * Hook to cache deletion to clear a key from a included group cache.
 */
add_action( 'redis_object_cache_delete', __NAMESPACE__ . '\\Cache::delete_from_group', 1, 2 );
