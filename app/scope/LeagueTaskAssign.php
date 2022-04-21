<?php

namespace App\Scope;

use Throwable;
use App\Prism\LeagueTaskAssignPrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class LeagueTaskAssign
 * @package App\Scope
 */
class LeagueTaskAssign extends AbstractScope
{

    const TABLE = 'league_task_assign';

    /**
     * @return array
     * @throws Exception\DatabaseException
     * @throws Exception\ThrowException
     */
    public function multi(): array
    {
        $prism = new LeagueTaskAssignPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getTaskId() && $w->equalTo('task_id', $prism->getTaskId());
                $prism->getIds() && $w->in('id', $prism->getIds());
                $prism->getLeagueId() && $w->equalTo('league_id', $prism->getLeagueId());
            })
            ->orderBy('league_id', 'desc')
            ->multi();
    }

    /**
     * @return int
     * @throws Throwable
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['task_id', 'league_id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new LeagueTaskAssignPrism($this->request());
        $one = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w
                ->equalTo('task_id', $prism->getTaskId())
                ->equalTo('league_id', $prism->getLeagueId())
            )
            ->one();
        if ($one) {
            Exception::error('Task Assignment');
        }
        $add = [
            'task_id' => $prism->getTaskId(),
            'league_id' => $prism->getLeagueId(),
            'assign_time' => time(),
        ];
        return DB::connect()->table(self::TABLE)->insert($add);
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

}