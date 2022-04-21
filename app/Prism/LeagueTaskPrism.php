<?php

namespace App\Prism;


use Yonna\IO\Prism;

class LeagueTaskPrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?string $order_by = null;
    protected ?int $id = null;
    protected ?array $ids = null;
    protected ?array $not_ids = null;

    protected ?int $league_id = null;
    protected ?array $league_ids = null;
    protected ?int $user_id = null;
    protected ?string $name = null;
    protected ?string $introduction = null;
    protected ?int $current_number = null;
    protected ?int $people_number = null;
    protected ?int $start_time = null;
    protected ?int $end_time = null;
    protected ?float $points = null;

    protected ?int $status = null;
    protected ?array $statuss = null;
    protected ?string $apply_reason = null;
    protected ?string $rejection_reason = null;
    protected ?string $passed_reason = null;
    protected ?string $delete_reason = null;
    protected ?int $apply_time = null;
    protected ?int $rejection_time = null;
    protected ?int $pass_time = null;
    protected ?int $delete_time = null;

    protected ?array $event_photos = null;
    protected ?float $self_evaluation = null;
    protected ?float $platform_evaluation = null;

    protected ?int $sort = null;


    protected ?string $reason = null;
    protected bool $percent = false;

    protected bool $attach_joiner = true;

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
     * @return array|null
     */
    public function getNotIds(): ?array
    {
        return $this->not_ids;
    }

    /**
     * @param array|null $not_ids
     */
    public function setNotIds(?array $not_ids): void
    {
        $this->not_ids = $not_ids;
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
     * @return array|null
     */
    public function getLeagueIds(): ?array
    {
        return $this->league_ids;
    }

    /**
     * @param array|null $league_ids
     */
    public function setLeagueIds(?array $league_ids): void
    {
        $this->league_ids = $league_ids;
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
     * @return array|null
     */
    public function getStatuss(): ?array
    {
        return $this->statuss;
    }

    /**
     * @param array|null $statuss
     */
    public function setStatuss(?array $statuss): void
    {
        $this->statuss = $statuss;
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
     * @return string|null
     */
    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    /**
     * @param string|null $introduction
     */
    public function setIntroduction(?string $introduction): void
    {
        $this->introduction = $introduction;
    }

    /**
     * @return int|null
     */
    public function getCurrentNumber(): ?int
    {
        return $this->current_number;
    }

    /**
     * @param int|null $current_number
     */
    public function setCurrentNumber(?int $current_number): void
    {
        $this->current_number = $current_number;
    }

    /**
     * @return int|null
     */
    public function getPeopleNumber(): ?int
    {
        return $this->people_number;
    }

    /**
     * @param int|null $people_number
     */
    public function setPeopleNumber(?int $people_number): void
    {
        $this->people_number = $people_number;
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

    /**
     * @return float|null
     */
    public function getPoints(): ?float
    {
        return $this->points;
    }

    /**
     * @param float|null $points
     */
    public function setPoints(?float $points): void
    {
        $this->points = $points;
    }

    /**
     * @return string|null
     */
    public function getApplyReason(): ?string
    {
        return $this->apply_reason;
    }

    /**
     * @param string|null $apply_reason
     */
    public function setApplyReason(?string $apply_reason): void
    {
        $this->apply_reason = $apply_reason;
    }

    /**
     * @return string|null
     */
    public function getRejectionReason(): ?string
    {
        return $this->rejection_reason;
    }

    /**
     * @param string|null $rejection_reason
     */
    public function setRejectionReason(?string $rejection_reason): void
    {
        $this->rejection_reason = $rejection_reason;
    }

    /**
     * @return string|null
     */
    public function getPassedReason(): ?string
    {
        return $this->passed_reason;
    }

    /**
     * @param string|null $passed_reason
     */
    public function setPassedReason(?string $passed_reason): void
    {
        $this->passed_reason = $passed_reason;
    }

    /**
     * @return string|null
     */
    public function getDeleteReason(): ?string
    {
        return $this->delete_reason;
    }

    /**
     * @param string|null $delete_reason
     */
    public function setDeleteReason(?string $delete_reason): void
    {
        $this->delete_reason = $delete_reason;
    }

    /**
     * @return int|null
     */
    public function getApplyTime(): ?int
    {
        return $this->apply_time;
    }

    /**
     * @param int|null $apply_time
     */
    public function setApplyTime(?int $apply_time): void
    {
        $this->apply_time = $apply_time;
    }

    /**
     * @return int|null
     */
    public function getRejectionTime(): ?int
    {
        return $this->rejection_time;
    }

    /**
     * @param int|null $rejection_time
     */
    public function setRejectionTime(?int $rejection_time): void
    {
        $this->rejection_time = $rejection_time;
    }

    /**
     * @return int|null
     */
    public function getPassTime(): ?int
    {
        return $this->pass_time;
    }

    /**
     * @param int|null $pass_time
     */
    public function setPassTime(?int $pass_time): void
    {
        $this->pass_time = $pass_time;
    }

    /**
     * @return int|null
     */
    public function getDeleteTime(): ?int
    {
        return $this->delete_time;
    }

    /**
     * @param int|null $delete_time
     */
    public function setDeleteTime(?int $delete_time): void
    {
        $this->delete_time = $delete_time;
    }

    /**
     * @return array|null
     */
    public function getEventPhotos(): ?array
    {
        return $this->event_photos;
    }

    /**
     * @param array|null $event_photos
     */
    public function setEventPhotos(?array $event_photos): void
    {
        $this->event_photos = $event_photos;
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
    public function getPlatformEvaluation(): ?float
    {
        return $this->platform_evaluation;
    }

    /**
     * @param float|null $platform_evaluation
     */
    public function setPlatformEvaluation(?float $platform_evaluation): void
    {
        $this->platform_evaluation = $platform_evaluation;
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
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string|null $reason
     */
    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @return bool
     */
    public function isPercent(): bool
    {
        return $this->percent;
    }

    /**
     * @param bool $percent
     */
    public function setPercent(bool $percent): void
    {
        $this->percent = $percent;
    }

    /**
     * @return bool
     */
    public function isAttachJoiner(): bool
    {
        return $this->attach_joiner;
    }

    /**
     * @param bool $attach_joiner
     */
    public function setAttachJoiner(bool $attach_joiner): void
    {
        $this->attach_joiner = $attach_joiner;
    }

}