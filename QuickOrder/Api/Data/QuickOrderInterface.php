<?php

namespace Project\QuickOrder\Api\Data;

/**
 * Interface QuickOrderInterface
 * @package Project\QuickOrder\Api\Data
 */
interface QuickOrderInterface
{

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param string $name
     * @return QuickOrderInterface
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param int $phone
     * @return QuickOrderInterface
     */
    public function setPhone(int $phone);

    /**
     * @return mixed
     */
    public function getPhone();

    /**
     * @param string $email
     * @return QuickOrderInterface
     */
    public function setEmail(string $email);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $sku
     * @return QuickOrderInterface
     */
    public function setSku(string $sku);

    /**
     * @return string
     */
    public function getSku();

    /**
     * @param StatusInterface $status
     * @return QuickOrderInterface
     */
    public function setStatus(StatusInterface $status);

    /**
     * @return StatusInterface
     */
    public function getStatus();

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt();

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt();
}


