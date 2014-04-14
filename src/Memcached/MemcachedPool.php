<?php
namespace Packaged\Cache\Memcached;

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
}
