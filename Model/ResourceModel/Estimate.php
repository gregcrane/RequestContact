<?php
/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */
declare(strict_types=1);

namespace LeviathanStudios\RequestContact\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Estimate
 * @package LeviathanStudios\RequestContact\Model\ResourceModel
 */
class Estimate extends AbstractDb
{
    const ESTIMATE_TABLE = 'leviathan_contacts';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init($this::ESTIMATE_TABLE, 'entity_id');
    }
}
