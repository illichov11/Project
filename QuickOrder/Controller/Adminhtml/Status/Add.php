<?php

namespace Project\QuickOrder\Controller\Adminhtml\Status;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Add extends Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}