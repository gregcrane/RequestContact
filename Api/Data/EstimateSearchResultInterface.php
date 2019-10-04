<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface EstimateSearchResultInterface
 */
interface EstimateSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get settings list.
     *
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface[]
     */
    public function getItems();

    /**
     * Set settings list.
     *
     * @param \LeviathanStudios\RequestContact\Api\Data\EstimateInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
