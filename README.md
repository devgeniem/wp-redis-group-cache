![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)

# WP Redis Group Cache
[![Latest Stable Version](https://poser.pugx.org/devgeniem/wp-redis-group-cache/v/stable)](https://packagist.org/packages/devgeniem/wp-redis-group-cache)
[![Total Downloads](https://poser.pugx.org/devgeniem/wp-redis-group-cache/downloads)](https://packagist.org/packages/devgeniem/wp-redis-group-cache)
[![Latest Unstable Version](https://poser.pugx.org/devgeniem/wp-redis-group-cache/v/unstable)](https://packagist.org/packages/devgeniem/wp-redis-group-cache)
[![License](https://poser.pugx.org/devgeniem/wp-redis-group-cache/license)](https://packagist.org/packages/devgeniem/wp-redis-group-cache)

This plugin enables group caching for sites using the [Redis Object Cache for WordPress](https://github.com/devgeniem/wp-redis-object-cache-dropin) dropin.

## Functionalities

### Creating the cache group

Defining a group for WP Object Cache items enables simultaneous cache invalidation for a set of cache items. See the [codex](https://codex.wordpress.org/Function_Reference/wp_cache_set) for further information on setting the group key. The following functions create the object cache functionality by hooking to the Redis Object Cache dropin:

**add\_to\_group**

This function is hooked to the cache setting with the `wp_cache_set` function. If a group key is set for `wp_cache_set`, the cache key is pushed into a Redis hash list mapped by the group key.

**delete\_from\_group**

This function is hooked to the cache deletion with the `wp_cache_delete` function. If a group key is set for `wp_cache_delete`, the specified item key is removed from the group list. This ensures the group only has keys that actually exist in the object cache.

### Invalidating a cache group

**delete\_group**

This function deletes all data related to a group key by first fetching all keys and deleting them from Redis and then deleting the Redis hash list of the group.

Usage:

```
\Geniem\Group_Cache::delete_group( $group_key );
```

## Excluding groups from caching

The Redis dropin automatically caches all data stored with WordPress Object Cache into Redis. If you want to exclude some groups from being stored into the group cache, return `true` from the `no_group_cache` filter for the corresponding group key.

```
function no_group_cache( $group, $key ) {
    if ( 'no_caching_key' === $group ) {
        return true;
    } else {
        return false;
    }
}
add_filter( 'geniem/cache/no_group_cache', 'no_group_cache', 1, 2 );
```
_Note that this does not disable the initial key-value caching!_

## Maintainers
[@villesiltala](https://github.com/villesiltala)

## License
GPLv3
