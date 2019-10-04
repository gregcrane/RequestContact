<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use LeviathanStudios\RequestContact\Api\Data\EstimateInterface;

/**
 * Interface EstimateRepositoryInterface
 */
interface EstimateRepositoryInterface
{
    /**
     * @param int $id
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \LeviathanStudios\RequestContact\Api\Data\EstimateInterface $estimate
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function save(EstimateInterface $estimate);

    /**
     * @param \LeviathanStudios\RequestContact\Api\Data\EstimateInterface $estimate
     * @return void
     */
    public function delete(EstimateInterface $estimate);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
