<?php

/**
 * @requires extension Memcached
 */
class MemcachedPoolTest extends AbstractCachePoolTest
{
  /**
   * @param $name
   *
   * @return \Packaged\Cache\AbstractCachePool
   */
  public function initiateCachePool($name)
  {
    $pool = new \Packaged\Cache\Memcached\MemcachedPool($name);
    $pool->addServer('localhost');
    return $pool;
  }
}
