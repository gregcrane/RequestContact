<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Model;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use LeviathanStudios\RequestContact\Api\Data\EstimateInterface;
use LeviathanStudios\RequestContact\ViewModel\Adminhtml\Review;

/**
 * Model class responsible for send the estimate response emails.
 */
class EstimateEmail
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var StateInterface $inlineTranslation
     */
    private $inlineTranslation;

    /**
     * @var TransportBuilder $transportBuilder
     */
    private $transportBuilder;

    /**
     * @var Review $formatter
     */
    private $formatter;

    public function __construct(
        Config $config,
        StoreManagerInterface $storeManager,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        Review $formatter
    ) {
        $this->config            = $config;
        $this->storeManager      = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder  = $transportBuilder;
        $this->formatter         = $formatter;
    }


    public function sendEmailTemplate(EstimateInterface $estimate, $message)
    {
        $formattedEstimate            = $this->formatter->formatEstimate($estimate);
        $formattedEstimate['message'] = $message;

        $this->inlineTranslation->suspend();

        try {
            $this->transportBuilder->setTemplateIdentifier($this->config->getEmailTemplate())
                                   ->setTemplateOptions(
                                       [
                                           'area'  => Area::AREA_FRONTEND,
                                           'store' => $this->storeManager->getStore()->getId()
                                       ]
                                   )->setTemplateVars($formattedEstimate)
                                   ->setFromByScope(
                                       [
                                           'email' => $this->config->getEmailAddress(),
                                           'name'  => $this->config->getEmailName()
                                       ],
                                       null
                                   )
                                   ->addTo(
                                       $estimate->getEmail(),
                                       $formattedEstimate['name']
                                   );

            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
        } catch (\Exception $exception) {

        }

        $this->inlineTranslation->resume();

        return $this;
    }
}
