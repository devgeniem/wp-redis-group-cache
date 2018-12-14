<?php
/**
 * This file contains the Geniem Cache class.
 */

namespace Geniem;

/**
 * This class extends the Redis Object Cache for WordPress dropin
 * with group caching functionalities.
 *
 * @package Geniem
 */
class GroupCache {

    /**
     * @var $redis_instance
     *
     * Holds the connection object.
     */
    protected static $redis_instance;

    /**
     * A setter function for the connection object.
     *
     * @param object $redis_instance
     */
    public static function set_redis_instance( $redis_instance ) {
        self::$redis_instance = $redis_instance;
    }

    /**
     * If a group key is set, pushes the cache key to the specified Redis list.
     * This function is hooked to the cache setting.
     * The value is not needed here, set a human readable timestamp instead.
     *
     * @param string    $key      The Redis cache key.
     * @param any       $value    The cache data.
     * @param string    $group    The Redis hash key.
     */
    public static function add_to_group( $key, $value, $group ) {

        if ( self::no_group_cache( $group, $key ) ) {
            return;
        }

        $timestamp = date_i18n('F d, Y H:i');

        // Set the data into a hash set grouped by the group key.
        self::$redis_instance->hset( $group, $key, $timestamp );
    }

    /**
     * If a group key is set, deletes the key from the specified Redis hash.
     * This function is hooked to the cache deletion.
     *
     * @param string    $key      The Redis cache key.
     * @param string    $group    The Redis cache group key.
     */
    public static function delete_from_group( $key, $group ) {

        // Ignore this group?
        if ( self::no_group_cache( $group, $key ) ) {
            return;
        }

        // HDEL deletes a single value from the group.
        self::$redis_instance->hdel( $group, $key );
    }

    /**
     * Delete all data related to a group key by first
     * deleting all keys and then the Redis hash of the group.
     *
     * @param string $group The Redis hash key.
     */
    public static function delete_group( $group ) {
        global $wp_object_cache;

        // Get all keys first.
        $keys = self::$redis_instance->hkeys( $group );

        if ( is_array( $keys ) ) {
            // Delete all data related to keys.
            foreach ( $keys as $key ) {
                // Get the full key.
                $full_key = $wp_object_cache->build_key( $key, $group );

                // Delete the single key.
                self::$redis_instance->del( $full_key );
            }
        }

        // Delete the group and its content.
        self::$redis_instance->del( $group );

    }

    /**
     * Do we want to create a group cache for this group?
     *
     * @param string $group The cache group key.
     * @param string $key   The cache key.
     * @return bool
     */
    public static function no_group_cache( $group, $key ) {

        // Group blacklist
        $blacklist = apply_filters( 'geniem/cache/no_group_cache/blacklist', [
            'acf',
            'posts',
            'terms',
            'options',
            'dustpress/rendered',
            'transient',
            'default',
        ]);

        $no_group_cache = (
            empty( $group ) || // No group
            in_array( $group, $blacklist, true ) || // Group is in blacklist
            apply_filters( 'geniem/cache/no_group_cache', false, $group, $key ) // Failed specific check
        );

        return $no_group_cache;
    }
}
