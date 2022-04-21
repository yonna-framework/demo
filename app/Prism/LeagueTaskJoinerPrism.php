<?php

namespace App\Prism;


use Yonna\IO\Prism;

class LeagueTaskJoinerPrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?string $order_by = null;
    protected ?int $id = null;
    protected ?array $ids = null;

    protected ?int $task_id = null;
    protected ?int $user_id = null;
    protected ?int $league_id = null;
    protected ?float $self_evaluation = null;
    protected ?float $league_evaluation = null;

    protected ?string $user_account = null;
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
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->order_by;
    }

    /**
     * @param string|null $order_by
     */
    public function setOrderBy(?string $order_by): void
    {
        $this->order_by = $order_by;
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
     * @return int|null
     */
    public function getLeagueId(): ?int
    {
        return $this->league_id;
    }

    /**
     * @param int|null $league_id
     */
    public function setLeagueId(?int $league_id): void
    {
        $this->league_id = $league_id;
    }

    /**
     * @return int|null
     */
    public function getTaskId(): ?int
    {
        return $this->task_id;
    }

    /**
     * @param int|null $task_id
     */
    public function setTaskId(?int $task_id): void
    {
        $this->task_id = $task_id;
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
     * @return float|null
     */
    public function getSelfEvaluation(): ?float
    {
        return $this->self_evaluation;
    }

    /**
     * @param float|null $self_evaluation
     */
    public function setSelfEvaluation(?float $self_evaluation): void
    {
        $this->self_evaluation = $self_evaluation;
    }

    /**
     * @return float|null
     */
    public function getLeagueEvaluation(): ?float
    {
        return $this->league_evaluation;
    }

    /**
     * @param float|null $league_evaluation
     */
    public function setLeagueEvaluation(?float $league_evaluation): void
    {
        $this->league_evaluation = $league_evaluation;
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
     * @return string|null
     */
    public function getUserAccount(): ?string
    {
        return $this->user_account;
    }

    /**
     * @param string|null $user_account
     */
    public function setUserAccount(?string $user_account): void
    {
        $this->user_account = $user_account;
    }

}