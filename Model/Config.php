<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * The Config utility class used to grab admin configuration values.
 */
class Config
{
    const XML_PATH_ENABLED              = 'leviathan_request/general/enabled';
    const XML_PATH_EMAIL_TEMPLATE_FIELD = 'leviathan_request/general/email_response';
    const XML_PATH_FROM_EMAIL           = 'leviathan_request/general/email';
    const XML_PATH_FROM_EMAIL_NAME      = 'leviathan_request/general/email_name';
    const XML_PATH_ALLOWED_STATES       = 'leviathan_request/general/allowed_states';
    const XML_PATH_AGE_CHECK            = ' leviathan_request/general/age_check';
    const XML_PATH_MIN_AGE              = ' leviathan_request/general/min_age';
    const XML_PATH_TITLE                = ' leviathan_request/general/title';
    const DEFAULT_EMAIL_TEMPLATE        = 'leviathan_request_general_email_response';

    /**
     * @var ScopeConfigInterface $config
     */
    private $config;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * @param ScopeConfigInterface $config
     * @param SerializerInterface  $serializer
     */
    public function __construct(
        ScopeConfigInterface $config,
        SerializerInterface $serializer
    ) {
        $this->config     = $config;
        $this->serializer = $serializer;
    }

    /**
     * Return the is enabled admin value.
     *
     * @param string $scopeType
     * @param null   $scopeCode
     * @return mixed
     */
    public function isEnabled($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->config->getValue(static::XML_PATH_ENABLED, $scopeType, $scopeCode);
    }

    /**
     * Return the email template admin value.
     *
     * @param string $scopeType
     * @param null   $scopeCode
     * @return mixed
     */
    public function getEmailTemplate($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        $email = $this->config->getValue(static::XML_PATH_EMAIL_TEMPLATE_FIELD, $scopeType, $scopeCode);
        return $email ? $email : static::DEFAULT_EMAIL_TEMPLATE;
    }

    /**
     * Return the email address admin value.
     *
     * @param string $scopeType
     * @param null   $scopeCode
     * @return mixed
     */
    public function getEmailAddress($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->config->getValue(static::XML_PATH_FROM_EMAIL, $scopeType, $scopeCode);
    }

    /**
     * Return the email address name admin value.
     *
     * @param string $scopeType
     * @param null   $scopeCode
     * @return mixed
     */
    public function getEmailName($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->config->getValue(static::XML_PATH_FROM_EMAIL_NAME, $scopeType, $scopeCode);
    }

    /**
     * Return an array of allowed states.
     *
     * @param string $scopeType
     * @param null   $scopeCode
     * @return array
     */
    public function getAllowedStates($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return explode(
            ',',
            $this->config->getValue(
                static::XML_PATH_ALLOWED_STATES,
                $scopeType,
                $scopeCode
            )
        );
    }

    /**
     * Return the age check value.
     *
     * @param string $scopeType
     * @param null   $scopeCode
     * @return array
     */
    public function getAgeCheck($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->config->getValue(static::XML_PATH_AGE_CHECK, $scopeType, $scopeCode);
    }

    /**
     * Return the minimum age.
     *
     * @param string $scopeType
     * @param null   $scopeCode
     * @return array
     */
    public function getMinAge($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->config->getValue(static::XML_PATH_MIN_AGE, $scopeType, $scopeCode);
    }

    /**
     * Return the title value.
     *
     * @param string $scopeType
     * @param null   $scopeCode
     * @return array
     */
    public function getTitle($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->config->getValue(static::XML_PATH_TITLE, $scopeType, $scopeCode);
    }
}
