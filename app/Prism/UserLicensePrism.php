<?php

namespace App\Prism;


use Yonna\IO\Prism;

class UserLicensePrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?int $user_id = null;
    protected ?int $license_id = null;
    protected ?int $start_time = null;
    protected ?int $end_time = null;

    /**
     * @return int
     */
    public function getCurrent(): int
    {
        return $this->current;
    }

    /**
     * @param int $current
     */
    public function setCurrent(int $current): void
    {
        $this->current = $current;
    }

    /**
     * @return int
     */
    public function getPer(): int
    {
        return $this->per;
    }

    /**
     * @param int $per
     */
    public function setPer(int $per): void
    {
        $this->per = $per;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     */
    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int|null
     */
    public function getLicenseId(): ?int
    {
        return $this->license_id;
    }

    /**
     * @param int|null $license_id
     */
    public function setLicenseId(?int $license_id): void
    {
        $this->license_id = $license_id;
    }

    /**
     * @return int|null
     */
    public function getStartTime(): ?int
    {
        return $this->start_time;
    }

    /**
     * @param int|null $start_time
     */
    public function setStartTime(?int $start_time): void
    {
        $this->start_time = $start_time;
    }

    /**
     * @return int|null
     */
    public function getEndTime(): ?int
    {
        return $this->end_time;
    }

    /**
     * @param int|null $end_time
     */
    public function setEndTime(?int $end_time): void
    {
        $this->end_time = $end_time;
    }

}