<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Referred source model
 */
class Referred implements OptionSourceInterface
{
    /**
     * Return an array of referred types.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => 'Friend', 'value' => 0],
            ['label' => 'Facebook', 'value' => 1],
            ['label' => 'Instagram', 'value' => 2],
            ['label' => 'ad', 'value' => 3],
            ['label' => 'acquaintance', 'value' => 4],
            ['label' => 'other', 'value' => 5]
        ];
    }

    /**
     * Return a value key array.
     *
     * @return array
     */
    public function getValueKeyArray()
    {
        $valueKey = [];
        foreach ($this->toOptionArray() as $item) {
            $valueKey[$item['value']] = $item['label'];
        }
        return $valueKey;
    }
}
