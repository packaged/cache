<?php
namespace Packaged\Cache\Ephemeral;

use Packaged\Cache\AbstractCachePool;
use Packaged\Cache\CacheItem;
use Packaged\Cache\ICacheItem;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;

class EphemeralCachePool extends AbstractCachePool
{
  protected static $cachePool;
  protected $_pool;

  public function __construct($poolName = null)
  {
    $this->_pool = $poolName;
    if(!isset(self::$cachePool[$poolName]))
    {
      self::$cachePool[$poolName] = [];
    }
  }

  /**
   * Delete a key from the cache pool
   *
   * @param $key
   *
   * @return bool
   */
  public function deleteKey($key)
  {
    unset(self::$cachePool[$this->_pool][$key]);
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
    $item = new CacheItem($this, $key);
    if(isset(self::$cachePool[$this->_pool][$key]))
    {
      $item->hydrate(self::$cachePool[$this->_pool][$key], true);
    }
    else
    {
      $item->hydrate(null, false);
    }
    return $item;
  }

  /**
   * Deletes all items in the pool.
   *
   * @return boolean
   *   True if the pool was successfully cleared. False if there was an error.
   */
  public function clear()
  {
    self::$cachePool[$this->_pool] = [];
    return true;
  }

  /**
   * Save cache item
   *
   * @param ICacheItem $item
   * @param int|null   $ttl
   *
   * @return bool
   */
  public function saveItem(ICacheItem $item, $ttl = null)
  {
    self::$cachePool[$this->_pool][$item->getKey()] = $item->get();
    return true;
  }
}
