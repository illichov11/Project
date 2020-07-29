<?php


namespace Project\QuickOrder\Api\Schema;

/**
 * Interface StatusSchemaInterface
 * @package Project\QuickOrder\Api\Schema
 */
interface StatusSchemaInterface
{
    const TABLE_NAME = 'project_status';

    const STATUS_ID_COL_NAME    = 'status_id';
    const STATUS_CODE_COL_NAME  = 'status_code';
    const STATUS_LABEL_COL_NAME = 'label';
    const IS_DELETED            = 'is_deleted';
    const IS_DEFAULT            = 'is_default';
}