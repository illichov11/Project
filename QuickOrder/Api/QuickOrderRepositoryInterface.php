<?php


namespace Project\QuickOrder\Api;


use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;

use Project\QuickOrder\Api\Data\QuickOrderInterface;

/**
 * Interface QuickOrderRepositoryInterface
 * @package Project\QuickOrder\Api
 */
interface QuickOrderRepositoryInterface
{
    /**
     * @param int $id
     * @throws NoSuchEntityException
     * @return QuickOrderInterface
     */
    public function getById(int $id) : QuickOrderInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria) : SearchResultsInterface;

    /**
     * @param QuickOrderInterface $quickOrder
     * @return QuickOrderInterface
     */
    public function save(QuickOrderInterface $quickOrder) : QuickOrderInterface;

    /**
     * @param QuickOrderInterface $quickOrder
     * @return QuickOrderRepositoryInterface
     */
    public function delete(QuickOrderInterface $quickOrder) : QuickOrderRepositoryInterface;

    /**
     * @param int $id
     * @return QuickOrderRepositoryInterface
     */
    public function deleteById(int $id) : QuickOrderRepositoryInterface;

}