<?php
namespace Packaged\Cache\Blackhole;

use Packaged\Cache\AbstractCachePool;
use Packaged\Cache\CacheItem;
use Packaged\Cache\ICacheItem;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;

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
   * This method must always return a CacheItemInterface object, even in case of
   * a cache miss. It MUST NOT return null.
   *
   * @param string $key
   *   The key for which to return the corresponding Cache Item.
   *
   * @throws InvalidArgumentException
   *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
   *   MUST be thrown.
   *
   * @return CacheItemInterface
   *   The corresponding Cache Item.
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
