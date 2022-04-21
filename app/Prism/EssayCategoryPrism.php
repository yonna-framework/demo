<?php

namespace App\Prism;


use Yonna\IO\Prism;

class EssayCategoryPrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?int $id = null;
    protected ?int $upper_id = null;
    protected ?int $user_id = null;
    protected ?array $ids = null;
    protected ?string $name = null;
    protected ?array $logo = null;
    protected ?int $status = null;

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
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getUpperId(): ?int
    {
        return $this->upper_id;
    }

    /**
     * @param int|null $upper_id
     */
    public function setUpperId(?int $upper_id): void
    {
        $this->upper_id = $upper_id;
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
     * @return array|null
     */
    public function getIds(): ?array
    {
        return $this->ids;
    }

    /**
     * @param array|null $ids
     */
    public function setIds(?array $ids): void
    {
        $this->ids = $ids;
    }

    /**
     * @return array|null
     */
    public function getLogo(): ?array
    {
        return $this->logo;
    }

    /**
     * @param array|null $logo
     */
    public function setLogo(?array $logo): void
    {
        $this->logo = $logo;
    }

}