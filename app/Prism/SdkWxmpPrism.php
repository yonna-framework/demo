<?php

namespace App\Prism;


use Yonna\IO\Prism;

class SdkWxmpPrism extends Prism
{

    protected ?string $behaviour = null;
    protected ?string $return_url = null;
    protected ?string $code = null;
    protected array $extra = [];
    protected ?string $state = null;

    /**
     * @return string|null
     */
    public function getBehaviour(): ?string
    {
        return $this->behaviour;
    }

    /**
     * @param string|null $behaviour
     */
    public function setBehaviour(?string $behaviour): void
    {
        $this->behaviour = $behaviour;
    }

    /**
     * @return string|null
     */
    public function getReturnUrl(): ?string
    {
        return $this->return_url;
    }

    /**
     * @param string|null $return_url
     */
    public function setReturnUrl(?string $return_url): void
    {
        $this->return_url = $return_url;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     */
    public function setExtra(array $extra): void
    {
        $this->extra = $extra;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

}