<?php


namespace Project\QuickOrder\Controller\Adminhtml\Status;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Project\QuickOrder\Api\StatusRepositoryInterface;

/**
 * Class Delete
 * @package Project\QuickOrder\Controller\Adminhtml\Status
 */
class Delete extends Action
{
    /** @var StatusRepositoryInterface */
    private $repository;

    /** @var LoggerInterface */
    private $logger;

    /**
     * Delete constructor.
     * @param Context $context
     * @param StatusRepositoryInterface $repository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StatusRepositoryInterface $repository,
        LoggerInterface $logger
    )
    {
        $this->repository = $repository;
        $this->logger = $logger;

        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if (empty($id)) {
            $this->messageManager->addWarningMessage(__("Please select status id"));
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