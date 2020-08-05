<?php

namespace Project\QuickOrder\Controller\QuickOrder;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;
use Project\QuickOrder\Api\Data\QuickOrderInterfaceFactory;
use Project\QuickOrder\Api\QuickOrderRepositoryInterface;
use Project\QuickOrder\Model\Status;
use Project\QuickOrder\Controller\QuickOrder\QuickOrderSuccess;
class QuickOrderCreate extends Action
{
    protected $repository;
    protected $quickorderFactory;
    protected $_jsonFactory;
    protected $_logger;
    protected $modelStatus;
    public function __construct(
        Status  $modelStatus,
        Context $context,
        QuickOrderRepositoryInterface $repository,
        QuickOrderInterfaceFactory $quickorderFactory,
        JsonFactory $resultJsonFactory,
        LoggerInterface $logger
    ) {
        $this->modelStatus = $modelStatus;
        $this->repository = $repository;
        $this->_jsonFactory = $resultJsonFactory;
        $this->quickorderFactory = $quickorderFactory;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->_jsonFactory->create();
        //$errors = $this->_validationHelper->validateFastorder();
        if (empty($errors)) {
            try {
                $params = $this->getRequest()->getParams();
                $model = $this->quickorderFactory->create();
                $defaultStatus = $this->modelStatus->getCollection()->addFieldToFilter('is_default', ['eq' => '1'])->load()->getFirstItem();
                $statusCode = $defaultStatus->getData('status_id');
                $model->setData($params);
                $model->setData('status', $statusCode);
                $this->repository->save($model);
                return  $this->_redirect('*/*/quickordersuccess/');
            } catch (\Exception $e) {
                $this->_logger->logException($e);
                $response = $this->_getErrorResponse([$e->getMessage()]);
            }
        } else {
            $response = $this->_getErrorResponse($errors);
            return $result->setData($response);
        }

        return $result->setData($response);
    }

    /**
     * prepare error response
     * for checkout
     * @param $errors
     * @return array
     */
    protected function _getErrorResponse($errors)
    {
        $response =
            [
                'is_error' => true,
                'messages' => $errors,
                'is_success' => false
            ];
        return $response;
    }

}