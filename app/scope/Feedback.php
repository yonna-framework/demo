<?php

namespace App\Scope;

use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use App\Prism\FeedbackPrism;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class Feedback
 * @package App\Scope
 */
class Feedback extends AbstractScope
{

    const TABLE = 'feedback';

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function multi(): array
    {
        $prism = new FeedbackPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
                $prism->getContent() && $w->like('name', '%' . $prism->getContent() . '%');
                if ($prism->getAnswered() !== null) {
                    if ($prism->getAnswered()) {
                        $w->notEqualTo('answer', '');
                    } else {
                        $w->equalTo('answer', '');
                    }
                }
            })
            ->orderBy('feedback_time', 'desc')
            ->multi();
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function page(): array
    {
        $prism = new FeedbackPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
                $prism->getContent() && $w->like('name', '%' . $prism->getContent() . '%');
                $prism->getFeedbackTime() && $w->between('feedback_time', $prism->getFeedbackTime());
                $prism->getAnswerTime() && $w->between('answer_time', $prism->getAnswerTime());
                if ($prism->getAnswered() !== null) {
                    if ($prism->getAnswered()) {
                        $w->notEqualTo('answer', '');
                    } else {
                        $w->equalTo('answer', '');
                    }
                }
            })
            ->orderBy('feedback_time', 'desc')
            ->page($prism->getCurrent(), $prism->getPer());
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['content'], function ($error) {
            Exception::throw($error);
        });
        $add = [
            'user_id' => $this->request()->getLoggingId(),
            'ip' => $this->request()->getIp(),
            'content' => $this->input('content'),
            'website_url' => $this->input('website_url') || '',
            'contact_name' => $this->input('contact_name') || '',
            'contact_phone' => $this->input('contact_phone') || '',
            'remarks' => $this->input('remarks') || '',
            'feedback_time' => time(),
            'answer_time' => 0,
        ];
        return DB::connect()->table(self::TABLE)->insert($add);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function update()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $data = [
            'answer' => $this->input('answer'),
            'remarks' => $this->input('remarks'),
        ];
        if ($data) {
            return DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
                ->update($data);
        }
        return true;
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function delete()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->delete();
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function multiDelete()
    {
        ArrayValidator::required($this->input(), ['ids'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('id', $this->input('ids')))
            ->delete();
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function multiAnswer()
    {
        ArrayValidator::required($this->input(), ['answer', 'ids'], function ($error) {
            Exception::throw($error);
        });
        $data = [
            'answer' => $this->input('answer'),
            'answer_time' => time(),
        ];
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('id', $this->input('ids')))
            ->update($data);
    }

}