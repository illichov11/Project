<?php


namespace Project\QuickOrder\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

use Project\QuickOrder\Api\Schema\StatusSchemaInterface;

/**
 * Class Status
 * @package Project\QuickOrder\Model\ResourceModel
 */
class Status extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(StatusSchemaInterface::TABLE_NAME, StatusSchemaInterface::STATUS_ID_COL_NAME);
    }
}