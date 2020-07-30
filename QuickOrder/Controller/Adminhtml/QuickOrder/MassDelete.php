<?php


namespace Project\QuickOrder\Controller\Adminhtml\QuickOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

use Project\QuickOrder\Api\QuickOrderRepositoryInterface;

/**
 * Class MassDelete
 * @package Project\QuickOrder\Controller\Adminhtml\QuickOrder
 */
class MassDelete extends Action
{
    /** @var QuickOrderRepositoryInterface */
    private $repository;

    private $logger;

    /**
     * MassDelete constructor.
     *
     * @param Context                   $context
     * @param QuickOrderRepositoryInterface   $repository
     */
    public function __construct(
        Context $context,
        QuickOrderRepositoryInterface $repository,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->logger     = $logger;
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
        if (!$this->getRequest()->isPost()) {
            return $this->_redirect('*/*/listing');
        }

        $ids = $this->getRequest()->getParam('selected');

        if (empty($ids)) {
            $this->messageManager->addWarningMessage(__("Please select ids"));
            return $this->_redirect('*/*/listing');
        }

        foreach ($ids as $id) {
            try {
                $this->repository->deleteById($id);
            } catch (NoSuchEntityException|CouldNotDeleteException $e) {
                $this->logger->info(sprintf("item %d already delete", $id));
            }
        }

        $this->messageManager->addSuccessMessage(sprintf("items %s was deleted", implode(',', $ids)));
        $this->_redirect('*/*/listing');
    }
}