<?php

namespace Project\QuickOrder\Controller\QuickOrder;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class QuickOrderSuccess extends Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}