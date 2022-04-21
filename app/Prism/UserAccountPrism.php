<?php

namespace App\Prism;


use Yonna\IO\Prism;

class UserAccountPrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?int $id = null;
    protected ?int $user_id = null;
    protected ?string $type = null;
    protected ?string $string = null;
    protected ?int $allow_login = null;
    protected ?array $attach = null;

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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getString(): ?string
    {
        return $this->string;
    }

    /**
     * @param string|null $string
     */
    public function setString(?string $string): void
    {
        $this->string = $string;
    }

    /**
     * @return int|null
     */
    public function getAllowLogin(): ?int
    {
        return $this->allow_login;
    }

    /**
     * @param int|null $allow_login
     */
    public function setAllowLogin(?int $allow_login): void
    {
        $this->allow_login = $allow_login;
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

}