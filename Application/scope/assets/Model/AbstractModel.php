<?php

namespace Assets\Model;

use Assets\Helper\Assets;

class AbstractModel extends \Common\Model\AbstractModel
{

    private static $assetsHelper = null;

    /**
     * 获取资源helper
     * @return Assets|null
     */
    protected function assetsHelper()
    {
        if (self::$assetsHelper == null) {
            self::$assetsHelper = (new Assets());
        }
        return self::$assetsHelper;
    }

    /**
     * 检查用户level
     * @param $uid
     * @param $checkExt
     * @param $checkLength
     * @return bool
     */
    protected function getUserCallLevel($uid, $checkExt, $checkLength)
    {
        $checkLength = (int)$checkLength;
        if (!$checkExt || $checkLength < 0) {
            return $this->false('params error');
        }
        $userInfo = $this->db()->table('user_info')->field('uid,call_level')->equalTo('uid', $uid)->one();
        if (!$userInfo || $userInfo['user_info_uid'] != $uid) {
            return $this->false('who are you');
        }
        $level = $userInfo['user_info_call_level'];
        $levelInfo = $this->db()->table('assets_call_level')->lessThanOrEqualTo('lv', $level)->orderBy('lv', 'desc')->one();
        if (!$levelInfo) {
            return $this->false('what level');
        }
        if (!in_array($checkExt, $levelInfo['assets_call_level_file_ext'])) {
            return $this->false('content type not allow');
        }
        $stat = $this->db()->table('assets')
            ->field("hash_id as total_qty", 'assets', 'COUNT(%0)')
            ->field("file_size as total_file_size", 'assets', 'SUM(%0)')
            ->contains('uid', $uid)->one();
        if ($stat['assets_total_qty'] >= $levelInfo['assets_call_level_file_max_qty']) {
            return $this->false('the maximum quantity has been reached');
        }
        $result = $this->db()->table('system_data')->equalTo('key', 'asset_file_size_unit')->one();
        $asset_file_size_unit = $result['system_data_data'];
        $enlarge = 0;
        foreach ($asset_file_size_unit as $v) {
            if ($levelInfo['assets_call_level_file_size_unit'] == $v['key']) {
                $enlarge = (int)$v['enlarge'];
                break;
            }
        }
        if (!$enlarge) {
            return $this->false('not exist this enlarge');
        }
        if (($levelInfo['assets_call_level_file_max_simple_size']) * $enlarge < $checkLength) {
            return $this->false('the maximum single file size has been reached');
        }
        if (($levelInfo['assets_call_level_file_max_total_size']) * $enlarge < ($checkLength + $stat['assets_total_file_size'])) {
            return $this->false('the maximum whole file size has been reached');
        }
        return $levelInfo;
    }
}