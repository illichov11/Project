<?php


namespace Project\QuickOrder\Model;

use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;

use Psr\Log\LoggerInterface;

use Project\QuickOrder\Api\Data\StatusInterface;
use Project\QuickOrder\Api\Data\StatusInterfaceFactory;
use Project\QuickOrder\Api\StatusRepositoryInterface;
use Project\QuickOrder\Model\ResourceModel\Status as ResourceModel;
use Project\QuickOrder\Model\ResourceModel\Status\CollectionFactory;
use Project\QuickOrder\Api\Data\StatusSearchResultInterfaceFactory;
use Project\QuickOrder\Model\StatusFactory;



class StatusRepository implements StatusRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var StatusFactory
     */
    private $modelFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ResourceModel $resourceModel,
        StatusInterfaceFactory $statusInterfaceFactory,
        CollectionFactory $collectionFactory,
        StatusSearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor,
        LoggerInterface $logger
    ) {
        $this->resourceModel        = $resourceModel;
        $this->modelFactory         = $statusInterfaceFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultFactory  = $searchResultFactory;
        $this->collectionProcessor  = $collectionProcessor;
        $this->logger               = $logger;
    }

    /**
     * @param int $id
     * @return StatusInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): StatusInterface
    {
        $model = $this->modelFactory->create();

        $this->resourceModel->load($model, $id);

        if (null === $model->getId()) {
            throw new NoSuchEntityException(__('Model with %1 not found', $id));
        }

        return $model;
    }

    /**
     * @return SearchResultsInterface
     */
    public function getList():SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultFactory->create();

        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getData());

        return $searchResult;
    }

    /**
     * @param StatusInterface $status
     * @return StatusInterface
     * @throws CouldNotSaveException
     */
    public function save(StatusInterface $status): StatusInterface
    {
        try {
            $this->resourceModel->save($status);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__("Status not saved"));
        }

        return  $status;
    }

    /**
     * @param StatusInterface $status
     * @return StatusRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function delete(StatusInterface $status): StatusRepositoryInterface
    {
        try {
            $this->resourceModel->delete($status);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__("Status %1 not deleted", $status->getId()));
        }
        return $this;
    }

    /**
     * @param int $id
     * @return StatusRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): StatusRepositoryInterface
    {
        try {
            $status = $this->getById($id);
            $this->delete($status);
        } catch (NoSuchEntityException $e) {
            $this->logger->warning(sprintf("Status %d already deleted or not found", $id));
        }

        return $this;
    }
}
