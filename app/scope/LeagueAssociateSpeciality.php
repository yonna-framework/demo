<?php

namespace App\Scope;

use Yonna\Foundation\Arr;
use App\Prism\LeagueAssociateDataPrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class League
 * @package App\Scope
 */
class LeagueAssociateSpeciality extends AbstractScope
{

    const TABLE = 'league_associate_speciality';

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function multi(): array
    {
        $prism = new LeagueAssociateDataPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getLeagueId() && $w->equalTo('league_id', $prism->getLeagueId());
            })
            ->multi();
    }

    /**
     * @return array
     * @throws Exception\DatabaseException
     */
    public function attach(): array
    {
        $prism = new LeagueAssociateDataPrism($this->request());
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
            ->where(fn(Where $w) => $w->in('league_id', $ids))
            ->multi();
        $datas = [];
        foreach ($values as $v) {
            if (!isset($datas[$v['league_associate_speciality_league_id']])) {
                $datas[$v['league_associate_speciality_league_id']] = [];
            }
            $datas[$v['league_associate_speciality_league_id']][] = $v['league_associate_speciality_data_id'];
        }
        unset($values);
        foreach ($tmp as $uk => $u) {
            $tmp[$uk]['league_speciality'] = empty($datas[$u['league_id']]) ? [] : $datas[$u['league_id']];
        }
        if ($isPage) {
            $data['list'] = $tmp;
            return $data;
        }
        return $isOne ? $tmp[0] : $tmp;
    }

    /**
     * @return bool
     * @throws \Throwable
     */
    public function cover()
    {
        ArrayValidator::required($this->input(), ['league_id'], function ($error) {
            Exception::throw($error);
        });
        $league_id = $this->input('league_id');
        $data = $this->input('data');
        $add = [];
        if ($data) {
            foreach ($data as $d) {
                $add[] = [
                    'league_id' => $league_id,
                    'data_id' => $d,
                ];
            }
        }
        DB::transTrace(function () use ($league_id, $add) {
            DB::connect()->table(self::TABLE)->where(fn(Where $w) => $w->equalTo('league_id', $league_id))->delete();
            if ($add) {
                DB::connect()->table(self::TABLE)->insertAll($add);
            }
        });
        return true;
    }

}