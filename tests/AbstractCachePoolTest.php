<?php

abstract class AbstractCachePoolTest extends PHPUnit_Framework_TestCase
{
  /**
   * @param $name
   *
   * @return \Packaged\Cache\AbstractCachePool
   */
  abstract public function initiateCachePool($name);

  public function testDelete()
  {
    $pool = $this->initiateCachePool('test');
    (new \Packaged\Cache\CacheItem($pool, 'test'))->save('tester');
    $cacheItem = new \Packaged\Cache\CacheItem($pool, 'testKey');
    $cacheItem->save();
    $this->assertTrue($pool->deleteKey('test'));
    $this->assertTrue($pool->deleteItem($cacheItem));

    (new \Packaged\Cache\CacheItem($pool, 'test'))->save('tester');
    (new \Packaged\Cache\CacheItem($pool, 'testKey'))->save('tester');
    $this->assertEquals(
      ['testKey' => true, 'test' => true],
      $pool->deleteItems([$cacheItem, 'test'])
    );
  }

  public function testSave()
  {
    $pool      = $this->initiateCachePool('test');
    $cacheItem = new \Packaged\Cache\CacheItem($pool, 'testKey');
    $this->assertTrue($pool->saveItem($cacheItem, 1));
    $this->assertEquals(
      ['testKey' => true],
      $pool->saveItems([$cacheItem])
    );
  }

  public function testClear()
  {
    $pool = $this->initiateCachePool('test');
    $this->assertTrue($pool->clear());
  }

  public function testSetAndGet()
  {
    $unique = mt_rand(100000000, 9999999999);
    $pool   = $this->initiateCachePool('test');
    $pool->createItem('itemkey' . $unique, 'itemvalue')->save();
    $cacheItem = $pool->getItem('itemkey' . $unique);
    $this->assertEquals('itemvalue', $cacheItem->get());

    $pool->createItem('test1' . $unique, 'tester')->save();

    $items = $pool->getItems(['test1' . $unique, 'test2' . $unique]);
    $this->assertArrayHasKey('test1' . $unique, $items);
    $this->assertArrayHasKey('test2' . $unique, $items);
    $this->assertEquals('tester', $items['test1' . $unique]->get());
    $this->assertFalse($items['test2' . $unique]->exists());
  }
}
