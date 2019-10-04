<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Ui\Component\Buttons;

use LeviathanStudios\RequestContact\Model\Estimate;
use LeviathanStudios\RequestContact\Model\EstimateFactory;
use LeviathanStudios\RequestContact\Model\ResourceModel\Estimate as EstimateResource;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

/**
 * Class for common code for buttons on the create/edit estimate form
 */
class GenericButton
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var EstimateFactory $estimateFactory
     */
    private $estimateFactory;

    /**
     * @var EstimateResource $estimateResource
     */
    private $estimateResource;

    /**
     * @param UrlInterface     $urlBuilder
     * @param RequestInterface $request
     * @param EstimateFactory  $estimateFactory
     * @param EstimateResource $estimateResource
     */
    public function __construct(
        UrlInterface $urlBuilder,
        RequestInterface $request,
        EstimateFactory $estimateFactory,
        EstimateResource $estimateResource
    ) {
        $this->urlBuilder       = $urlBuilder;
        $this->request          = $request;
        $this->estimateFactory  = $estimateFactory;
        $this->estimateResource = $estimateResource;
    }

    /**
     * Get estimate id.
     *
     * @return int|null
     */
    public function getId()
    {
        /**
         * @var Estimate $estimate
         */
        $estimate = $this->estimateFactory->create();

        $entityId = $this->request->getParam('entity_id');
        $this->estimateResource->load(
            $estimate,
            $entityId
        );

        return $estimate->getEntityId() ?: null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
