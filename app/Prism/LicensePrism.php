<?php

namespace App\Prism;


use Yonna\IO\Prism;

class LicensePrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?int $id = null;
    protected ?int $upper_id = null;
    protected ?string $name = null;
    protected ?array $allow_scope = null;
    protected bool $force = false;

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
     * @return array|null
     */
    public function getAllowScope(): ?array
    {
        return $this->allow_scope;
    }

    /**
     * @param array|null $allow_scope
     */
    public function setAllowScope(?array $allow_scope): void
    {
        $this->allow_scope = $allow_scope;
    }

    /**
     * @return bool
     */
    public function isForce(): bool
    {
        return $this->force;
    }

    /**
     * @param bool $force
     */
    public function setForce(bool $force): void
    {
        $this->force = $force;
    }

}