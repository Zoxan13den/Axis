<?php

namespace App\Dto;

use ArrayAccess;
use Countable;
use Illuminate\Support\Collection;
use Iterator;

/**
 * DataTransferObjectCollection
 * Copied from https://github.com/spatie/data-transfer-object/blob/1.13.2/src/DataTransferObjectCollection.php
 * as it was removed in version 3 and broke compatibility.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
abstract class DataTransferObjectCollection implements
    ArrayAccess,
    Iterator,
    Countable
{
    /** @var array */
    protected $collection;

    /** @var int */
    protected int $position = 0;

    /**
     * DataTransferObjectCollection constructor.
     * @param array $collection
     */
    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    /**
     * Get current element.
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->position];
    }

    /**
     * Get element with offset.
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->collection[$offset] ?? null;
    }

    /**
     * Set offset index.
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    /**
     * Check whether offset exists.
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->collection);
    }

    /**
     * Unset offset.
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    /**
     * Move current state to next position.
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Get current index.
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Check if current position is exists in collection.
     * @return bool
     */
    public function valid(): bool
    {
        return array_key_exists($this->position, $this->collection);
    }

    /**
     * Reset current index.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Transform to array recursively.
     * @return array
     */
    public function toArray(): array
    {
        $collection = $this->collection;

        foreach ($collection as $key => $item) {
            if (!$item instanceof BaseDataObject
                && !$item instanceof DataTransferObjectCollection
            ) {
                continue;
            }

            $collection[$key] = $item->toArray();
        }

        return $collection;
    }

    /**
     * Get Items
     * @return array
     */
    public function items(): array
    {
        return $this->collection;
    }

    /**
     * Items count.
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }

    /**
     * Transform to Illuminate collection.
     * @return \Illuminate\Support\Collection
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
