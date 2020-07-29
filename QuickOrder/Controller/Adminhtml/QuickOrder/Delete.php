<?php


namespace Project\QuickOrder\Controller\Adminhtml\QuickOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Project\QuickOrder\Api\QuickOrderRepositoryInterface;

class Delete extends Action
{
    /** @var QuickOrderRepositoryInterface */
    private $repository;

    /** @var LoggerInterface */
    private $logger;

    /**
     * Delete constructor.
     * @param Context $context
     * @param QuickOrderRepositoryInterface $repository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        QuickOrderRepositoryInterface $repository,
        LoggerInterface $logger
    ) {
        $this->repository   = $repository;
        $this->logger       = $logger;

        parent::__construct($context);
    }
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Project_QuickOrder::quickorder');
    }
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if (empty($id)) {
            $this->messageManager->addWarningMessage(__("Please select order id"));
            return $this->_redirect('*/*/listing');
        }

        try {
            $this->repository->deleteById($id);
        } catch (NoSuchEntityException|CouldNotDeleteException $e) {
            $this->logger->info(sprintf("item %d already delete", $id));
        }

        $this->messageManager->addSuccessMessage(sprintf("item %d was deleted", $id));
        $this->_redirect('*/*/listing');
    }
}