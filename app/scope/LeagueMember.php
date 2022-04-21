<?php

namespace App\Scope;

use Throwable;
use Yonna\Foundation\Arr;
use App\Mapping\League\LeagueMemberStatus;
use App\Mapping\League\LeagueStatus;
use App\Prism\LeagueMemberPrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class LeagueMember
 * @package App\Scope
 */
class LeagueMember extends AbstractScope
{

    const TABLE = 'league_member';

    /**
     * 获取详情
     * @return array
     * @throws Exception\DatabaseException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new LeagueMemberPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
            })
            ->one();
    }

    /**
     * @return array
     * @throws Exception\DatabaseException
     * @throws Exception\ThrowException
     */
    public function multi(): array
    {
        $prism = new LeagueMemberPrism($this->request());
        $res = DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getIds() && $w->in('id', $prism->getIds());
                $prism->getLeagueId() && $w->equalTo('league_id', $prism->getLeagueId());
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
                $prism->getPermission() && $w->equalTo('permission', $prism->getPermission());
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
                $prism->getStatuss() && $w->in('status', $prism->getStatuss());
            })
            ->orderBy('league_id', 'desc')
            ->multi();
        $userIds = array_column($res, 'league_member_user_id');
        if ($userIds) {
            $userIds = array_unique($userIds);
            $userIds = array_values($userIds);
            $users = $this->scope(User::class, 'multi', ['ids' => $userIds]);
            $userIds = array_column($users, 'user_id');
            $users = array_combine($userIds, $users);
            foreach ($res as $k => $v) {
                $res[$k]['league_member_user_info'] = $users[$v['league_member_user_id']];
            }
        }
        return $res;
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function page(): array
    {
        $prism = new LeagueMemberPrism($this->request());
        $res = DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getIds() && $w->in('id', $prism->getIds());
                $prism->getLeagueId() && $w->equalTo('league_id', $prism->getLeagueId());
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
                $prism->getPermission() && $w->equalTo('permission', $prism->getPermission());
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
            })
            ->orderBy('league_id', 'desc')
            ->page($prism->getCurrent(), $prism->getPer());
        $userIds = array_column($res['list'], 'league_member_user_id');
        if ($userIds) {
            $userIds = array_unique($userIds);
            $userIds = array_values($userIds);
            $users = $this->scope(User::class, 'multi', ['ids' => $userIds]);
            $userIds = array_column($users, 'user_id');
            $users = array_combine($userIds, $users);
            foreach ($res['list'] as $k => $v) {
                $res['list'][$k]['league_member_user_info'] = $users[$v['league_member_user_id']];
            }
        }
        return $res;
    }

    /**
     * @return bool|mixed|null
     * @throws Exception\DatabaseException
     * @throws Throwable
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['league_id', 'permission'], function ($error) {
            Exception::throw($error);
        });
        ArrayValidator::anyone($this->input(), ['user_account', 'user_id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new LeagueMemberPrism($this->request());
        if ($prism->getUserAccount()) {
            $one = $this->scope(UserAccount::class, 'one', ['string' => $prism->getUserAccount()]);
            if (!$one) {
                Exception::params('Account is not exist');
            }
            $prism->setUserId($one['user_account_user_id']);
        }
        $one = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w
                ->equalTo('league_id', $prism->getLeagueId())
                ->equalTo('user_id', $prism->getUserId())
                ->notEqualTo('status', LeagueMemberStatus::DELETE)
            )
            ->one();
        if ($one) {
            Exception::params('User already holds a position in the organization');
        }
        $add = [
            'league_id' => $prism->getLeagueId(),
            'user_id' => $prism->getUserId(),
            'permission' => $prism->getPermission(),
            'status' => $prism->getStatus() ?? LeagueStatus::PENDING,
            'apply_reason' => $prism->getApplyReason() ?? '',
            'apply_time' => time(),
            'rejection_time' => 0,
            'pass_time' => 0,
            'delete_time' => 0,
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
        $prism = new LeagueMemberPrism($this->request());
        $one = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $prism->getId()))
            ->one();
        if (!$one) {
            return 0;
        }
        $data = [
            'permission' => $prism->getPermission(),
            'status' => $prism->getStatus(),
        ];
        switch ($prism->getStatus()) {
            case LeagueStatus::REJECTION:
                $data['rejection_time'] = time();
                $data['rejection_reason'] = $prism->getReason();
                break;
            case LeagueStatus::APPROVED:
                $data['pass_time'] = time();
                $data['pass_reason'] = $prism->getReason();
                break;
            case LeagueStatus::DELETE:
                $data['delete_time'] = time();
                $data['delete_reason'] = $prism->getReason();
                break;
        }
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $prism->getId()))
            ->update($data);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function status()
    {
        ArrayValidator::required($this->input(), ['id', 'status'], function ($error) {
            Exception::throw($error);
        });
        $status = $this->input('status');
        $reason = $this->input('reason');
        $data = ['status' => $status];
        switch ($status) {
            case LeagueStatus::REJECTION:
                $data['rejection_time'] = time();
                $data['rejection_reason'] = $reason;
                break;
            case LeagueStatus::APPROVED:
                $data['pass_time'] = time();
                $data['pass_reason'] = $reason;
                break;
            case LeagueStatus::DELETE:
                $data['delete_time'] = time();
                $data['delete_reason'] = $reason;
                break;
        }
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->update($data);
    }

    /**
     * @return false|int
     * @throws Exception\DatabaseException
     */
    public function multiStatus()
    {
        ArrayValidator::required($this->input(), ['ids', 'status'], function ($error) {
            Exception::throw($error);
        });
        $status = $this->input('status');
        $reason = $this->input('reason');
        $data = ['status' => $status];
        switch ($status) {
            case LeagueStatus::REJECTION:
                $data['rejection_time'] = time();
                $data['rejection_reason'] = $reason;
                break;
            case LeagueStatus::APPROVED:
                $data['pass_time'] = time();
                $data['pass_reason'] = $reason;
                break;
            case LeagueStatus::DELETE:
                $data['delete_time'] = time();
                $data['delete_reason'] = $reason;
                break;
        }
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('id', $this->input('ids')))
            ->update($data);
    }

    /**
     * @return false|int
     */
    public function delete()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return $this->scope(self::class, 'status', [
            'id' => $this->input('id'),
            'status' => LeagueMemberStatus::DELETE,
        ]);
    }

    /**
     * @return array
     * @throws Exception\DatabaseException
     */
    public function attach(): array
    {
        $prism = new LeagueMemberPrism($this->request());
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
        $ids = array_column($tmp, 'league_id');
        $values = DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($ids, $prism) {
                $w->in('league_id', $ids)->equalTo('status', LeagueMemberStatus::APPROVED);
                if ($prism->getUserId()) {
                    $w->equalTo('user_id', $prism->getUserId());
                }
            })
            ->multi();
        $datas = [];
        foreach ($values as $v) {
            if (!isset($datas[$v['league_member_league_id']])) {
                $datas[$v['league_member_league_id']] = [];
            }
            $datas[$v['league_member_league_id']][] = $v;
        }
        unset($values);
        foreach ($tmp as $uk => $u) {
            $tmp[$uk]['league_member'] = empty($datas[$u['league_id']]) ? [] : $datas[$u['league_id']];
        }
        if ($isPage) {
            $data['list'] = $tmp;
            return $data;
        }
        return $isOne ? $tmp[0] : $tmp;
    }


}