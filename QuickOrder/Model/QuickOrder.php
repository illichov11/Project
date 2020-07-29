<?php


namespace Project\QuickOrder\Model;

use Magento\Framework\Model\AbstractModel;

use Project\QuickOrder\Api\QuickOrderInterface;
use Project\QuickOrder\Model\ResourceModel\QuickOrder as ResourceModel;

/**
 * Class QuickOrder
 * @package Project\QuickOrder\Model
 */
class QuickOrder extends AbstractModel implements QuickOrderInterface
{
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}