<?php


namespace Project\QuickOrder\Block\Adminhtml\QuickOrder\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

use Project\QuickOrder\Api\QuickOrderRepositoryInterface;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var QuickOrderRepositoryInterface
     */
    protected $repository;

    /**
     * @param Context $context
     * @param QuickOrderRepositoryInterface $blockRepository
     */
    public function __construct(
        Context $context,
        QuickOrderRepositoryInterface $blockRepository
    )
    {
        $this->context = $context;
        $this->repository = $blockRepository;
    }

    /**
     * @return |null
     * @throws NoSuchEntityException
     */
    public function getEntityId()
    {
        if ($this->context->getRequest()->getParam('id')) {
            return $this->repository->getById($this->context->getRequest()->getParam('id'))->getId();
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}