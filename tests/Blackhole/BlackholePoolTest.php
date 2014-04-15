<?php

class BlackholePoolTest extends AbstractCachePoolTest
{
  /**
   * @param $name
   *
   * @return \Packaged\Cache\ICachePool
   */
  public function initiateCachePool($name)
  {
    return new \Packaged\Cache\Blackhole\BlackholePool('tester');
  }

  public function testSetAndGet()
  {
    $pool      = $this->initiateCachePool('test');
    $cacheItem = $pool->getItem('blackhole');
    $this->assertEquals('blackhole', $cacheItem->get());
    $items = $pool->getItems(['test1', 'test2']);
    $this->assertArrayHasKey('test1', $items);
    $this->assertArrayHasKey('test2', $items);
    $this->assertEquals('test1', $items['test1']->get());
  }
}
