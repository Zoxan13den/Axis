<?php

namespace App\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class BaseDataObject extends DataTransferObject
{
    /**
     * Parse array.
     *
     * @param array $array
     * @return array
     */
    protected function parseArray(array $array): array
    {
        foreach ($array as $key => $value) {
            if ($value instanceof BaseDataObject
                || $value instanceof DataTransferObjectCollection
            ) {
                $array[$key] = $value->toArray();

                continue;
            }

            if (!is_array($value)) {
                continue;
            }

            $array[$key] = $this->parseArray($value);
        }

        return $array;
    }
}
