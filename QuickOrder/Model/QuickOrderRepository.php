<?php

namespace Project\QuickOrder\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use Project\QuickOrder\Api\Data\QuickOrderInterface;
use Project\QuickOrder\Api\QuickOrderRepositoryInterface;
use Project\QuickOrder\Model\QuickOrderFactory;
use Project\QuickOrder\Model\ResourceModel\QuickOrder as ResourceModel;
use Project\QuickOrder\Model\ResourceModel\QuickOrder\CollectionFactory;

class QuickOrderRepository implements QuickOrderRepositoryInterface
{
    /**
     * @var QuickOrderFactory
     */
    private $modelFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var ResourceModel
     */
    private $resurce;
    /**
     * @var CollectionProcessorInterface
     */
    private $processor;

    /**
     * QuickOrderRepository constructor.
     * @param ResourceModel $resurce
     * @param QuickOrderFactory $modelFactory
     * @param SearchResultsInterfaceFactory $searchResultFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceModel $resurce,
        QuickOrderFactory $modelFactory,
        SearchResultsInterfaceFactory $searchResultFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resurce             = $resurce;
        $this->modelFactory        = $modelFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionFactory   = $collectionFactory;
        $this->processor           = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): QuickOrderInterface
    {
        $quickOrder = $this->modelFactory->create();
        $this->resurce->load($quickOrder, $id);
        if (empty($quickOrder->getId())) {
            throw new NoSuchEntityException(__("QuickOrder %1 not found, $id"));
        }
        return $quickOrder;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        /** @var \Project\QuickOrder\Model\ResourceModel\QuickOrder\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->processor->process($searchCriteria, $collection);

        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();

        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setItems($collection->getItems());

        return $searchResult;
    }

    /**
     * @inheritDoc
     */
    public function save(QuickOrderInterface $quickOrder): QuickOrderInterface
    {
        try {
            $this->resurce->save($quickOrder);
        } catch (\Exception $e) {
            //added logger
            throw new CouldNotSaveException(__("QuickOrder could not save"));
        }
        return $quickOrder;
    }

    /**
     * @inheritDoc
     */
    public function delete(QuickOrderInterface $quickOrder): QuickOrderRepositoryInterface
    {
        try {
            $this->resurce->delete($quickOrder);
        } catch (\Exception $e) {
            //added logger
            throw new CouldNotDeleteException(__("QuickOrder could not delete"));
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): QuickOrderRepositoryInterface
    {
        $quickOrder = $this->getById($id);
        $this->delete($quickOrder);
        return $this;
    }
}
