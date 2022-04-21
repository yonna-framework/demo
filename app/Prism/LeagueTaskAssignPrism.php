<?php

namespace App\Prism;


use Yonna\IO\Prism;

class LeagueTaskAssignPrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?string $order_by = null;
    protected ?int $id = null;
    protected ?array $ids = null;

    protected ?int $league_id = null;
    protected ?int $task_id = null;

    protected ?int $assign_time = null;


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
    public function getAssignTime(): ?int
    {
        return $this->assign_time;
    }

    /**
     * @param int|null $assign_time
     */
    public function setAssignTime(?int $assign_time): void
    {
        $this->assign_time = $assign_time;
    }

}