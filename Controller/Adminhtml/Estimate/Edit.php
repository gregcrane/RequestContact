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
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface as FrameworkResponse;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit controller.
 */
class Edit extends Action implements HttpGetActionInterface
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
     * Execution action.
     *
     * @return Page|Redirect|FrameworkResponse|ResultInterface
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('entity_id')) {
            /** @var EstimateModel $model */
            $model = $this->estimateRepository->getById($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This request no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        /** @var Page $resultPage */
        $resultPage      = $this->resultPageFactory->create();
        $resultPageTitle = $id ? _('Edit Request') : _('New Request');
        $resultPage->setActiveMenu('LeviathanStudios_RequestContact::container');
        $resultPage->getConfig()->getTitle()->prepend($resultPageTitle);
        $resultPage->addBreadcrumb(__('Manage Requests'), __('Manage Requests'));

        return $resultPage;
    }
}
