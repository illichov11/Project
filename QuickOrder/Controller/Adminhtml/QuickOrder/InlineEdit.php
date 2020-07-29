<?php


namespace Project\QuickOrder\Controller\Adminhtml\QuickOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Project\QuickOrder\Model\QuickOrderFactory;

/**
 * Class InlineEdit
 * @package Project\QuickOrder\Controller\Adminhtml\QuickOrder
 */
class InlineEdit extends Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var QuickOrderFactory
     */
    protected $quickorderFactory;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param QuickOrderFactory $quickorderFactory\
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        QuickOrderFactory $quickorderFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->quickorderFactory = $quickorderFactory;
    }

    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Project_QuickOrder::quickorder');
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelid) {
                    $model = $this->quickorderFactory->create()->load($modelid);
                    try {
                        $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[QuickOrder ID: {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}