<?php
namespace Packaged\Cache\Memcached;

use Packaged\Cache\AbstractCachePool;
use Packaged\Cache\CacheItem;
use Packaged\Cache\ICacheItem;

class MemcachedPool extends AbstractCachePool
{
  protected $_connection;

  public function __construct($poolName = null)
  {
    $this->_connection = new \Memcached($poolName);
  }

  public function addServer($host, $port = 11211, $weight = 0)
  {
    $this->_connection->addServer($host, $port, $weight);
    return $this;
  }

  /**
   * Delete a key from the cache pool
   *
   * @param $key  string
   * @param $time int Time to wait before deleting the item
   *
   * @return mixed
   */
  public function deleteKey($key, $time = 0)
  {
    return $this->_connection->delete($key);
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
   * @return ICacheItem
   *   The corresponding Cache Item.
   * @throws \RuntimeException
   *   If the $key string is not a legal value
   */
  public function getItem($key)
  {
    $item  = new CacheItem($this, $key);
    $value = $this->_connection->get($key);
    if($value === null)
    {
      $item->hydrate($value, true);
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
    return $this->_connection->flush();
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
    return $this->_connection->set($item->getKey(), $item->get(), $ttl);
  }
}
