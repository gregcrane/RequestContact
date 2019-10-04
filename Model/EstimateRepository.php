<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use LeviathanStudios\RequestContact\Api\Data;
use LeviathanStudios\RequestContact\Api\EstimateRepositoryInterface;
use LeviathanStudios\RequestContact\Model\ResourceModel\Estimate as EstimateResource;
use LeviathanStudios\RequestContact\Model\ResourceModel\Estimate\CollectionFactory as EstimateCollectionFactory;

/**
 * Class EstimateRepository
 */
class EstimateRepository implements EstimateRepositoryInterface
{
    /**
     * @var EstimateResource
     */
    private $resource;

    /**
     * @var EstimateFactory
     */
    private $estimateFactory;

    /**
     * @var EstimateCollectionFactory
     */
    private $estimateCollectionFactory;

    /**
     * @var Data\EstimateSearchResultInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

    /**
     * @var \LeviathanStudios\RequestContact\Api\Data\EstimateInterfaceFactory
     */
    private $dataEstimateFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param EstimateResource                          $resource
     * @param EstimateFactory                           $estimateFactory
     * @param Data\EstimateInterfaceFactory             $dataEstimateFactory
     * @param EstimateCollectionFactory                 $estimateCollectionFactory
     * @param Data\EstimateSearchResultInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                          $dataObjectHelper
     * @param DataObjectProcessor                       $dataObjectProcessor
     * @param CollectionProcessorInterface              $collectionProcessor
     */
    public function __construct(
        EstimateResource $resource,
        EstimateFactory $estimateFactory,
        Data\EstimateInterfaceFactory $dataEstimateFactory,
        EstimateCollectionFactory $estimateCollectionFactory,
        Data\EstimateSearchResultInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource                  = $resource;
        $this->estimateFactory           = $estimateFactory;
        $this->estimateCollectionFactory = $estimateCollectionFactory;
        $this->searchResultsFactory      = $searchResultsFactory;
        $this->dataObjectHelper          = $dataObjectHelper;
        $this->dataEstimateFactory       = $dataEstimateFactory;
        $this->dataObjectProcessor       = $dataObjectProcessor;
        $this->collectionProcessor       = $collectionProcessor;
    }

    /**
     * this will attempt to save the estimate
     *
     * @param Data\EstimateInterface $estimate
     * @return Data\EstimateInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\EstimateInterface $estimate)
    {

        try {
            $this->resource->save($estimate);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the estimate: %1', $exception->getMessage()),
                $exception
            );
        }

        return $estimate;
    }

    /**
     * Load estimate by id
     *
     * @param int $id
     * @return Data\EstimateInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $estimateRequest = $this->estimateFactory->create();
        $estimateRequest->load($id);
        if (!$estimateRequest->getId()) {
            throw new NoSuchEntityException(__('Estimate with id "%1" does not exist.', $id));
        }

        return $estimateRequest;
    }

    /**
     * Load estimate data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return Data\EstimateSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \LeviathanStudios\RequestContact\Model\ResourceModel\Estimate\Collection $collection */
        $collection = $this->estimateCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\EstimateSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete estimate
     *
     * @param Data\EstimateInterface $estimate
     * @return bool|void
     * @throws CouldNotDeleteException
     */
    public function delete(Data\EstimateInterface $estimate)
    {
        try {
            $this->resource->delete($estimate);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete the estimate: %1', $exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete estimate by given setting Identity
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
