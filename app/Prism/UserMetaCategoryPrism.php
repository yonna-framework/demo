<?php

namespace App\Prism;


use Yonna\IO\Prism;

class UserMetaCategoryPrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?string $key = null;
    protected ?string $label = null;
    protected ?string $value_format = null;
    protected ?string $value_default = null;
    protected ?string $component = null;
    protected ?int $status = null;
    protected ?int $sort = null;

    protected bool $bind_data = false;

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
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     */
    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string|null
     */
    public function getValueFormat(): ?string
    {
        return $this->value_format;
    }

    /**
     * @param string|null $value_format
     */
    public function setValueFormat(?string $value_format): void
    {
        $this->value_format = $value_format;
    }

    /**
     * @return string|null
     */
    public function getValueDefault(): ?string
    {
        return $this->value_default;
    }

    /**
     * @param string|null $value_default
     */
    public function setValueDefault(?string $value_default): void
    {
        $this->value_default = $value_default;
    }

    /**
     * @return string|null
     */
    public function getComponent(): ?string
    {
        return $this->component;
    }

    /**
     * @param string|null $component
     */
    public function setComponent(?string $component): void
    {
        $this->component = $component;
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
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     */
    public function setSort(?int $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return bool
     */
    public function isBindData(): bool
    {
        return $this->bind_data;
    }

    /**
     * @param bool $bind_data
     */
    public function setBindData(bool $bind_data): void
    {
        $this->bind_data = $bind_data;
    }


}