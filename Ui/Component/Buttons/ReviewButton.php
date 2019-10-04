<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Ui\Component\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Review Button class.
 */
class ReviewButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get review button data.
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'id'         => 'review',
                'label'      => __('Review Estimate'),
                'on_click'   => "deleteConfirm('" . __('Review this estimate?') . "', '"
                    . $this->getReviewUrl() . "', {data: {}})",
                'class'      => 'review-button-top',
                'sort_order' => 5
            ];
        }

        return $data;
    }

    /**
     * Get delete button url.
     *
     * @return string
     */
    public function getReviewUrl(): string
    {
        return $this->getUrl('*/*/reviewindex', ['entity_id' => $this->getId()]);
    }
}
