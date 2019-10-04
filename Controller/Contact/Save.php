<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Controller\Contact;

use LeviathanStudios\RequestContact\Api\EstimateRepositoryInterface;
use LeviathanStudios\RequestContact\Model\Estimate;
use LeviathanStudios\RequestContact\Model\EstimateFactory;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Math\Random;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Class Save
 */
class Save extends Action
{
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
     * @param EstimateRepositoryInterface $requestRepository
     * @param EstimateFactory             $estimateFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        EstimateRepositoryInterface $requestRepository,
        EstimateFactory $estimateFactory,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->requestRepository  = $requestRepository;
        $this->estimateFactory    = $estimateFactory;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }


    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();


        if ($data = $this->getRequest()->getPostValue()) {
            $data = $this->filterData($data);

            /** @var Estimate $model */
            $model = $this->estimateFactory->create();
            $model->setData($data);

            try {
                $this->requestRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the request.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('requestcontact/contact/estimate');
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
        // todo save images temp then save from temp
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
