<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\ViewModel\Frontend;

use LeviathanStudios\RequestContact\Model\Config;
use LeviathanStudios\RequestContact\Model\Config\Source\Referred;
use LeviathanStudios\RequestContact\Model\Config\Source\States;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class RequestForm
 */
class RequestForm implements ArgumentInterface
{
    /**
     * @var Referred $referredOptions
     */
    private $referredOptions;

    /**
     * @var States $stateOptions
     */
    private $stateOptions;

    /**
     * @var Config $config
     */
    private $config;

    /**
     * @param Referred $referredOptions
     * @param States   $stateOptions
     * @param Config   $config
     */
    public function __construct(
        Referred $referredOptions,
        States $stateOptions,
        Config $config
    ) {
        $this->referredOptions = $referredOptions;
        $this->stateOptions    = $stateOptions;
        $this->config          = $config;
    }

    /**
     * get url path to the save controller
     *
     * @return string
     */
    public function getFormAction()
    {
        return '/requestcontact/contact/save';
    }

    /**
     * Return if the age check is allowed.
     *
     * @return array
     */
    public function isAgeCheckAllowed()
    {
        return $this->config->getAgeCheck();
    }

    /**
     * Return the minimum age.
     *
     * @return array
     */
    public function getMinAge()
    {
        return $this->config->getMinAge();
    }

    /**
     * Return the title.
     *
     * @return array
     */
    public function getTitle()
    {
        return $this->config->getTitle();
    }

    /**
     * get the referred options associative array
     *
     * @return array
     */
    public function getReferredOptions()
    {
        return $this->referredOptions->toOptionArray();
    }

    /**
     * get the state options associative array
     *
     * @return array
     */
    public function getStateOptions()
    {
        $allowedStates = $this->config->getAllowedStates();
        if (!empty($allowedStates)) {
            $states    = $this->stateOptions->getValueKeyArray();
            $newStates = [];
            foreach ($allowedStates as $state) {
                array_push(
                    $newStates,
                    [
                        'label' => $states[$state],
                        'value' => $state
                    ]
                );
            }

            return $newStates;
        }

        return $this->stateOptions->toOptionArray();
    }
}
