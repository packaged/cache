<?php
namespace Packaged\Cache;

use Psr\Cache\CacheItemInterface;

abstract class AbstractCachePool implements ICachePool
{
  private $_deferred = [];

  /**
   * Returns a traversable set of cache items.
   *
   * @param array $keys
   *   An indexed array of keys of items to retrieve.
   *
   * @return array
   *   A traversable collection of Cache Items keyed by the cache keys of
   *   each item. A Cache item will be returned for each key, even if that
   *   key is not found. However, if no keys are specified then an empty
   *   CollectionInterface object MUST be returned instead.
   */
  public function getItems(array $keys = [])
  {
    $return = [];
    foreach($keys as $key)
    {
      $return[$key] = $this->getItem($key);
    }
    return $return;
  }

  /**
   * Removes multiple items from the pool.
   *
   * @param array $keys
   *   An array of keys that should be removed from the pool.
   *
   * @return array[key,bool]
   */
  public function deleteItems(array $keys)
  {
    $results = [];
    foreach($keys as $key)
    {
      if($key instanceof ICacheItem)
      {
        $key = $key->getKey();
      }
      $results[$key] = $this->deleteKey($key);
    }
    return $results;
  }

  /**
   * Removes a cache item from the pool.
   *
   * @param string $key The item that should be removed.
   *
   * @return bool
   */
  public function deleteItem($key)
  {
    if($key instanceof ICacheItem)
    {
      $key = $key->getKey();
    }
    return $this->deleteKey($key);
  }

  /**
   * Delete a key from the cache pool
   *
   * @param $key
   *
   * @return bool
   */
  abstract public function deleteKey($key);

  /**
   * Save multiple items
   *
   * @param ICacheItem[] $items
   *
   * @return array[key,bool]
   */
  public function saveItems(array $items)
  {
    $results = [];
    foreach($items as $item)
    {
      if($item instanceof ICacheItem)
      {
        $results[$item->getKey()] = $this->saveItem($item);
      }
    }
    return $results;
  }

  public function saveDeferred(CacheItemInterface $item)
  {
    $this->_deferred[] = $item;
    return true;
  }

  public function commit()
  {
    $this->saveItems($this->_deferred);
    $this->_deferred = [];
    return true;
  }

  public function save(CacheItemInterface $item)
  {
    if(!($item instanceof ICacheItem))
    {
      $item = new CacheItem($this, $item->getKey());
    }
    $this->saveItem($item);
  }

  public function hasItem($key)
  {
    return $this->getItem($key)->exists();
  }

  /**
   * Create a new cache item
   *
   * @param      $key
   * @param null $value
   * @param null $ttl
   *
   * @return CacheItem
   */
  public function createItem($key, $value = null, $ttl = null)
  {
    $item = new CacheItem($this, $key);
    if($value !== null)
    {
      $item->set($value, $ttl);
    }
    return $item;
  }
}
