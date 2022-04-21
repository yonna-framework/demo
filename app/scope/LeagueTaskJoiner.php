<?php

namespace App\Scope;

use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Foundation\Arr;
use App\Mapping\League\LeagueMemberStatus;
use App\Mapping\League\LeagueTaskStatus;
use App\Prism\LeagueTaskJoinerPrism;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class LeagueTaskJoiner
 * @package App\Scope
 */
class LeagueTaskJoiner extends AbstractScope
{

    const TABLE = 'league_task_joiner';

    /**
     * @param int $taskId
     * @return int
     * @throws Exception\DatabaseException
     */
    private function getCurrentNumber(int $taskId)
    {
        return DB::connect()->table(self::TABLE)
            ->disableCache()
            ->where(fn(Where $w) => $w->equalTo('task_id', $taskId))
            ->count('id');
    }

    /**
     * @param int $taskId
     * @return false|int
     */
    private function refreshCurrentNumber(int $taskId)
    {
        $cur = $this->getCurrentNumber($taskId);
        $one = DB::connect()->table('league_task')->field('people_number')
            ->disableCache()
            ->where(fn(Where $w) => $w->equalTo('id', $taskId))
            ->one();
        if (!$one) {
            Exception::error('task is not exist');
        }
        if ($cur > $one['league_task_people_number']) {
            Exception::error('Exceed the maximum number of people');
        }
        return DB::connect()->table('league_task')
            ->where(fn(Where $w) => $w->equalTo('id', $taskId))
            ->update(['current_number' => $cur]);
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function page(): array
    {
        $prism = new LeagueTaskJoinerPrism($this->request());
        $res = DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getIds() && $w->in('id', $prism->getIds());
                $prism->getLeagueId() && $w->equalTo('league_id', $prism->getLeagueId());
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
            })
            ->orderBy('league_id', 'desc')
            ->page($prism->getCurrent(), $prism->getPer());
        $userIds = array_column($res['list'], 'league_task_joiner_user_id');
        if ($userIds) {
            $userIds = array_unique($userIds);
            $userIds = array_values($userIds);
            $users = $this->scope(User::class, 'multi', ['ids' => $userIds]);
            $userIds = array_column($users, 'user_id');
            $users = array_combine($userIds, $users);
            foreach ($res['list'] as $k => $v) {
                $res['list'][$k]['league_task_joiner_user_info'] = $users[$v['league_task_joiner_user_id']];
            }
        }
        return $res;
    }

    /**
     * @return bool|mixed|null
     * @throws Exception\DatabaseException
     * @throws Exception\ErrorException
     * @throws \Throwable
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['task_id', 'league_id'], function ($error) {
            Exception::throw($error);
        });
        ArrayValidator::anyone($this->input(), ['user_account', 'user_id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new LeagueTaskJoinerPrism($this->request());
        if (!$prism->getUserId()) {
            $userAccount = $prism->getUserAccount();
            $one = $this->scope(UserAccount::class, 'one', ['string' => $userAccount]);
            if (!$one) {
                Exception::params('Account is not exist');
            }
            $prism->setUserId($one['user_account_user_id']);
        }
        // 检测社团是否有参加资格
        $one = DB::connect()->table('league_task_assign')
            ->where(fn(Where $w) => $w
                ->equalTo('task_id', $prism->getTaskId())
                ->equalTo('league_id', $prism->getLeagueId())
            )
            ->one();
        if (!$one) {
            Exception::error('The league does not accept this task');
        }
        // 检测是否已加入
        $one = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w
                ->equalTo('task_id', $prism->getTaskId())
                ->equalTo('user_id', $prism->getUserId())
            )->one();
        if ($one) {
            Exception::error('You have already applied, please wait for the review result.');
        }
        // 检测用户是否有加入该社团
        $one = DB::connect()->table('league_member')
            ->where(fn(Where $w) => $w
                ->equalTo('user_id', $prism->getUserId())
                ->equalTo('league_id', $prism->getLeagueId())
                ->equalTo('status', LeagueMemberStatus::APPROVED)
            )
            ->one();
        if (!$one) {
            Exception::error('Please join the league first');
        }
        $add = [
            'task_id' => $prism->getTaskId(),
            'user_id' => $prism->getUserId(),
            'league_id' => $prism->getLeagueId(),
        ];
        return DB::transTrace(function () use ($add, $prism) {
            $id = DB::connect()->table(self::TABLE)->insert($add);
            $this->refreshCurrentNumber($add['task_id']);
            return $id;
        });
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
        $one = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->one();
        if ($one) {
            DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
                ->delete();
            $this->refreshCurrentNumber($one['league_task_joiner_task_id']);
        }
        return true;
    }

    /**
     * @return array
     * @throws Exception\DatabaseException
     */
    public function attach(): array
    {
        $prism = new LeagueTaskJoinerPrism($this->request());
        $data = $prism->getAttach();
        $isPage = isset($data['page']);
        $isOne = Arr::isAssoc($data);
        if ($isPage) {
            $tmp = $data['list'];
        } elseif ($isOne) {
            $tmp = [$data];
        } else {
            $tmp = $data;
        }
        if (!$tmp) {
            return [];
        }
        $ids = array_column($tmp, 'league_task_id');
        $values = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('task_id', $ids)->equalTo('status', LeagueTaskStatus::APPROVED))
            ->multi();

        $uids = array_column($values, 'league_task_joiner_user_id');
        if ($uids) {
            $avatars = DB::connect()->table('user_meta')
                ->where(fn(Where $w) => $w->in('user_id', $uids)->equalTo('key', 'avatar'))
                ->multi();
            $avatars = array_column($avatars, 'user_meta_value', 'user_meta_user_id');
        }

        $joiners = [];
        foreach ($values as $v) {
            if (!isset($joiners[$v['league_task_joiner_task_id']])) {
                $joiners[$v['league_task_joiner_task_id']] = [];
            }
            if ($v['league_task_joiner_user_id']) {
                if (!empty($avatars[$v['league_task_joiner_user_id']])) {
                    $v['league_task_joiner_avatar'] = $avatars[$v['league_task_joiner_user_id']][0];
                } else {
                    $v['league_task_joiner_avatar'] = null;
                }
            }
            $joiners[$v['league_task_joiner_task_id']][] = $v;
        }
        unset($values);
        foreach ($tmp as $uk => $u) {
            $tmp[$uk]['league_task_joiner'] = empty($joiners[$u['league_task_id']]) ? [] : $joiners[$u['league_task_id']];
        }
        if ($isPage) {
            $data['list'] = $tmp;
            return $data;
        }
        return $isOne ? $tmp[0] : $tmp;
    }

}