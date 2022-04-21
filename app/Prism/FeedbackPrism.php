<?php

namespace App\Prism;


use Yonna\IO\Prism;

class FeedbackPrism extends Prism
{

    protected int $current = 1;
    protected int $per = 10;
    protected ?int $id = null;
    protected ?array $ids = null;
    protected ?int $user_id = null;
    protected ?string $content = null;
    protected ?string $answer = null;
    protected ?string $ip = null;
    protected ?string $website_url = null;
    protected ?string $contact_name = null;
    protected ?string $contact_phone = null;
    protected ?string $remarks = null;
    protected ?array $feedback_time = null;
    protected ?array $answer_time = null;

    protected ?bool $answered = null;

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
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * @param string|null $answer
     */
    public function setAnswer(?string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string|null
     */
    public function getWebsiteUrl(): ?string
    {
        return $this->website_url;
    }

    /**
     * @param string|null $website_url
     */
    public function setWebsiteUrl(?string $website_url): void
    {
        $this->website_url = $website_url;
    }

    /**
     * @return string|null
     */
    public function getContactName(): ?string
    {
        return $this->contact_name;
    }

    /**
     * @param string|null $contact_name
     */
    public function setContactName(?string $contact_name): void
    {
        $this->contact_name = $contact_name;
    }

    /**
     * @return string|null
     */
    public function getContactPhone(): ?string
    {
        return $this->contact_phone;
    }

    /**
     * @param string|null $contact_phone
     */
    public function setContactPhone(?string $contact_phone): void
    {
        $this->contact_phone = $contact_phone;
    }

    /**
     * @return string|null
     */
    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    /**
     * @param string|null $remarks
     */
    public function setRemarks(?string $remarks): void
    {
        $this->remarks = $remarks;
    }

    /**
     * @return array|null
     */
    public function getFeedbackTime(): ?array
    {
        return $this->feedback_time;
    }

    /**
     * @param array|null $feedback_time
     */
    public function setFeedbackTime(?array $feedback_time): void
    {
        $this->feedback_time = $feedback_time;
    }

    /**
     * @return array|null
     */
    public function getAnswerTime(): ?array
    {
        return $this->answer_time;
    }

    /**
     * @param array|null $answer_time
     */
    public function setAnswerTime(?array $answer_time): void
    {
        $this->answer_time = $answer_time;
    }

    /**
     * @return bool|null
     */
    public function getAnswered(): ?bool
    {
        return $this->answered;
    }

    /**
     * @param bool|null $answered
     */
    public function setAnswered(?bool $answered): void
    {
        $this->answered = $answered;
    }

}