<?php

class CacheItemTest extends PHPUnit_Framework_TestCase
{
  public function testCommon()
  {
    $pool      = new \Packaged\Cache\Blackhole\BlackholePool();
    $testKey   = 'testcachekey';
    $cacheItem = new \Packaged\Cache\CacheItem($pool, $testKey);

    $cacheItem->hydrate('value', true);
    $this->assertEquals('value', $cacheItem->get());
    $this->assertTrue($cacheItem->exists());
    $this->assertTrue($cacheItem->isHit());
    $this->assertEquals($testKey, $cacheItem->getKey());

    $cacheItem->set('value2', 2);
    $this->assertEquals('value2', $cacheItem->get());

    $this->assertTrue($cacheItem->delete());

    $cacheItem->hydrate(null, false);
    $this->assertEquals(null, $cacheItem->get());
    $this->assertFalse($cacheItem->exists());

    $cacheItem->save('newvalue', 457);
    $this->assertEquals('newvalue', $cacheItem->get());
  }

  public function testDeleteNoKey()
  {
    $pool      = new \Packaged\Cache\Blackhole\BlackholePool();
    $cacheItem = new \Packaged\Cache\CacheItem($pool, null);
    $this->assertFalse($cacheItem->delete());
  }
}
