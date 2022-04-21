<?php

namespace App\Prism;


use Yonna\IO\Prism;

class LeaguePrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?string $order_by = null;
    protected ?int $id = null;
    protected ?array $ids = null;
    protected ?array $not_ids = null;
    protected ?string $master_user_account = null;
    protected ?int $master_user_id = null;
    protected ?string $name = null;
    protected ?string $slogan = null;
    protected ?string $introduction = null;
    protected ?array $logo_pic = null;
    protected ?array $business_license_pic = null;
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
    protected ?int $sort = null;

    protected ?array $hobby = null;
    protected ?array $work = null;
    protected ?array $speciality = null;

    protected ?string $reason = null;

    protected ?int $user_id = null;
    protected bool $attach_hobby = true;
    protected bool $attach_work = true;
    protected bool $attach_speciality = true;
    protected bool $attach_member = false;

    protected ?string $user_account = null;

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
    public function getMasterUserId(): ?int
    {
        return $this->master_user_id;
    }

    /**
     * @param int|null $master_user_id
     */
    public function setMasterUserId(?int $master_user_id): void
    {
        $this->master_user_id = $master_user_id;
    }

    /**
     * @return string|null
     */
    public function getMasterUserAccount(): ?string
    {
        return $this->master_user_account;
    }

    /**
     * @param string|null $master_user_account
     */
    public function setMasterUserAccount(?string $master_user_account): void
    {
        $this->master_user_account = $master_user_account;
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
    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    /**
     * @param string|null $slogan
     */
    public function setSlogan(?string $slogan): void
    {
        $this->slogan = $slogan;
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
     * @return array|null
     */
    public function getLogoPic(): ?array
    {
        return $this->logo_pic;
    }

    /**
     * @param array|null $logo_pic
     */
    public function setLogoPic(?array $logo_pic): void
    {
        $this->logo_pic = $logo_pic;
    }

    /**
     * @return array|null
     */
    public function getBusinessLicensePic(): ?array
    {
        return $this->business_license_pic;
    }

    /**
     * @param array|null $business_license_pic
     */
    public function setBusinessLicensePic(?array $business_license_pic): void
    {
        $this->business_license_pic = $business_license_pic;
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
     * @return array|null
     */
    public function getHobby(): ?array
    {
        return $this->hobby;
    }

    /**
     * @param array|null $hobby
     */
    public function setHobby(?array $hobby): void
    {
        $this->hobby = $hobby;
    }

    /**
     * @return array|null
     */
    public function getWork(): ?array
    {
        return $this->work;
    }

    /**
     * @param array|null $work
     */
    public function setWork(?array $work): void
    {
        $this->work = $work;
    }

    /**
     * @return array|null
     */
    public function getSpeciality(): ?array
    {
        return $this->speciality;
    }

    /**
     * @param array|null $speciality
     */
    public function setSpeciality(?array $speciality): void
    {
        $this->speciality = $speciality;
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
     * @return bool
     */
    public function isAttachHobby(): bool
    {
        return $this->attach_hobby;
    }

    /**
     * @param bool $attach_hobby
     */
    public function setAttachHobby(bool $attach_hobby): void
    {
        $this->attach_hobby = $attach_hobby;
    }

    /**
     * @return bool
     */
    public function isAttachWork(): bool
    {
        return $this->attach_work;
    }

    /**
     * @param bool $attach_work
     */
    public function setAttachWork(bool $attach_work): void
    {
        $this->attach_work = $attach_work;
    }

    /**
     * @return bool
     */
    public function isAttachSpeciality(): bool
    {
        return $this->attach_speciality;
    }

    /**
     * @param bool $attach_speciality
     */
    public function setAttachSpeciality(bool $attach_speciality): void
    {
        $this->attach_speciality = $attach_speciality;
    }

    /**
     * @return bool
     */
    public function isAttachMember(): bool
    {
        return $this->attach_member;
    }

    /**
     * @param bool $attach_member
     */
    public function setAttachMember(bool $attach_member): void
    {
        $this->attach_member = $attach_member;
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