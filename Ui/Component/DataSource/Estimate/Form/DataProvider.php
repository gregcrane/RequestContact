<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Ui\Component\DataSource\Estimate\Form;

use LeviathanStudios\RequestContact\Model\Estimate;
use LeviathanStudios\RequestContact\Model\ResourceModel\Estimate\Collection;
use LeviathanStudios\RequestContact\Model\ResourceModel\Estimate\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var Collection $collection
     */
    protected $collection;

    /**
     * @var Collection $loadedData
     */
    protected $loadedData;

    protected $contactCollectionFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param                       $name
     * @param                       $primaryFieldName
     * @param                       $requestFieldName
     * @param CollectionFactory     $contactCollectionFactory
     * @param array                 $meta
     * @param array                 $data
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->contactCollectionFactory = $contactCollectionFactory;
        $this->storeManager             = $storeManager;
        $this->collection               = $contactCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->contactCollectionFactory->create()->getItems();

        /** @var Estimate $estimate */
        foreach ($items as $estimate) {
            $this->loadedData[$estimate->getId()] = $estimate->getData();
            if (isset($this->loadedData[$estimate->getId()]['images'])) {
                unset($this->loadedData[$estimate->getId()]['images']);
                $this->loadedData[$estimate->getId()]['images'][0]['name']  = $estimate->getData('images');
                $url                                                        = $this->storeManager
                        ->getStore()
                        ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'estimate/' . $estimate->getData('images');
                $this->loadedData[$estimate->getId()]['images'][0]['url']   = $url;
                $this->loadedData[$estimate->getId()]['images'][0]['saved'] = 1;
            }
        }

        return $this->loadedData;
    }

    /**
     * Return the request param id field.
     *
     * @return string
     */
    public function getRequestFieldName()
    {
        return 'entity_id';
    }
}
