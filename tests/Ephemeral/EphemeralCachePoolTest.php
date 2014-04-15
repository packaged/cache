<?php

class EphemeralCachePoolTest extends AbstractCachePoolTest
{
  /**
   * @param $name
   *
   * @return \Packaged\Cache\AbstractCachePool
   */
  public function initiateCachePool($name)
  {
    return new \Packaged\Cache\Ephemeral\EphemeralCachePool('phpunit');
  }
}
