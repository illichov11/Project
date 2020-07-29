<?php


namespace Project\QuickOrder\Api\Data;

/**
 * Interface StatusInterface
 * @package Project\QuickOrder\Api\Data
 */
interface StatusInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param string $code
     * @return StatusInterface
     */
    public function setStatusCode(string $code): StatusInterface;

    /**
     * @return string
     */
    public function getStatusCode(): string;

    /**
     * @param string $label
     * @return StatusInterface
     */
    public function setLabel(string $label): StatusInterface;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param bool $default
     * @return StatusInterface
     */
    public function setIsDefault(bool $default): StatusInterface;

    /**
     * @return bool
     */
    public function getIsDefault(): bool;

    /**
     * @param bool $deleted
     * @return StatusInterface
     */
    public function setIsDeleted(bool $deleted): StatusInterface;

    /**
     * @return bool
     */
    public function getIsDeleted(): bool;

}