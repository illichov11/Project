<?php


namespace Project\QuickOrder\Block\Adminhtml\Status\Edit;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Project\QuickOrder\Block\Adminhtml\QuickOrder\Edit\GenericButton;

class DeleteStatusButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getEntityId()) {
            $data = [
                'label' => __('Delete Status'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * URL to send delete requests to.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getEntityId()]);
    }
}