<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Controller\Adminhtml\Estimate;

use LeviathanStudios\RequestContact\Api\EstimateRepositoryInterface;
use LeviathanStudios\RequestContact\Model\EstimateEmail;
use LeviathanStudios\RequestContact\Model\EstimateFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface as FrameworkResponse;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Review action controller class tasked with sending out the response emails.
 */
class ReviewAction extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'LeviathanStudios_RequestContact::estimate';

    /**
     * @var JsonFactory $resultJsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var PageFactory $resultPageFactory
     */
    private $resultPageFactory;

    /**
     * @var EstimateFactory $estimateFactory
     */
    private $estimateFactory;

    /**
     * @var EstimateRepositoryInterface $estiamteRepository
     */
    private $estimateRepository;

    /**
     * @var EstimateEmail $emailer
     */
    private $estimateEmail;

    /**
     * @param Action\Context              $context
     * @param PageFactory                 $resultPageFactory
     * @param JsonFactory                 $resultJsonFactory
     * @param EstimateFactory             $estimateFactory
     * @param EstimateRepositoryInterface $estimateRepository
     * @param EstimateEmail               $estimateEmail
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        EstimateFactory $estimateFactory,
        EstimateRepositoryInterface $estimateRepository,
        EstimateEmail $estimateEmail
    ) {
        parent::__construct($context);
        $this->resultPageFactory  = $resultPageFactory;
        $this->resultJsonFactory  = $resultJsonFactory;
        $this->estimateFactory    = $estimateFactory;
        $this->estimateRepository = $estimateRepository;
        $this->estimateEmail      = $estimateEmail;
    }

    /**
     * Fire of the email response for the estimate and update its status is successful.
     *
     * @return Redirect|FrameworkResponse|ResultInterface
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('entity_id')) {
            try {
                $estimate = $this->estimateRepository->getById($id);
                $this->estimateEmail->sendEmailTemplate($estimate, $this->getRequest()->getParam('message'));
                $estimate->setStatus(2);
                $this->estimateRepository->save($estimate);
                $this->messageManager->addSuccessMessage(
                    __('Estimate response sent out and estimate status updated.')
                );
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong: Estimate response was not sent, please try again.')
                );
            }
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
