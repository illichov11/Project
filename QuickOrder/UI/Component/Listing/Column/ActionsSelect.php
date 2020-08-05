<?php


namespace Project\QuickOrder\UI\Component\Listing\Column;

use Magento\Framework\Option\ArrayInterface;
use Project\QuickOrder\Model\ResourceModel\Status\CollectionFactory;

class ActionsSelect implements ArrayInterface
{
    protected $status;

    public function __construct(CollectionFactory $status)
    {
        $this->status = $status;
    }

    public function getOptions()
    {
        $collection = $this->status->create();
        $items = $collection->getItems();
        $data = [];
        foreach ($items as $item) {
            $statusCode = $item->getData('status_id');
            $label = $item->getData('label');
            $data[] = ['value' => $statusCode, 'label' => __($label)];

        }
        return $data;
    }

    public function toOptionArray()
    {
        return $this->getOptions();


    }
}