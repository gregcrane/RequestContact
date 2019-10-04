<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Controller\Adminhtml\Estimate;

use LeviathanStudios\RequestContact\Api\EstimateRepositoryInterface;
use LeviathanStudios\RequestContact\Model\Estimate as EstimateModel;
use LeviathanStudios\RequestContact\Model\EstimateFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Estimate delete controller.
 */
class Delete extends Action implements HttpGetActionInterface
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
     * @param Action\Context              $context
     * @param PageFactory                 $resultPageFactory
     * @param JsonFactory                 $resultJsonFactory
     * @param EstimateFactory             $estimateFactory
     * @param EstimateRepositoryInterface $estimateRepository
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        EstimateFactory $estimateFactory,
        EstimateRepositoryInterface $estimateRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory  = $resultPageFactory;
        $this->resultJsonFactory  = $resultJsonFactory;
        $this->estimateFactory    = $estimateFactory;
        $this->estimateRepository = $estimateRepository;
    }

    /**
     * Delete the selected estimate.
     *
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id = $this->getRequest()->getParam('entity_id')) {
            try {
                /** @var EstimateModel $model */
                $model = $this->estimateRepository->getById($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This estimate no longer exists.'));
                } else {
                    $this->estimateRepository->delete($model);
                    $this->messageManager->addSuccessMessage(__('This estimate has been successfully deleted.'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('An Error has occurred please try again.'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
