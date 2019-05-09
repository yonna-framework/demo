<?php
/**
 * Created by PhpStorm.
 * Date: 2018/06/26
 */

namespace User\Model;

use User\Helper\LoginName as LoginNameHelper;
use User\Helper\LoginAuth as LoginAuthHelper;
use User\Helper\Password as PasswordHelper;

use System\Model\AuthModel;
use User\Map\Status;

class AbstractModel extends \Common\Model\AbstractModel
{

    /**
     * 初始化
     */
    public function init__(){
        parent::init__();
        $this->allowPermission(array(
            'User.Online.login',
            'User.Online.isOnline',
            'User.Info.add',
            'User.Wechat.isRegister',
        ));
    }

    /**
     * 个性登录名协助对象
     * @return LoginNameHelper
     */
    private $individualityNameHelper;

    protected function getLoginNameHelper()
    {
        if (!$this->individualityNameHelper) $this->individualityNameHelper = new LoginNameHelper();
        return $this->individualityNameHelper;
    }

    /**
     * 登录验证对象
     * @return LoginAuthHelper
     */
    private $loginAuthHelper;

    protected function getLoginAuthHelper()
    {
        if (!$this->loginAuthHelper) $this->loginAuthHelper = new LoginAuthHelper();
        return $this->loginAuthHelper;
    }

    /**
     * 密码对象
     * @return PasswordHelper
     */
    private $passwordHelper;

    protected function getPasswordHelper()
    {
        if (!$this->passwordHelper) $this->passwordHelper = new PasswordHelper();
        return $this->passwordHelper;
    }

    private $systemAuthModel;

    protected function getSystemAuthModel()
    {
        if (!$this->systemAuthModel) $this->systemAuthModel = new AuthModel($this->getIO());
        return $this->systemAuthModel;
    }

    /**
     * 检测用户是否存在
     * @param $uid
     * @return bool
     */
    protected function isExistByUid($uid)
    {
        $data = $this->db()->table('user')->field('uid')->equalTo('uid', $uid)->one();
        return ($data) ? true : false;
    }

    /**
     * 检测识别信息是否被使用|（存在UID时和不存在UID时）
     * @param $account
     * @param null $uid
     * @return bool
     */
    protected function isUsedByIdentity($account, $uid = null)
    {
        $bol = true;
        $data = $this->getInfoByAccount($account);
        if (!$data) $bol = false;
        if ($uid && $data['user_uid'] == $uid) $bol = false;
        return $bol;
    }

    /**
     * 是否设置过安全码
     * @param $uid
     * @return bool
     */
    protected function isSetSafePassword($uid)
    {
        $result = $this->db()->table('user')->equalTo('uid', $uid)->one();
        return ($result['user_safe_pwd']) ? true : false;
    }

    /**
     * 检测用户是否已设置密码
     * @param $uid
     * @return bool
     */
    protected function isSetPassword($uid)
    {
        $result = $this->db()->table('user')->equalTo('uid', $uid)->one();
        return ($result['user_login_pwd']) ? true : false;
    }

    /**
     * 检测用户是否已绑定微信
     * @param $uid
     * @return bool
     */
    protected function isBindWechat($uid)
    {
        $result = $this->db()->table('user')->equalTo('uid', $uid)->one();
        return ($result['user_wx_open_id']) ? true : false;
    }

    /**
     * 根据LoginName 获取 UID
     * @param $name
     * @return mixed
     */
    protected function getUidByLoginName($name)
    {
        $data = $this->db()->table('user')->field('uid')->where(array('login_name' => $name))->one();
        return $data['user_uid'];
    }

    /**
     * 根据UID 获取 LoginName
     * @param $uid
     * @return mixed
     */
    protected function getLoginNameByUid($uid)
    {
        $data = $this->db()->table('user')->field('login_name')->where(array('uid' => $uid))->one();
        return $data['user_login_name'];
    }

    /**
     * 根据帐号获取帐号列表
     * @param $account
     * @return mixed
     */
    protected function getListByIdentity($account)
    {
        if (!$account) return null;
        $result = $this->db()->table('user')
            ->equalTo('login_name', $account)
            ->equalTo('mobile', $account)
            ->equalTo('email', $account)
            ->equalTo('wx_open_id', $account)
            ->equalTo('wx_unionid', $account)
            ->equalTo('identity_card_no', $account)
            ->closure('or')
            ->multi();
        return $result;
    }

    /**
     * 根据帐号获取帐号信息
     * @param $uid
     * @return mixed
     */
    protected function getInfoByUid($uid)
    {
        if (!$uid) return null;
        $result = $this->db()->table('user')->equalTo('uid', $uid)->one();
        return $result;
    }

    /**
     * 根据帐号获取帐号信息
     * @param $account
     * @return mixed
     */
    protected function getInfoByAccount($account)
    {
        if (!$account) return null;
        $result = $this->db()->table('user')
            ->equalTo('login_name', $account)
            ->contains('mobile', $account)
            ->contains('email', $account)
            ->contains('wx_open_id', $account)
            ->contains('wx_unionid', $account)
            ->equalTo('identity_card_no', $account)
            ->closure('or')
            ->one();
        return $result;
    }

    /**
     * 验证帐号密码
     * @param $uid
     * @param $password
     * @return bool|mixed
     */
    protected function authPwdByUid($uid, $password)
    {
        $data = $this->db()->table('user')
            ->field('uid,login_pwd,status')
            ->equalTo('uid', $uid)
            ->one();
        if (!$data) {
            return $this->false('帐号信息错误');
        }
        if ($data['user_status'] != Status::NORMAL && $data['user_status'] != Status::UNVERIFY) {
            return $this->false('帐号被禁用');
        }
        if ($data['user_login_pwd'] && $data['user_login_pwd'] === $this->getPasswordHelper()->Password($password)) {
            return $data['user_uid'];
        } else {
            return $this->false('密码错误！');
        }
    }

    /**
     * 检验安全码
     * @param $uid
     * @param $currentSafePwd
     * @return mixed
     */
    protected function authSafePwd($uid, $currentSafePwd)
    {
        // 如果设置了安全码，这样的帐号只要检测安全码是否正确即可
        $data = $this->db()->table('user')->field('safe_pwd')->where(array('uid' => $uid))->one();
        if (!$data) return $this->false('帐号信息有误');
        // 如果没有设置，直接返回true
        if (!$data['user_safe_pwd']) return true;
        // 有则校验
        if (!$currentSafePwd) {
            return $this->false('涉及到用户重要信息，必须验证安全码');
        }
        if ($data['user_safe_pwd'] != $this->getPasswordHelper()->Password($currentSafePwd)) {
            return $this->false('安全码身份验证错误！');
        }
        return true;
    }

}