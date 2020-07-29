<?php


namespace Project\QuickOrder\Controller\Adminhtml\Status;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Edit
 * @package Project\QuickOrder\Controller\Adminhtml\Status
 */
class Edit extends Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}