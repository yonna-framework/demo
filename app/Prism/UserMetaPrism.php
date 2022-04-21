<?php

namespace App\Prism;


use Yonna\IO\Prism;

class UserMetaPrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?int $user_id = null;
    protected ?string $key = null;
    protected ?string $value = null;
    protected ?array $attach = null;
    protected ?array $metas = null;

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
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     */
    public function setKey(?string $key): void
    {
        $this->key = $key;
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
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return array|null
     */
    public function getAttach(): ?array
    {
        return $this->attach;
    }

    /**
     * @param array|null $attach
     */
    public function setAttach(?array $attach): void
    {
        $this->attach = $attach;
    }

    /**
     * @return array|null
     */
    public function getMetas(): ?array
    {
        return $this->metas;
    }

    /**
     * @param array|null $metas
     */
    public function setMetas(?array $metas): void
    {
        $this->metas = $metas;
    }

}