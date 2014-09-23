<?php
namespace Packaged\Cache\Memcached;

use Packaged\Cache\ICacheItem;
use Packaged\Cache\Memcache\MemcachePool;

class MemcachedPool extends MemcachePool
{
  protected $_connection;

  public function __construct($poolName = null)
  {
    $this->_connection = new \Memcached($poolName);
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
