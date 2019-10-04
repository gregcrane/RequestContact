<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Api\Data;

/**
 * Interface EstimateInterface
 */
interface EstimateInterface
{
    const ENTITY_ID   = 'entity_id';
    const CUSTOMER_ID = 'customer_id';
    const STATUS      = 'status';
    const EMAIL       = 'email';
    const FIRST_NAME  = 'first_name';
    const LAST_NAME   = 'last_name';
    const REQUEST     = 'request';
    const ADDRESS     = 'address';
    const CITY        = 'city';
    const STATE       = 'state';
    const ZIP         = 'zip';
    const REFERRED    = 'referred';
    const CREATED_AT  = 'created_at';
    const UPDATED_AT  = 'updated_at';
    const IMAGES      = 'images';
    const TELEPHONE   = 'telephone';
    const IMAGES_HASH = 'images_hash';

    /**
     * Get row id.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get customer id.
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Get request status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Get customer email address
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Get customer first name
     *
     * @return string|null
     */
    public function getFirstName();

    /**
     * Get customer last name
     *
     * @return string|null
     */
    public function getLastName();

    /**
     * Get customer request
     *
     * @return string|null
     */
    public function getRequest();

    /**
     * Get customer address
     *
     * @return string|null
     */
    public function getAddress();

    /**
     * Get customer city
     *
     * @return string|null
     */
    public function getCity();

    /**
     * Get customer state
     *
     * @return  string|null
     */
    public function getState();

    /**
     * Get customer zip code
     *
     * @return string|null
     */
    public function getZip();

    /**
     * Get how customer was refereed.
     *
     * @return int|null
     */
    public function getReferred();

    /**
     * Get estimate creation date.
     *
     * @return int|null
     */
    public function getCreatedAt();

    /**
     * Get estimate updated date.
     *
     * @return int|null
     */
    public function getUpdatedAt();

    /**
     * Get customer telephone.
     *
     * @return string|null
     */
    public function getTelephone();

    /**
     * Get estimate images.
     *
     * @return string|null
     */
    public function getImages();

    /**
     * Get estimate images hash.
     *
     * @return string|null
     */
    public function getImagesHash();

    /**
     * Set ID
     *
     * @param $entityId
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setEntityId($entityId);

    /**
     * Set store customer
     *
     * @param $customerId
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setCustomerId($customerId);

    /**
     * Set status
     *
     * @param $status
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setStatus($status);

    /**
     * Set email
     *
     * @param $email
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setEmail($email);


    /**
     * Set customer first name
     *
     * @param $firstName
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setFirstName($firstName);

    /**
     * Set customer last name
     *
     * @param $lastName
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setLastName($lastName);

    /**
     * Set customer request
     *
     * @param $request
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setRequest($request);

    /**
     * Set customer address
     *
     * @param $address
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setAddress($address);

    /**
     * Set customer city
     *
     * @param $city
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setCity($city);

    /**
     * Set customer state
     *
     * @param $state
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setState($state);

    /**
     * Set customer zip
     *
     * @param $zip
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setZip($zip);

    /**
     * Set referred
     *
     * @param $referred
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setReferred($referred);

    /**
     * Set created at.
     *
     * @param $created
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setCreatedAt($created);

    /**
     * Set updated at
     *
     * @param $updated
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setUpdatedAt($updated);

    /**
     * Set telephone
     *
     * @param $telephone
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setTelephone($telephone);

    /**
     * Set images
     *
     * @param $images
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setImages($images);

    /**
     * Set images hash
     *
     * @param $imagesHash
     * @return \LeviathanStudios\RequestContact\Api\Data\EstimateInterface
     */
    public function setImagesHash($imagesHash);
}
