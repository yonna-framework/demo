<?php

namespace App\Scope;

use Throwable;
use App\Mapping\League\LeagueMemberPermission;
use App\Mapping\League\LeagueMemberStatus;
use App\Mapping\League\LeagueStatus;
use App\Prism\LeaguePrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class League
 * @package App\Scope
 */
class League extends AbstractScope
{

    const TABLE = 'league';

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     * @throws Exception\ThrowException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new LeaguePrism($this->request());
        $result = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $prism->getId()))
            ->one();
        if ($prism->isAttachHobby()) {
            $result = $this->scope(LeagueAssociateHobby::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachWork()) {
            $result = $this->scope(LeagueAssociateWork::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachSpeciality()) {
            $result = $this->scope(LeagueAssociateSpeciality::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachMember()) {
            $result = $this->scope(LeagueMember::class, 'attach', ['attach' => $result]);
        }
        return $result;
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     * @throws Exception\ThrowException
     */
    public function multi(): array
    {
        $prism = new LeaguePrism($this->request());
        $db = DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $w->searchTable(self::TABLE);
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getIds() && $w->in('id', $prism->getIds());
                $prism->getNotIds() && $w->notIn('id', $prism->getNotIds());
                $prism->getName() && $w->like('name', '%' . $prism->getName() . '%');
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
                $prism->getStatuss() && $w->in('status', $prism->getStatuss());
            })
            ->orderBy('sort', 'desc', self::TABLE)
            ->orderBy('id', 'desc', self::TABLE);
        if ($prism->getUserAccount()) {
            $one = $this->scope(UserAccount::class, 'one', ['string' => $prism->getUserAccount()]);
            $prism->setUserId($one ? $one['user_account_user_id'] : -1);
        }
        $lids = [];
        if ($prism->getUserId()) {
            $res = DB::connect()->table('league_member')->field('league_id')
                ->where(function (Where $w) use ($prism) {
                    $w->equalTo('user_id', $prism->getUserId());
                    if ($prism->getStatus() === LeagueStatus::APPROVED) {
                        $w->equalTo('status', LeagueMemberStatus::APPROVED);
                    }
                })
                ->multi();
            $res = array_column($res, 'league_member_league_id');
            $lids = array_merge($lids, $res);
        }
        if ($prism->getHobby()) {
            $db->join(self::TABLE, 'league_associate_hobby', ['id' => 'league_id'], 'left')
                ->groupBy('id', 'league')
                ->where(fn(Where $w) => $w->searchTable('league_associate_hobby')
                    ->in('data_id', $prism->getHobby()));
        }
        if ($prism->getWork()) {
            $db->join(self::TABLE, 'league_associate_work', ['id' => 'league_id'], 'left')
                ->groupBy('id', 'league')
                ->where(fn(Where $w) => $w->searchTable('league_associate_work')
                    ->in('data_id', $prism->getWork()));
        }
        if ($prism->getSpeciality()) {
            $db->join(self::TABLE, 'league_associate_speciality', ['id' => 'league_id'], 'left')
                ->groupBy('id', 'league')
                ->where(fn(Where $w) => $w->searchTable('league_associate_speciality')
                    ->in('data_id', $prism->getSpeciality()));
        }
        if ($lids) {
            $lids = array_unique($lids);
            $lids = array_values($lids);
            $db->where(fn(Where $w) => $w->in('id', $lids));
        }
        $result = $db->multi();
        if ($prism->isAttachHobby()) {
            $result = $this->scope(LeagueAssociateHobby::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachWork()) {
            $result = $this->scope(LeagueAssociateWork::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachSpeciality()) {
            $result = $this->scope(LeagueAssociateSpeciality::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachMember()) {
            $result = $this->scope(LeagueMember::class, 'attach', [
                'attach' => $result,
                'user_id' => $prism->getUserId(),
            ]);
        }
        return $result;
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     * @throws Exception\ThrowException
     */
    public function page(): array
    {
        $prism = new LeaguePrism($this->request());
        $result = DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getName() && $w->like('name', '%' . $prism->getName() . '%');
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
                $prism->getStatuss() && $w->in('status', $prism->getStatuss());
            })
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->page($prism->getCurrent(), $prism->getPer());
        if ($prism->isAttachHobby()) {
            $result = $this->scope(LeagueAssociateHobby::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachWork()) {
            $result = $this->scope(LeagueAssociateWork::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachSpeciality()) {
            $result = $this->scope(LeagueAssociateSpeciality::class, 'attach', ['attach' => $result]);
        }
        if ($prism->isAttachMember()) {
            $result = $this->scope(LeagueMember::class, 'attach', ['attach' => $result]);
        }
        return $result;
    }

    /**
     * @return int
     * @throws Exception\ParamsException
     * @throws Exception\ThrowException
     * @throws Throwable
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), [
            'name',
            'slogan',
            //'introduction',
            'logo_pic',
            'business_license_pic',
        ], function ($error) {
            Exception::throw($error);
        });
        ArrayValidator::anyone($this->input(), ['master_user_id', 'master_user_account'], function ($error) {
            Exception::throw($error);
        });
        $prism = new LeaguePrism($this->request());
        // 检测同名
        $c = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w
                ->equalTo('name', $prism->getName())
                ->notEqualTo('status', LeagueStatus::DELETE)
            )
            ->count();
        if ($c > 0) {
            Exception::params('Name already exist');
        }
        // 找到社团主
        if (!$prism->getMasterUserId()) {
            $account = $this->scope(UserAccount::class, 'one', ['string' => $prism->getMasterUserAccount()]);
            if (empty($account['user_account_id'])) {
                Exception::params('Account is not exist');
            }
            $prism->setMasterUserId($account['user_account_id']);
        }
        $introduction = $this->xoss_save($prism->getIntroduction() ?? '');
        $add = [
            'name' => $prism->getName(),
            'slogan' => $prism->getSlogan(),
            'introduction' => $introduction,
            'logo_pic' => $prism->getLogoPic(),
            'business_license_pic' => $prism->getBusinessLicensePic(),
            'status' => $prism->getStatus() ?? LeagueStatus::PENDING,
            'apply_reason' => $prism->getApplyReason() ?? '',
            'apply_time' => time(),
            'rejection_time' => 0,
            'pass_time' => 0,
            'delete_time' => 0,
            'sort' => $prism->getSort() ?? 0,
        ];
        return DB::transTrace(function () use ($add, $prism) {
            $id = DB::connect()->table(self::TABLE)->insert($add);
            $this->scope(LeagueMember::class, 'insert', [
                'league_id' => $id,
                'user_id' => $prism->getMasterUserId(),
                'permission' => LeagueMemberPermission::OWNER,
                'status' => LeagueMemberStatus::APPROVED,
            ]);
            if ($prism->getHobby()) {
                $this->scope(LeagueAssociateHobby::class, 'cover', [
                    'league_id' => $id,
                    'data' => $prism->getHobby()
                ]);
            }
            if ($prism->getWork()) {
                $this->scope(LeagueAssociateWork::class, 'cover', [
                    'league_id' => $id,
                    'data' => $prism->getWork()
                ]);
            }
            if ($prism->getSpeciality()) {
                $this->scope(LeagueAssociateSpeciality::class, 'cover', [
                    'league_id' => $id,
                    'data' => $prism->getSpeciality()
                ]);
            }
            return $id;
        });
    }

    /**
     * @return int
     * @throws Throwable
     */
    public function update()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new LeaguePrism($this->request());
        if ($prism->getMasterUserAccount()) {
            $account = $this->scope(UserAccount::class, 'one', ['string' => $prism->getMasterUserAccount()]);
            if (empty($account['user_account_id'])) {
                Exception::params('Account is not exist');
            }
            $prism->setMasterUserId($account['user_account_id']);
        }
        if ($prism->getIntroduction()) {
            $prism->setIntroduction($this->xoss_save($prism->getIntroduction()));
        }
        $data = [
            'master_user_id' => $prism->getMasterUserId(),
            'name' => $prism->getName(),
            'slogan' => $prism->getSlogan(),
            'introduction' => $prism->getIntroduction(),
            'logo_pic' => $prism->getLogoPic(),
            'business_license_pic' => $prism->getBusinessLicensePic(),
            'status' => $prism->getStatus(),
            'sort' => $prism->getSort(),
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
        DB::transTrace(function () use ($data, $prism) {
            if ($data) {
                return DB::connect()->table(self::TABLE)
                    ->where(fn(Where $w) => $w->equalTo('id', $prism->getId()))
                    ->update($data);
            }
            if ($prism->getHobby()) {
                $this->scope(LeagueAssociateHobby::class, 'cover', [
                    'league_id' => $prism->getId(),
                    'data' => $prism->getHobby()
                ]);
            }
            if ($prism->getWork()) {
                $this->scope(LeagueAssociateWork::class, 'cover', [
                    'league_id' => $prism->getId(),
                    'data' => $prism->getWork()
                ]);
            }
            if ($prism->getSpeciality()) {
                $this->scope(LeagueAssociateSpeciality::class, 'cover', [
                    'league_id' => $prism->getId(),
                    'data' => $prism->getSpeciality()
                ]);
            }
            return true;
        });
        return true;
    }

    public function updatec()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $id = $this->input('id');
        $res = DB::connect()->table('league_member')
            ->where(fn(Where $w) => $w
                ->equalTo('league_id', $id)
                ->equalTo('user_id', $this->request()->getLoggingId())
                ->equalTo('permission', LeagueMemberPermission::OWNER)
            )
            ->one();
        if (!$res) {
            Exception::error("Account not licensed");
        }
        return $this->update();
    }

    /**
     * @return int
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
     * @return mixed
     * @throws Exception\DatabaseException
     * @throws Exception\ErrorException
     * @throws Exception\ThrowException
     */
    public function delete()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $id = $this->input('id');
        $res = DB::connect()->table('league_member')
            ->where(fn(Where $w) => $w
                ->equalTo('league_id', $id)
                ->equalTo('user_id', $this->request()->getLoggingId())
                ->equalTo('permission', LeagueMemberPermission::OWNER)
            )
            ->one();
        if (!$res) {
            Exception::error("Account not licensed");
        }
        return $this->scope(League::class, 'multiStatus', [
            'ids' => [$id],
            'status' => LeagueStatus::DELETE,
        ]);
    }

}