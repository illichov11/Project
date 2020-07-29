<?php


namespace Project\QuickOrder\Controller\Adminhtml\Status;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Project\QuickOrder\Api\Data\StatusInterfaceFactory;
use Project\QuickOrder\Api\StatusRepositoryInterface;
use Project\QuickOrder\Model\Status;

class Save extends Action
{
    /** @var StatusRepositoryInterface */
    private $repository;

    /** @var StatusInterfaceFactory */
    private $modelFactory;

    /** @var DataPersistorInterface */
    private $dataPersistor;

    /** @var LoggerInterface */
    private $logger;

    /**
     * Save constructor.
     * @param Context $context
     * @param StatusRepositoryInterface $repository
     * @param StatusInterfaceFactory $statusFactory
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StatusRepositoryInterface $repository,
        StatusInterfaceFactory $statusFactory,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    )
    {
        $this->repository = $repository;
        $this->modelFactory = $statusFactory;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;

        parent::__construct($context);
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
            /** @var Status $model */
            $model = $this->modelFactory->create();

            $id = $this->getRequest()->getParam('status_id');
            if ($id) {
                try {
                    $model = $this->repository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This status no longer exists.'));
                    $resultRedirect->setPath('*/*/listing');
                }
            }

            if ($data['is_default'] == 1) {
                $defaultStatus = $model->getCollection()->addFieldToFilter('is_default', ['eq' => '1'])->load()->getFirstItem();
                if ($defaultStatus->getId() !== $id) {
                    $defaultStatus->setData('is_default', '0')->save();
                }
            }

            $model->setData($data);

            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the status.'));
                $this->dataPersistor->clear('status');
                return $this->processReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the status.'));
            }

            $this->dataPersistor->set('status', $data);
            return $resultRedirect->setPath('*/*/edit', ['status_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/listing');
    }

    /**
     * @param $model
     * @param $data
     * @param $resultRedirect
     * @return mixed
     */
    private function processReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/listing');
        }

        return $resultRedirect;
    }
}