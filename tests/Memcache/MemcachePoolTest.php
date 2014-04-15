<?php

/**
 * @requires extension Memcache
 */
class MemcachePoolTest extends AbstractCachePoolTest
{
  /**
   * @param $name
   *
   * @return \Packaged\Cache\Memcache\MemcachePool
   */
  public function initiateCachePool($name)
  {
    $pool = new \Packaged\Cache\Memcache\MemcachePool($name);
    $pool->addServer('localhost.dev');
    return $pool;
  }
}
