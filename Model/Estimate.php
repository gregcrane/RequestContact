<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Model;

use LeviathanStudios\RequestContact\Api\Data\EstimateInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Estimate
 *
 * @package LeviathanStudios\RequestContact\Model
 */
class Estimate extends AbstractModel implements EstimateInterface, IdentityInterface
{
    const CACHE_TAG = 'leviathanstudios_requestcontact_estimate';
    protected $_cacheTag = 'leviathanstudios_requestcontact_estimate';
    protected $_eventPrefix = 'leviathanstudios_requestcontact_estimate';

    /**
     * Model construct that should be used for object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('LeviathanStudios\RequestContact\Model\ResourceModel\Estimate');
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * Get store customer
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return parent::getData(self::CUSTOMER_ID);
    }

    /**
     * Get request status
     *
     * @return int|null
     */
    public function getStatus()
    {
        return parent::getData(self::STATUS);
    }

    /**
     * Get customer email address
     *
     * @return string|null
     */
    public function getEmail()
    {
        return parent::getData(self::EMAIL);
    }

    /**
     * Get customer first name
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return parent::getData(self::FIRST_NAME);
    }

    /**
     * Get customer last name
     *
     * @return string|null
     */
    public function getLastName()
    {
        return parent::getData(self::LAST_NAME);
    }

    /**
     * Get customer request
     *
     * @return string|null
     */
    public function getRequest()
    {
        return parent::getData(self::REQUEST);
    }

    /**
     * Get customer address
     *
     * @return string|null
     */
    public function getAddress()
    {
        return parent::getData(self::ADDRESS);
    }

    /**
     * Get customer city
     *
     * @return string|null
     */
    public function getCity()
    {
        return parent::getData(self::CITY);
    }

    /**
     * Get customer state
     *
     * @return string|null
     */
    public function getState()
    {
        return parent::getData(self::STATE);
    }

    /**
     * Get customer zip code
     *
     * @return string|null
     */
    public function getZip()
    {
        return parent::getData(self::ZIP);
    }

    /**
     * Get how customer was refereed.
     *
     * @return int|null
     */
    public function getReferred()
    {
        return parent::getData(self::REFERRED);
    }

    /**
     * Get estimate creation date.
     *
     * @return int|null
     */
    public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }

    /**
     * Get estimate updated date.
     *
     * @return int|null
     */
    public function getUpdatedAt()
    {
        return parent::getData(self::UPDATED_AT);
    }

    /**
     * Get telephone number.
     *
     * @return string|null
     */
    public function getTelephone()
    {
        return parent::getData(self::TELEPHONE);
    }

    /**
     * Get images.
     *
     * @return string|null
     */
    public function getImages()
    {
        return parent::getData(self::IMAGES);
    }

    /**
     * Get images hash.
     *
     * @return string|null
     */
    public function getImagesHash()
    {
        return parent::getData(self::IMAGES_HASH);
    }

    /**
     * Set ID.
     *
     * @param $id
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Set customer id.
     *
     * @param $customerId
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Set status.
     *
     * @param $status
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set email.
     *
     * @param $email
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Set customer first name.
     *
     * @param $firstName
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setFirstName($firstName)
    {
        return $this->setData(self::FIRST_NAME, $firstName);
    }

    /**
     * Set customer last name.
     *
     * @param $lastName
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setLastName($lastName)
    {
        return $this->setData(self::LAST_NAME, $lastName);
    }

    /**
     * Set customer request.
     *
     * @param $request
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setRequest($request)
    {
        return $this->setData(self::REQUEST, $request);
    }

    /**
     * Set customer address.
     *
     * @param $address
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Set customer city.
     *
     * @param $city
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * Set customer state.
     *
     * @param $state
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setState($state)
    {
        return $this->setData(self::STATE, $state);
    }

    /**
     * Set customer zip.
     *
     * @param $zip
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setZip($zip)
    {
        return $this->setData(self::ZIP, $zip);
    }

    /**
     * Set referred.
     *
     * @param $referred
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setReferred($referred)
    {
        return $this->setData(self::REFERRED, $referred);
    }

    /**
     * Set created at.
     *
     * @param $created
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setCreatedAt($created)
    {
        return $this->setData(self::CREATED_AT, $created);
    }

    /**
     * Set updated at.
     *
     * @param $updated
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setUpdatedAt($updated)
    {
        return $this->setData(self::UPDATED_AT, $updated);
    }

    /**
     * Set telephone.
     *
     * @param $telephone
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::UPDATED_AT, $telephone);
    }

    /**
     * Set images.
     *
     * @param $images
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setImages($images)
    {
        return $this->setData(self::IMAGES, $images);
    }

    /**
     * Set image hash.
     *
     * @param $imagesHash
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setImagesHash($imagesHash)
    {
        return $this->setData(self::IMAGES_HASH, $imagesHash);
    }
}
