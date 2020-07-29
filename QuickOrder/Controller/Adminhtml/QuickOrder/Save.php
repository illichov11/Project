<?php


namespace Project\QuickOrder\Controller\Adminhtml\QuickOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Project\QuickOrder\Api\Data\QuickOrderInterfaceFactory;
use Project\QuickOrder\Api\QuickOrderRepositoryInterface;
use Project\QuickOrder\Model\QuickOrder;

/**
 * Class Save
 * @package Project\QuickOrder\Controller\Adminhtml\QuickOrder
 */
class Save extends Action
{
    /** @var QuickOrderRepositoryInterface */
    private $repository;

    /** @var QuickOrderInterfaceFactory */
    private $modelFactory;

    /** @var DataPersistorInterface */
    private $dataPersistor;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Context $context,
        QuickOrderRepositoryInterface $repository,
        QuickOrderInterfaceFactory $quickorderFactory,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    ) {
        $this->repository       = $repository;
        $this->modelFactory     = $quickorderFactory;
        $this->dataPersistor    = $dataPersistor;
        $this->logger           = $logger;

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
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            /** @var QuickOrder $model */
            $model = $this->modelFactory->create();

            $id = $this->getRequest()->getParam('order_id');
            if ($id) {
                try {
                    $model = $this->repository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This order no longer exists.'));
                    $resultRedirect->setPath('*/*/listing');
                }
            }

            $model->setData($data);

            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the order.'));
                $this->dataPersistor->clear('quickorder');
                return $this->processReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the user.'));
            }

            $this->dataPersistor->set('quickorder', $data);
            return $resultRedirect->setPath('*/*/edit', ['order_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/listing');
    }

    private function processReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/listing');
        }

        return $resultRedirect;
    }
}