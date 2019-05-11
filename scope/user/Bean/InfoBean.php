<?php
/**
 * Created by PhpStorm.
 * Date: 2018/05/07
 */

namespace User\Bean;

use Common\Bean\AbstractBean;

class InfoBean extends AbstractBean
{

    // level 1
    protected $uid; //用户uid';
    protected $status; //状态 -10注销 -5冻结 -2未通过 -1未审核 1正常';
    protected $inviter_uid; //邀请人uid';
    protected $login_pwd; //登录密码，不一定有，如通过微信登录的就没有';
    protected $login_pwd_level; //密码安全等级：1-5越大越强';
    protected $login_name; //[可登录]个性登录名';
    protected $safe_pwd; //[验证登录]安全码';
    protected $safe_pwd_level; //安全码等级：1-5越大越强';
    protected $mobile; //[可登录]手机号码';
    protected $email; //[可登录]邮箱';
    protected $wx_open_id; //[可登录]微信OPENID';
    protected $wx_unionid; //[可登录]微信UNIONID 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段';
    protected $identity_name; //身份证姓名（真实姓名）';
    protected $identity_card_no; //[可登录]身份证号';
    protected $identity_card_pic_front; //身份证正面';
    protected $identity_card_pic_back; //身份证背面';
    protected $identity_card_pic_take; //身份证手持';
    protected $identity_card_expire_date; //身份证过期日期';
    protected $identity_auth_status; //实名认证状态 -1未认证 -2未通过 1认证中 10已认证';
    protected $identity_auth_reject_reason; //实名认证拒绝理由';
    protected $identity_auth_time; //实名认证时间';
    protected $source; //来源 -1未知';
    protected $register_ip; //注册ip';
    protected $latest_login_time; //最近一次登录帐号的时间';
    protected $platform; //平台';
    protected $permission; //权限';
    protected $record; //记录';
    protected $create_time; //创建时间';
    protected $update_time; //更新时间';

    // level 2
    protected $sex; //性别 -1未设置1男2女';
    protected $nickname; //昵称';
    protected $avatar; //头像uri';
    protected $birthday; //生日';

    // get
    protected $with_secret;
    protected $with_identity_auth;
    protected $with_wx;
    protected $with_online;
    protected $with_this;
    protected $with_finance;
    protected $with_ecard;

    // action
    protected $account;
    protected $login_pwd_old;         //旧密码 *一般用于修改密码，不定
    protected $login_pwd_confirm;     //确认密码 *一般用于设置密码，不定
    protected $newMobile;
    protected $allowHasNotIdentity = false;
    protected $inviter_mobile;    //邀请人手机
    protected $currentSafePwd;
    protected $safe_pwd_old;      //旧安全码 *一般用于修改安全码，不定
    protected $safe_pwd_confirm;  //确认安全码 *一般用于设置安全码，不定
    protected $not_uid; //排除uid
    protected $not_status; //排除状态

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getInviterUid()
    {
        return $this->inviter_uid;
    }

    /**
     * @param mixed $inviter_uid
     */
    public function setInviterUid($inviter_uid)
    {
        $this->inviter_uid = $inviter_uid;
    }

    /**
     * @return mixed
     */
    public function getLoginPwd()
    {
        return $this->login_pwd;
    }

    /**
     * @param mixed $login_pwd
     */
    public function setLoginPwd($login_pwd)
    {
        $this->login_pwd = $login_pwd;
    }

    /**
     * @return mixed
     */
    public function getLoginPwdLevel()
    {
        return $this->login_pwd_level;
    }

    /**
     * @param mixed $login_pwd_level
     */
    public function setLoginPwdLevel($login_pwd_level)
    {
        $this->login_pwd_level = $login_pwd_level;
    }

    /**
     * @return mixed
     */
    public function getLoginName()
    {
        return $this->login_name;
    }

    /**
     * @param mixed $login_name
     */
    public function setLoginName($login_name)
    {
        $this->login_name = $login_name;
    }

    /**
     * @return mixed
     */
    public function getSafePwd()
    {
        return $this->safe_pwd;
    }

    /**
     * @param mixed $safe_pwd
     */
    public function setSafePwd($safe_pwd)
    {
        $this->safe_pwd = $safe_pwd;
    }

    /**
     * @return mixed
     */
    public function getSafePwdLevel()
    {
        return $this->safe_pwd_level;
    }

    /**
     * @param mixed $safe_pwd_level
     */
    public function setSafePwdLevel($safe_pwd_level)
    {
        $this->safe_pwd_level = $safe_pwd_level;
    }

    /**
     * @param bool $handle
     * @return mixed
     */
    public function getMobile($handle = true)
    {
        if ($handle) {
            $temp = array();
            if ($this->mobile) {
                $temp = str_replace('，', ',', $this->mobile);
                if (is_string($temp)) $temp = explode(',', $temp);
                $temp = array_unique($temp);
            }
            return $temp;
        }
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @param bool $handle
     * @return mixed
     */
    public function getEmail($handle = true)
    {
        if ($handle) {
            $temp = array();
            if ($this->email) {
                $temp = str_replace('，', ',', $this->email);
                if (is_string($temp)) $temp = explode(',', $temp);
                $temp = array_unique($temp);
            }
            return $temp;
        }
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param bool $handle
     * @return mixed
     */
    public function getWxOpenId($handle = true)
    {
        if ($handle) {
            $temp = array();
            if ($this->wx_open_id) {
                $temp = str_replace('，', ',', $this->wx_open_id);
                if (is_string($temp)) $temp = explode(',', $temp);
                $temp = array_unique($temp);
            }
            return $temp;
        }
        return $this->wx_open_id;
    }

    /**
     * @param mixed $wx_open_id
     */
    public function setWxOpenId($wx_open_id)
    {
        $this->wx_open_id = $wx_open_id;
    }

    /**
     * @param bool $handle
     * @return mixed
     */
    public function getWxUnionid($handle = true)
    {
        if ($handle) {
            $temp = array();
            if ($this->wx_unionid) {
                $temp = str_replace('，', ',', $this->wx_unionid);
                if (is_string($temp)) $temp = explode(',', $temp);
                $temp = array_unique($temp);
            }
            return $temp;
        }
        return $this->wx_unionid;
    }

    /**
     * @param mixed $wx_unionid
     */
    public function setWxUnionid($wx_unionid)
    {
        $this->wx_unionid = $wx_unionid;
    }

    /**
     * @return mixed
     */
    public function getIdentityName()
    {
        return $this->identity_name;
    }

    /**
     * @param mixed $identity_name
     */
    public function setIdentityName($identity_name)
    {
        $this->identity_name = $identity_name;
    }

    /**
     * @return mixed
     */
    public function getIdentityCardNo()
    {
        return $this->identity_card_no;
    }

    /**
     * @param mixed $identity_card_no
     */
    public function setIdentityCardNo($identity_card_no)
    {
        $this->identity_card_no = $identity_card_no;
    }

    /**
     * @return mixed
     */
    public function getIdentityCardPicFront()
    {
        return $this->identity_card_pic_front;
    }

    /**
     * @param mixed $identity_card_pic_front
     */
    public function setIdentityCardPicFront($identity_card_pic_front)
    {
        $this->identity_card_pic_front = $identity_card_pic_front;
    }

    /**
     * @return mixed
     */
    public function getIdentityCardPicBack()
    {
        return $this->identity_card_pic_back;
    }

    /**
     * @param mixed $identity_card_pic_back
     */
    public function setIdentityCardPicBack($identity_card_pic_back)
    {
        $this->identity_card_pic_back = $identity_card_pic_back;
    }

    /**
     * @return mixed
     */
    public function getIdentityCardPicTake()
    {
        return $this->identity_card_pic_take;
    }

    /**
     * @param mixed $identity_card_pic_take
     */
    public function setIdentityCardPicTake($identity_card_pic_take)
    {
        $this->identity_card_pic_take = $identity_card_pic_take;
    }

    /**
     * @return mixed
     */
    public function getIdentityCardExpireDate()
    {
        return $this->identity_card_expire_date;
    }

    /**
     * @param mixed $identity_card_expire_date
     */
    public function setIdentityCardExpireDate($identity_card_expire_date)
    {
        $this->identity_card_expire_date = $identity_card_expire_date;
    }

    /**
     * @return mixed
     */
    public function getIdentityAuthStatus()
    {
        return $this->identity_auth_status;
    }

    /**
     * @param mixed $identity_auth_status
     */
    public function setIdentityAuthStatus($identity_auth_status)
    {
        $this->identity_auth_status = $identity_auth_status;
    }

    /**
     * @return mixed
     */
    public function getIdentityAuthRejectReason()
    {
        return $this->identity_auth_reject_reason;
    }

    /**
     * @param mixed $identity_auth_reject_reason
     */
    public function setIdentityAuthRejectReason($identity_auth_reject_reason)
    {
        $this->identity_auth_reject_reason = $identity_auth_reject_reason;
    }

    /**
     * @return mixed
     */
    public function getIdentityAuthTime()
    {
        return $this->identity_auth_time;
    }

    /**
     * @param mixed $identity_auth_time
     */
    public function setIdentityAuthTime($identity_auth_time)
    {
        $this->identity_auth_time = $identity_auth_time;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getRegisterIp()
    {
        return $this->register_ip;
    }

    /**
     * @param mixed $register_ip
     */
    public function setRegisterIp($register_ip)
    {
        $this->register_ip = $register_ip;
    }

    /**
     * @return mixed
     */
    public function getLatestLoginTime()
    {
        return $this->latest_login_time;
    }

    /**
     * @param mixed $latest_login_time
     */
    public function setLatestLoginTime($latest_login_time)
    {
        $this->latest_login_time = $latest_login_time;
    }

    /**
     * @return mixed
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param mixed $record
     */
    public function setRecord($record)
    {
        $this->record = $record;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @param mixed $create_time
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    /**
     * @param mixed $update_time
     */
    public function setUpdateTime($update_time)
    {
        $this->update_time = $update_time;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return (string)$this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account): void
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getLoginPwdOld()
    {
        return $this->login_pwd_old;
    }

    /**
     * @param mixed $login_pwd_old
     */
    public function setLoginPwdOld($login_pwd_old)
    {
        $this->login_pwd_old = $login_pwd_old;
    }

    /**
     * @return mixed
     */
    public function getLoginPwdConfirm()
    {
        return $this->login_pwd_confirm;
    }

    /**
     * @param mixed $login_pwd_confirm
     */
    public function setLoginPwdConfirm($login_pwd_confirm)
    {
        $this->login_pwd_confirm = $login_pwd_confirm;
    }

    /**
     * @return mixed
     */
    public function getNewMobile()
    {
        return $this->newMobile;
    }

    /**
     * @param mixed $newMobile
     */
    public function setNewMobile($newMobile)
    {
        $this->newMobile = $newMobile;
    }

    /**
     * @return bool
     */
    public function isAllowHasNotIdentity()
    {
        return $this->allowHasNotIdentity;
    }

    /**
     * @param bool $allowHasNotIdentity
     */
    public function setAllowHasNotIdentity($allowHasNotIdentity)
    {
        $this->allowHasNotIdentity = $allowHasNotIdentity;
    }

    /**
     * @return mixed
     */
    public function getWithIdentityAuth()
    {
        return $this->with_identity_auth;
    }

    /**
     * @param mixed $with_identity_auth
     */
    public function setWithIdentityAuth($with_identity_auth)
    {
        $this->with_identity_auth = $with_identity_auth;
    }

    /**
     * @return mixed
     */
    public function getInviterMobile()
    {
        return $this->inviter_mobile;
    }

    /**
     * @param mixed $inviter_mobile
     */
    public function setInviterMobile($inviter_mobile)
    {
        $this->inviter_mobile = $inviter_mobile;
    }

    /**
     * @return mixed
     */
    public function getSafePwdOld()
    {
        return $this->safe_pwd_old;
    }

    /**
     * @param mixed $safe_pwd_old
     */
    public function setSafePwdOld($safe_pwd_old)
    {
        $this->safe_pwd_old = $safe_pwd_old;
    }

    /**
     * @return mixed
     */
    public function getSafePwdConfirm()
    {
        return $this->safe_pwd_confirm;
    }

    /**
     * @param mixed $safe_pwd_confirm
     */
    public function setSafePwdConfirm($safe_pwd_confirm)
    {
        $this->safe_pwd_confirm = $safe_pwd_confirm;
    }

    /**
     * @return mixed
     */
    public function getNotStatus()
    {
        return $this->not_status;
    }

    /**
     * @param mixed $not_status
     */
    public function setNotStatus($not_status)
    {
        $this->not_status = $not_status;
    }

    /**
     * @return mixed
     */
    public function getCurrentSafePwd()
    {
        return $this->currentSafePwd;
    }

    /**
     * @param mixed $currentSafePwd
     */
    public function setCurrentSafePwd($currentSafePwd)
    {
        $this->currentSafePwd = $currentSafePwd;
    }

    /**
     * @return mixed
     */
    public function getWithSecret()
    {
        return $this->with_secret;
    }

    /**
     * @param mixed $with_secret
     */
    public function setWithSecret($with_secret)
    {
        $this->with_secret = $with_secret;
    }

    /**
     * @return mixed
     */
    public function getWithWx()
    {
        return $this->with_wx;
    }

    /**
     * @param mixed $with_wx
     */
    public function setWithWx($with_wx)
    {
        $this->with_wx = $with_wx;
    }

    /**
     * @return mixed
     */
    public function getWithOnline()
    {
        return $this->with_online;
    }

    /**
     * @param mixed $with_online
     */
    public function setWithOnline($with_online)
    {
        $this->with_online = $with_online;
    }

    /**
     * @return mixed
     */
    public function getWithThis()
    {
        return $this->with_this;
    }

    /**
     * @param mixed $with_this
     */
    public function setWithThis($with_this)
    {
        $this->with_this = $with_this;
    }

    /**
     * @return mixed
     */
    public function getWithFinance()
    {
        return $this->with_finance;
    }

    /**
     * @param mixed $with_finance
     */
    public function setWithFinance($with_finance): void
    {
        $this->with_finance = $with_finance;
    }

    /**
     * @return mixed
     */
    public function getNotUid()
    {
        return $this->not_uid;
    }

    /**
     * @param mixed $not_uid
     */
    public function setNotUid($not_uid)
    {
        $this->not_uid = $not_uid;
    }

    /**
     * @param bool $handle
     * @return mixed
     */
    public function getPlatform($handle = true)
    {
        if ($handle) {
            $temp = array();
            if ($this->platform) {
                $temp = str_replace('，', ',', $this->platform);
                if (is_string($temp)) $temp = explode(',', $temp);
                $temp = array_unique($temp);
            }
            return $temp;
        }
        return $this->platform;
    }

    /**
     * @param mixed $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param mixed $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * @return mixed
     */
    public function getWithEcard()
    {
        return $this->with_ecard;
    }

    /**
     * @param mixed $with_ecard
     */
    public function setWithEcard($with_ecard): void
    {
        $this->with_ecard = $with_ecard;
    }



}