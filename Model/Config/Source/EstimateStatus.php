<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * EstimateStatus source model.
 */
class EstimateStatus extends AbstractSource implements SourceInterface, OptionSourceInterface
{
    /**
     * Return an array of statuses.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label'=> 'Unseen', 'value'=> 0],
            ['label'=> 'Viewed', 'value'=> 1],
            ['label'=> 'Responded', 'value'=> 2],
            ['label'=> 'Completed', 'value'=> 3]
        ];
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        return [0 => __('Unseen'), 1 => __('Viewed'), 3 => _('Responded'), 4 => ('Completed')];
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
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
