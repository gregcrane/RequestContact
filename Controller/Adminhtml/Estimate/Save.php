<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Controller\Adminhtml\Estimate;

use LeviathanStudios\RequestContact\Api\EstimateRepositoryInterface;
use LeviathanStudios\RequestContact\Model\EstimateFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Estimate controller that will save the estimate requests.
 *
 * @package LeviathanStudios\RequestContact\Controller\Adminhtml\Estimate
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'LeviathanStudios_RequestContact::estimate';

    /**
     * @var DataPersistorInterface $dataPersistor
     */
    protected $dataPersistor;

    /**
     * @var EstimateRepositoryInterface $requestRepository
     */
    protected $requestRepository;

    /**
     * @var EstimateFactory $estimateFactor
     */
    protected $estimateFactory;

    /**
     * @var CustomerRepositoryInterface $customerRepository
     */
    private $customerRepository;

    /**
     * @param Context                     $context
     * @param DataPersistorInterface      $dataPersistor
     * @param EstimateRepositoryInterface $requestRepository
     * @param EstimateFactory             $estimateFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        EstimateRepositoryInterface $requestRepository,
        EstimateFactory $estimateFactory,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->dataPersistor      = $dataPersistor;
        $this->requestRepository  = $requestRepository;
        $this->estimateFactory    = $estimateFactory;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * Save the estimate request.
     *
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if ($data) {
            $data = $this->filterData($data);

            if ($id = $this->getRequest()->getParam('entity_id')) {
                try {
                    $model = $this->requestRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('Request no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $model = $this->estimateFactory->create();
            }

            $model->setData($data);

            try {
                $this->requestRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the request.'));
                $this->dataPersistor->clear('estimate_request');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getEntityId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the request.')
                );
            }
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Massage the post data into an acceptable format.
     *
     * @param $rawData
     * @return mixed
     */
    private function filterData($rawData)
    {
        $data = $rawData;

        if (empty($data['entity_id'])) {
            $data['entity_id'] = null;
        }

        if (empty($data['customer_id'])) {
            $data['customer_id'] = $this->getCustomerId($data);
        }

        // todo: multiple images :: see catalog product image examples
        if (isset($data['images']) && is_array($data['images'])) {
            if (!empty($data['images']['delete'])) {
                $data['images'] = null;
            } else {
                if (isset($data['images'][0]['name']) && isset($data['images'][0]['tmp_name'])) {
                    $data['images'] = $data['images'][0]['name'];
                } else {
                    unset($data['images']);
                }
            }
        }
        return $data;
    }

    /**
     * Get the customer ID id there is a match.
     *
     * @param $data
     * @return int|null
     */
    private function getCustomerId($data)
    {
        $customerId = null;

        if ($data['email']) {
            try {
                /** @var CustomerInterface $customer */
                $customer   = $this->customerRepository->get($data['email']);
                $customerId = $customer->getId();
            } catch (\Exception $e) {
                // do nothing, there was no match.
            }
        }

        return $customerId;
    }
}
