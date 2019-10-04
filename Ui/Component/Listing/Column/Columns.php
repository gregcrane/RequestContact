<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Ui\Component\Listing\Column;

use Magento\Customer\Ui\Component\ColumnFactory;
use Magento\Customer\Ui\Component\Listing\Column\InlineEditUpdater;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns as UiColumns;

/**
 * Estimate list columns class.
 */
class Columns extends UiColumns
{
    /**
     * @var int $columnSortOrder
     */
    protected $columnSortOrder;

    /**
     * @var InlineEditUpdater
     */
    protected $inlineEditUpdater;

    /**
     * @var ColumnFactory $columnFactory
     */
    protected $columnFactory;

    /**
     * @var array
     */
    protected $filterMap = [
        'default'     => 'text',
        'select'      => 'select',
        'boolean'     => 'select',
        'multiselect' => 'select',
        'date'        => 'dateRange',
    ];

    /**
     * @param ContextInterface  $context
     * @param ColumnFactory     $columnFactory
     * @param InlineEditUpdater $inlineEditor
     * @param array             $components
     * @param array             $data
     */
    public function __construct(
        ContextInterface $context,
        ColumnFactory $columnFactory,
        InlineEditUpdater $inlineEditor,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);
        $this->columnFactory     = $columnFactory;
        $this->inlineEditUpdater = $inlineEditor;
    }

    /**
     * @return int
     */
    protected function getDefaultSortOrder()
    {
        $max = 0;
        foreach ($this->components as $component) {
            $config = $component->getData('config');
            if (isset($config['sortOrder']) && $config['sortOrder'] > $max) {
                $max = $config['sortOrder'];
            }
        }
        return ++$max;
    }

    /**
     * Update actions column sort order
     *
     * @return void
     */
    protected function updateActionColumnSortOrder()
    {
        if (isset($this->components['actions'])) {
            $component = $this->components['actions'];
            $component->setData(
                'config',
                array_merge($component->getData('config'), ['sortOrder' => ++$this->columnSortOrder])
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepare()
    {
        $this->columnSortOrder = $this->getDefaultSortOrder();
        $this->updateActionColumnSortOrder();
        parent::prepare();
    }


    /**
     * Retrieve filter type by $frontendInput
     *
     * @param string $frontendInput
     * @return string
     */
    protected function getFilterType($frontendInput)
    {
        return isset($this->filterMap[$frontendInput]) ? $this->filterMap[$frontendInput] : $this->filterMap['default'];
    }
}
