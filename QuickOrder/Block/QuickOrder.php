<?php

namespace Project\QuickOrder\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class QuickOrder
 * @package Project\QuickOrder\Block
 */
class QuickOrder extends Template
{
    /**
     * @var Product
     */
    protected $_product;

    protected $dataPersistor;

    /**
     * QuickOrder constructor.
     * @param Template\Context $context
     * @param Product $product
     * @param DataPersistorInterface $dataPersistor
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Product $product,
        DataPersistorInterface $dataPersistor,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_product = $product;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * @return string
     */
    public function getProductSku()
    {
        $productSky = null;
        if ($this->dataPersistor->get('current_product')) {
            $productSky = $this->dataPersistor->get('current_product')->getSku();
        }
        return $productSky;
    }

    /**
     * @param $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->_product = $product;

        return $this;
    }
}
