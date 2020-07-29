<?php

namespace Project\QuickOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class QuickOrder
 * @package Project\QuickOrder\Model\ResourceModel
 */
class QuickOrder extends AbstractDb
{
    public function _construct()
    {
        $this->_init('project_quickorder', 'order_id');
    }

}