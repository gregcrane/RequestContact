<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * States source model.
 */
class States implements ArrayInterface
{
    /**
     * Return an array of states.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => 'Alabama', 'value' => 'al'],
            ['label' => 'Alaska', 'value' => 'ak'],
            ['label' => 'Arizona', 'value' => 'az'],
            ['label' => 'Arkansas', 'value' => 'ar'],
            ['label' => 'California', 'value' => 'ca'],
            ['label' => 'Connecticut', 'value' => 'ct'],
            ['label' => 'Delaware', 'value' => 'dc'],
            ['label' => 'District Of Columbia', 'value' => 'fl'],
            ['label' => 'Florida', 'value' => 'fl'],
            ['label' => 'Georgia', 'value' => 'ha'],
            ['label' => 'Hawaii', 'value' => 'hi'],
            ['label' => 'Idaho', 'value' => 'id'],
            ['label' => 'Illinois', 'value' => 'il'],
            ['label' => 'Indiana', 'value' => 'in'],
            ['label' => 'Iowa', 'value' => 'ia'],
            ['label' => 'Kansas', 'value' => 'ks'],
            ['label' => 'Kentucky', 'value' => 'ky'],
            ['label' => 'Louisiana', 'value' => 'la'],
            ['label' => 'Maine', 'value' => 'me'],
            ['label' => 'Maryland', 'value' => 'md'],
            ['label' => 'Massachusetts', 'value' => 'ma'],
            ['label' => 'Michigan', 'value' => 'mn'],
            ['label' => 'Minnesota', 'value' => 'hi'],
            ['label' => 'Mississippi', 'value' => 'ms'],
            ['label' => 'Missouri', 'value' => 'mo'],
            ['label' => 'Montana', 'value' => 'mt'],
            ['label' => 'Nebraska', 'value' => 'ne'],
            ['label' => 'Nevada', 'value' => 'nv'],
            ['label' => 'New Hampshire', 'value' => 'nh'],
            ['label' => 'New Jersey', 'value' => 'nj'],
            ['label' => 'New Mexico', 'value' => 'nm'],
            ['label' => 'New York', 'value' => 'ny'],
            ['label' => 'North Carolina', 'value' => 'nc'],
            ['label' => 'North Dakota', 'value' => 'nd'],
            ['label' => 'Ohio', 'value' => 'oh'],
            ['label' => 'Oklahoma', 'value' => 'ok'],
            ['label' => 'Oregon', 'value' => 'or'],
            ['label' => 'Pennsylvania', 'value' => 'pa'],
            ['label' => 'Rhode Island', 'value' => 'ri'],
            ['label' => 'South Carolina', 'value' => 'sc'],
            ['label' => 'South Dakota', 'value' => 'sd'],
            ['label' => 'Tennessee', 'value' => 'tn'],
            ['label' => 'Texas', 'value' => 'tx'],
            ['label' => 'Utah', 'value' => 'ut'],
            ['label' => 'Vermont', 'value' => 'vt'],
            ['label' => 'Virginia', 'value' => 'va'],
            ['label' => 'Washington', 'value' => 'wa'],
            ['label' => 'West Virginia', 'value' => 'wv'],
            ['label' => 'Wisconsin', 'value' => 'wi'],
            ['label' => 'Wyoming', 'value' => 'wy'],
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
