<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */

namespace LeviathanStudios\RequestContact\ViewModel\Adminhtml;

use LeviathanStudios\RequestContact\Api\Data\EstimateInterface;
use LeviathanStudios\RequestContact\Api\EstimateRepositoryInterface;
use LeviathanStudios\RequestContact\Model\Config\Source\Referred;
use LeviathanStudios\RequestContact\Model\Config\Source\States;
use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Serialize\Serializer\Json;


/**
 * View model used for estimate reviews.
 */
class Review implements ArgumentInterface
{
    /**
     * @var UrlInterface $urlBuilder
     */
    private $urlBuilder;

    /**
     * @var EstimateRepositoryInterface $estimateRepository
     */
    private $estimateRepository;

    /**
     * @var Http $request
     */
    private $request;

    /**
     * @var StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var TimezoneInterface $timeZone
     */
    private $timeZone;

    /**
     * @var array $states
     */
    private $states;

    /**
     * @var array $referred
     */
    private $referred;

    /**
     * @var Json $jsonEncoder
     */
    private $jsonEncoder;

    /**
     * @var UrlInterface $urlInterface
     */
    private $urlInterface;


    public function __construct(
        Referred $referredOptions,
        States $stateOptions,
        UrlInterface $urlBuilder,
        EstimateRepositoryInterface $estimateRepository,
        Http $request,
        StoreManagerInterface $storeManager,
        TimezoneInterface $timeZone,
        Json $jsonEncoder,
        UrlInterface $urlInterface
    ) {
        $this->urlBuilder         = $urlBuilder;
        $this->estimateRepository = $estimateRepository;
        $this->request            = $request;
        $this->storeManager       = $storeManager;
        $this->timeZone           = $timeZone;
        $this->states             = $stateOptions->getValueKeyArray();
        $this->referred           = $referredOptions->getValueKeyArray();
        $this->jsonEncoder        = $jsonEncoder;
        $this->urlInterface       = $urlInterface;
    }

    /**
     * Get url path to the review action.
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->urlInterface->getUrl('contact/estimate/reviewaction');
    }

    /**
     * Return the estimate data.
     *
     * @param bool $formatted
     * @return array|EstimateInterface
     */
    public function getEstimate($formatted = true)
    {
        $estimate = [];

        if ($id = $this->request->getParam('entity_id')) {
            try {
                /** @var EstimateInterface $estiamte */
                $estimate = $this->estimateRepository->getById($id);
                if ($formatted) {
                    $estimate = $this->formatEstimate($estimate);
                }
            } catch (\Exception $e) {
                // todo: do we need to do anything here?
            }
        }

        return $estimate;
    }

    /**
     * Format the EstimateInterface into an array.
     *
     * @param EstimateInterface $estimate
     * @return array
     * @throws NoSuchEntityException
     */
    public function formatEstimate(EstimateInterface $estimate)
    {
        if ($estimate) {
            return [
                'id'        => "{$estimate->getId()}",
                'name'      => "{$estimate->getFirstName()} {$estimate->getLastName()}",
                'email'     => $estimate->getEmail(),
                'phone'     => $estimate->getTelephone(),
                'address-main' => "{$estimate->getAddress()}, {$estimate->getCity()}, {$this->states[$estimate->getState()]}, {$estimate->getZip()}",
                'address'   => $estimate->getAddress(),
                'city'      => $estimate->getCity(),
                'state'     => $this->states[$estimate->getState()],
                'zip'       => $estimate->getZip(),
                'created'   => $this->timeZone->formatDateTime($estimate->getCreatedAt(), \IntlDateFormatter::MEDIUM),
                'request'   => $estimate->getRequest(),
                'referred'  => $this->referred[$estimate->getReferred()],
                'images'    => $this->getImageGallery($estimate)
            ];
        }
        return [];
    }

    /**
     * Return a serialized array of images with the correct url paths.
     *
     * @param EstimateInterface $estimate
     * @return bool|false|string
     * @throws NoSuchEntityException
     */
    private function getImageGallery(EstimateInterface $estimate)
    {
        $imagesItems = [];
        if ($estimate && $estimate->getImages()) {
            $url = $this->storeManager->getStore()
                                      ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'estimate/';
            foreach (explode(',', $estimate->getImages()) as $key => $image) {
                $imagesItems[] = [
                    'thumb'    => $url . $image,
                    'img'      => $url . $image,
                    'full'     => $url . $image,
                    'caption'  => '',
                    'position' => $key,
                    'isMain'   => ($key === 0) ? true : false,
                    'type'     => 'image',
                    'videoUrl' => null,
                ];
            }
        }

        return $this->jsonEncoder->serialize($imagesItems);
    }
}
