<?php
namespace Packaged\Cache\Blackhole;

use Packaged\Cache\AbstractCachePool;
use Packaged\Cache\CacheItem;
use Packaged\Cache\ICacheItem;

class BlackholePool extends AbstractCachePool
{
  /**
   * Delete a key from the cache pool
   *
   * @param $key
   *
   * @return mixed
   */
  public function deleteKey($key)
  {
    return true;
  }

  /**
   * Returns a Cache Item representing the specified key.
   *
   * This method must always return an ItemInterface object, even in case of
   * a cache miss. It MUST NOT return null.
   *
   * @param string $key
   *   The key for which to return the corresponding Cache Item.
   *
   * @return \Packaged\Cache\ICacheItem
   *   The corresponding Cache Item.
   * @throws \RuntimeException
   *   If the $key string is not a legal value
   */
  public function getItem($key)
  {
    return (new CacheItem($this, $key))->hydrate($key, false);
  }

  /**
   * Deletes all items in the pool.
   *
   * @return boolean
   *   True if the pool was successfully cleared. False if there was an error.
   */
  public function clear()
  {
    return true;
  }

  /**
   * Save cache item
   *
   * @param \Packaged\Cache\ICacheItem $item
   * @param int|null                   $ttl
   *
   * @return bool
   */
  public function saveItem(ICacheItem $item, $ttl = null)
  {
    return true;
  }
}
