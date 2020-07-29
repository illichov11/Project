<?php

namespace Project\QuickOrder\Model\ResourceModel\QuickOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

use Project\QuickOrder\Model\ResourceModel\QuickOrder as ResourceModel;
use Project\QuickOrder\Model\QuickOrder as Model;

/**
 * Class Collection
 * @package Project\QuickOrder\Model\ResourceModel\QuickOrder
 */
class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}