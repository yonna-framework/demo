<?php
/**
 * 公共逻辑方法，数据表初始化
 * Date: 2018/07/04
 */

namespace Common\Model;

use library\Model;
use User\Map\Status;

abstract class AbstractModel extends Model
{

    /**
     * 初始化
     */
    public function init__()
    {
        // nothing
    }

    /**
     * 加/解密
     * @param $str
     * @return string
     */
    protected function encrypto($str)
    {
        return openssl_encrypt($str, 'des-cbc', CONFIG['crypto_key'], 0, CONFIG['crypto_key']);
    }

    protected function decrypto($str)
    {
        return openssl_decrypt($str, 'des-cbc', CONFIG['crypto_key'], 0, CONFIG['crypto_key']);
    }

    private $allowPermission = array();

    /**
     * 无需权限检查的集合(通行证)
     * @param array $allow
     * @return bool
     */
    protected function allowPermission(array $allow)
    {
        if (!$allow) return $this->true('do nothing');
        $this->allowPermission = array_merge($this->allowPermission, $allow);
        return true;
    }

    /**
     * TODO 根据权限各种数据，集合出允许的SCOPE
     * @param $userPermission
     * @param $permission
     * @param array $scopes
     * @param string $prevKey
     * @return array
     */
    protected function getScopeByPermission($userPermission, $permission, $scopes = array(), $prevKey = '')
    {
        if (!$userPermission || !$permission) return array();
        foreach ($permission as $p) {
            $nextKey = ($prevKey !== '') ? $prevKey . '-' . $p['key'] : $p['key'];
            if (in_array($nextKey, $userPermission)) {
                if (isset($p['scope']) && is_array($p['scope'])) {
                    $scopes = array_merge($scopes, $p['scope']);
                }
            }
            if (isset($p['children']) && is_array($p['children'])) {
                $scopes = array_merge($scopes, $this->getScopeByPermission($userPermission, $p['children'], $scopes, $nextKey));
            }
        }
        return $scopes;
    }

    /**
     * TODO 根据登录身份判断权限法
     * @return boolean
     */
    public function checkPermission__()
    {
        if (!CONFIG['is_debug']) {
            if (!in_array($this->getScope(), $this->allowPermission)) {
                $authUid = $this->getRequest()['auth_uid'] ?? $this->getRequest()['authUid'] ?? null;
                if (!$authUid || !in_array($authUid, $this->getOnlineUid())) {
                    return $this->false('illegal permission online');
                }
                $user = $this->db()->table('user')->field('uid,status,permission,platform')->equalTo('uid', $authUid)->one();
                //todo 检查账号存在
                if (!$user) {
                    return $this->false('账号不存在');
                }
                //todo super admin 为所欲为
                if ($user['user_uid'] == CONFIG['admin_uid']) {
                    return true;
                }
                //todo 检查平台
                if (!in_array($this->getPlatform(), $user['user_platform'])) {
                    return $this->false('账号不允许在此平台及进行操作');
                }
                //todo 检查normal
                if (in_array('normal', $user['user_platform'])) {
                    return true;
                }
                //todo 检查状态
                if (in_array($user['user_status'], [Status::DELETE, Status::FREEZE])) {
                    return $this->false('账号已被禁用');
                }
                //todo 检查API权限
                $permission = $this->db()->table('system_data')->equalTo('key', 'permission')->one();
                $allowScopes = $this->getScopeByPermission($user['user_permission'], $permission['system_data_data']);
                // 没有 AUTH_UID 的方法需要在对应的Model进行判断,此case用于注释作用
                if (!in_array($this->getScope(), $allowScopes)) {
                    return $this->false('你还没有权限可执行此操作，请联系管理员进行权限调配');
                }
            }
        }
        return true;
    }

    /**
     * 获取当前平台特定client的UID
     * @return array
     */
    protected function getOnlineUid()
    {
        $uid = array();
        try {
            $cacheOnlineData = $this->redis()->get("ONLINE");
            if (empty($cacheOnlineData[$this->getPlatform()])) throw new \Exception('empty');
            if (empty($cacheOnlineData[$this->getPlatform()][$this->getClientID()])) throw new \Exception('empty');
            foreach ($cacheOnlineData[$this->getPlatform()][$this->getClientID()] as $cpk => $expire) {
                if ($this->getNow() < $expire) {
                    $uid[] = $cpk;
                } else {
                    unset($cacheOnlineData[$this->getPlatform()][$this->getClientID()][$cpk]);
                }
            }
            if (!$cacheOnlineData[$this->getPlatform()][$this->getClientID()]) {
                unset($cacheOnlineData[$this->getPlatform()][$this->getClientID()]);
            }
            $this->redis()->set("ONLINE", $cacheOnlineData);
        } catch (\Exception $e) {
        }
        if (!$uid) {
            $now = date('Y-m-d H:i:59', $this->getNow());
            $model = $this->db()->table('user_login_online');
            $model->equalTo('client_id', $this->getClientID());
            $model->equalTo('platform', $this->getPlatform());
            $model->greaterThanOrEqualTo('expire_time', $now);//保险
            $list = $model->field('uid')->multi();
            $uid = array();
            foreach ($list as $l) {
                $uid[] = $l['user_login_online_uid'];
            }
        }
        return $uid;
    }

}