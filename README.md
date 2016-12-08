![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)

# WP Redis Object Group Cache

This plugin enables group caching for sites using the [Redis Object Cache for WordPress dropin](https://github.com/devgeniem/wp-redis-object-cache-dropin).

### Functions

**add\_to\_group**

This function is hooked to the cache setting with the `wp_cache_set` function. If a group key is set for `wp_cache_set`, pushes the cache key to a Redis hash list mapped by the group key.

**delete\_from\_group**

This function is hooked to the cache deletion with the `wp_cache_delete` function. If a group key is set for `wp_cache_delete`, removes the specified item key from the group list. This ensures the group only has keys that actually exist in the object cache.

**delete\_group**

This function deletes all data related to a group key by first fetching all keys and deleting them and then deleting the Redis hash list of the group.

Usage:

```
\Geniem\Group_Cache::delete_group( $group_key );
```