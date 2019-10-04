<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Controller\Adminhtml\Estimate;

use LeviathanStudios\RequestContact\Api\Data\EstimateInterface;
use LeviathanStudios\RequestContact\Api\EstimateRepositoryInterface;
use LeviathanStudios\RequestContact\Model\ResourceModel\Estimate\Collection;
use LeviathanStudios\RequestContact\Model\ResourceModel\Estimate\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'LeviathanStudios_RequestContact::estimate';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     * @see Collection
     */
    protected $collectionFactory;

    /**
     * @var EstimateRepositoryInterface $requestRepository
     */
    protected $requestRepository;

    /**
     * @param Context                     $context
     * @param Filter                      $filter
     * @param CollectionFactory           $collectionFactory
     * @param EstimateRepositoryInterface $requestRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        EstimateRepositoryInterface $requestRepository
    ) {
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->requestRepository = $requestRepository;
        parent::__construct($context);
    }

    /**
     * Delete the selected estimate items.
     *
     * @return Redirect|ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection     = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection->getItems() as $estimate) {
            try {
                /** @var EstimateInterface $tempEstimate */
                $tempEstimate = $this->requestRepository->getById($estimate->getEntityId());
                $this->requestRepository->delete($tempEstimate);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error in deletion process'));
            }
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
