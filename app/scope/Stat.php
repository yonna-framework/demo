<?php

namespace App\Scope;

use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use App\Mapping\Data\DataStatus;
use App\Mapping\Essay\EssayCategoryStatus;
use App\Mapping\Essay\EssayStatus;
use App\Mapping\League\LeagueMemberPermission;
use App\Mapping\League\LeagueStatus;
use App\Mapping\League\LeagueTaskStatus;
use App\Mapping\User\AccountType;
use App\Mapping\User\UserStatus;
use App\Prism\LeagueTaskPrism;
use App\Scope\AbstractScope;
use Yonna\Throwable\Exception\DatabaseException;

class Stat extends AbstractScope
{


    /**
     * @return array
     * @throws DatabaseException
     */
    public function user(): array
    {
        $stat = [];
        foreach (UserStatus::toKv('label') as $k => $v) {
            $stat[$k] = [
                'key' => $k,
                'label' => $v,
                'value' => 0,
            ];
        }
        $userCount = DB::connect()
            ->table('user')
            ->field('count(`id`) as qty,status')
            ->groupBy('status')
            ->multi();
        foreach ($userCount as $u) {
            $stat[$u['user_status']]['value'] = $u['qty'];
        }
        return array_values($stat);
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function account(): array
    {
        $stat = [];
        foreach (AccountType::toKv('label') as $k => $v) {
            $stat[$k] = [
                'key' => $k,
                'label' => $v,
                'value' => 0,
            ];
        }
        $userCount = DB::connect()
            ->table('user_account')
            ->field('count(`user_id`) as qty,type')
            ->groupBy('type')
            ->multi();
        foreach ($userCount as $u) {
            $stat[$u['user_account_type']]['value'] = $u['qty'];
        }
        return array_values($stat);
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function league(): array
    {
        $stat = [];
        foreach (LeagueStatus::toKv('label') as $k => $v) {
            $stat[$k] = [
                'key' => $k,
                'label' => $v,
                'value' => 0,
            ];
        }
        $userCount = DB::connect()
            ->table('league')
            ->field('count(`id`) as qty,status')
            ->groupBy('status')
            ->multi();
        foreach ($userCount as $u) {
            $stat[$u['league_status']]['value'] = $u['qty'];
        }
        return array_values($stat);
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function leagueMember(): array
    {
        $stat = [];
        foreach (LeagueMemberPermission::toKv('label') as $k => $v) {
            $stat[$k] = [
                'key' => $k,
                'label' => $v,
                'value' => 0,
            ];
        }
        $userCount = DB::connect()
            ->table('league_member')
            ->field('count(`user_id`) as qty,permission')
            ->groupBy('permission')
            ->multi();
        foreach ($userCount as $u) {
            $stat[$u['league_member_permission']]['value'] = $u['qty'];
        }
        return array_values($stat);
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function task(): array
    {
        $stat = [];
        foreach (LeagueTaskStatus::toKv('label') as $k => $v) {
            $stat[$k] = [
                'key' => $k,
                'label' => $v,
                'value' => 0,
            ];
        }
        $prism = new LeagueTaskPrism($this->request());
        $total = DB::connect()->table('league_task')
            ->where(function (Where $w) use ($prism) {
                $prism->getLeagueId() && $w->equalTo('league_id', $prism->getLeagueId());
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
            })
            ->count('id');
        $res = DB::connect()->table('league_task')
            ->field('count(`id`) as qty,status')
            ->groupBy('status')
            ->where(function (Where $w) use ($prism) {
                $prism->getLeagueId() && $w->equalTo('league_id', $prism->getLeagueId());
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
            })
            ->multi();
        foreach ($res as $v) {
            $stat[$v['league_task_status']]['value'] = $prism->isPercent() ? round($v['qty'] / $total * 100) : $v['qty'];
        }
        return array_values($stat);
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function leagueData(): array
    {
        $h = DB::connect()->table('data_hobby')->where(fn(Where $w) => $w->equalTo('status', DataStatus::ENABLED))->count('id');
        $w = DB::connect()->table('data_work')->where(fn(Where $w) => $w->equalTo('status', DataStatus::ENABLED))->count('id');
        $s = DB::connect()->table('data_speciality')->where(fn(Where $w) => $w->equalTo('status', DataStatus::ENABLED))->count('id');
        $stat = [
            ['label' => '爱好', 'value' => $h],
            ['label' => '职业', 'value' => $w],
            ['label' => '特长', 'value' => $s],
        ];
        return $stat;
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function essay(): array
    {
        $stat = [];
        foreach (EssayStatus::toKv('label') as $k => $v) {
            $stat[$k] = [
                'key' => $k,
                'label' => $v,
                'value' => 0,
            ];
        }
        $userCount = DB::connect()
            ->table('essay')
            ->field('count(`id`) as qty,status')
            ->groupBy('status')
            ->multi();
        foreach ($userCount as $u) {
            $stat[$u['essay_status']]['value'] = $u['qty'];
        }
        return array_values($stat);
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function essayCategory(): array
    {
        $stat = [];
        foreach (EssayCategoryStatus::toKv('label') as $k => $v) {
            $stat[$k] = [
                'key' => $k,
                'label' => $v,
                'value' => 0,
            ];
        }
        $userCount = DB::connect()
            ->table('essay_category')
            ->field('count(`id`) as qty,status')
            ->groupBy('status')
            ->multi();
        foreach ($userCount as $u) {
            $stat[$u['essay_category_status']]['value'] = $u['qty'];
        }
        return array_values($stat);
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function userGrow(): array
    {
        $res = DB::connect()
            ->table('user')
            ->field('id,register_time')
            ->where(fn(Where $w) => $w->notEqualTo('status', UserStatus::DELETE))
            ->multi();
        $tmp = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = date('Y-m-d H:i:s', strtotime(date('Y-m-01 23:59:59') . " -1day +1month -{$i}month"));
            $time = strtotime($d);
            $txt = date('Y年m月', $time);
            if (!isset($tmp[$txt])) {
                $tmp[$txt] = 0;
            }
            foreach ($res as $v) {
                if ($v['user_register_time'] <= $time) {
                    $tmp[$txt]++;
                }
            }
        }
        $stat = [];
        foreach ($tmp as $k => $v) {
            $stat[] = ['label' => $k, 'value' => $v];
        }
        return $stat;
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function leagueGrow(): array
    {
        $res = DB::connect()
            ->table('league')
            ->field('id,apply_time')
            ->where(fn(Where $w) => $w->notEqualTo('status', LeagueStatus::DELETE))
            ->multi();
        $tmp = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = date('Y-m-d H:i:s', strtotime(date('Y-m-01 23:59:59') . " -1day +1month -{$i}month"));
            $time = strtotime($d);
            $txt = date('Y年m月', $time);
            if (!isset($tmp[$txt])) {
                $tmp[$txt] = 0;
            }
            foreach ($res as $v) {
                if ($v['league_apply_time'] <= $time) {
                    $tmp[$txt]++;
                }
            }
        }
        $stat = [];
        foreach ($tmp as $k => $v) {
            $stat[] = ['label' => $k, 'value' => $v];
        }
        return $stat;
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function taskGrow(): array
    {
        $res = DB::connect()
            ->table('league_task')
            ->field('id,apply_time')
            ->where(fn(Where $w) => $w->notEqualTo('status', LeagueStatus::DELETE))
            ->multi();
        $tmp = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = date('Y-m-d H:i:s', strtotime(date('Y-m-01 23:59:59') . " -1day +1month -{$i}month"));
            $time = strtotime($d);
            $txt = date('Y年m月', $time);
            if (!isset($tmp[$txt])) {
                $tmp[$txt] = 0;
            }
            foreach ($res as $v) {
                if ($v['league_task_apply_time'] <= $time) {
                    $tmp[$txt]++;
                }
            }
        }
        $stat = [];
        foreach ($tmp as $k => $v) {
            $stat[] = ['label' => $k, 'value' => $v];
        }
        return $stat;
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function essayGrow(): array
    {
        $res = DB::connect()
            ->table('essay')
            ->field('id,publish_time')
            ->where(fn(Where $w) => $w->notEqualTo('status', LeagueStatus::DELETE))
            ->multi();
        $tmp = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = date('Y-m-d H:i:s', strtotime(date('Y-m-01 23:59:59') . " -1day +1month -{$i}month"));
            $time = strtotime($d);
            $txt = date('Y年m月', $time);
            if (!isset($tmp[$txt])) {
                $tmp[$txt] = 0;
            }
            foreach ($res as $v) {
                if ($v['essay_publish_time'] <= $time) {
                    $tmp[$txt]++;
                }
            }
        }
        $stat = [];
        foreach ($tmp as $k => $v) {
            $stat[] = ['label' => $k, 'value' => $v];
        }
        return $stat;
    }


}