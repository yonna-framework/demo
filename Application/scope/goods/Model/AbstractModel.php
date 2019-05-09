<?php

namespace Goods\Model;
/**
 * Date: 2018/05/14
 */
class AbstractModel extends \Common\Model\AbstractModel
{

    /**
     * 初始化
     */
    public function init__()
    {
        parent::init__();
        $this->allowPermission(array(
            'Goods.GoodsCategory.getList',
            'Goods.GoodsCategory.getInfo',
            'Goods.Goods.getList',
            'Goods.Goods.getInfo',
        ));
    }

    private function getChildCate($fullData, $cateId = 0, $prevId = [], $prevPid = [], $result = [])
    {
        if (is_array($fullData) && $fullData) {
            $temp = array();
            foreach ($fullData as $fd) {
                $tempPrevId = $prevId;
                $tempPrevIdPid = $prevPid;
                if ($fd['goods_category_pid'] === $cateId) {
                    $tempPrevId[] = $fd['goods_category_id'];
                    $fd['goods_category_pid'] > 0 && $tempPrevIdPid[] = $fd['goods_category_pid'];
                    $fd['goods_category_id_key'] = implode('-', $tempPrevId);
                    $fd['goods_category_pid_key'] = $tempPrevIdPid ? implode('-', $tempPrevIdPid) : 0;
                    $fd['goods_category_children'] = $this->getChildCate($fullData, $fd['goods_category_id'], $tempPrevId, $tempPrevIdPid, $temp);
                    $temp[] = $fd;
                }
            }
            $result = $temp;
        }
        return $result;
    }

    /**
     * 获取分层级分类
     * @param int $cateId
     * @return array
     */
    protected function getAllCategory($cateId = 0)
    {
        $list = $this->db()->table('goods_category')->multi();
        return $this->getChildCate($list, $cateId);
    }

    protected function setCateIdToKey(array $allCate, $result = array())
    {
        if ($allCate) {
            foreach ($allCate as $v) {
                if ($v['goods_category_children']) {
                    $v['goods_category_children'] = $this->setCateIdToKey($v['goods_category_children'], $result['goods_category_children']);
                }
                $result[$v['goods_category_id']] = $v;
            }
        }
        return $result;
    }

    protected function setCateIdToLabel(array $allCate, $prevName = [], $result = array(), $sign = '/')
    {
        if ($allCate) {
            foreach ($allCate as $v) {
                $tempPrevName = $prevName;
                $tempPrevName[] = $v['goods_category_name'];
                $result[$v['goods_category_id_key']] = implode($sign, $tempPrevName);
                if ($v['goods_category_children']) {
                    $result = $this->setCateIdToLabel($v['goods_category_children'], $tempPrevName, $result);
                }
            }
        }
        return $result;
    }

    /**
     * 获取所有分类 label
     */
    protected function getAllCateLabel()
    {
        $allCate = $this->getAllCategory(0);
        $allCate = $this->setCateIdToLabel($allCate);
        return $allCate;
    }

    /**
     * 获取分层级分类数组 "-" 中分
     * @param array $fullData
     * @param array $cateId
     * @return array
     */
    protected function getAllCategoryId(array $fullData, array $cateId = [])
    {
        if ($fullData) {
            foreach ($fullData as $fk => $fd) {
                if (in_array($fd['goods_category_id_key'], $cateId)) {
                    if (!in_array($fd['goods_category_id_key'], $cateId)) {
                        $cateId[] = $fd['goods_category_id_key'];
                    }
                    if ($fd['goods_category_children']) {
                        $cateId = $this->getAllCategoryId($fd['goods_category_children'], $cateId);
                    }
                } elseif (in_array($fd['goods_category_pid_key'], $cateId)) {
                    if (!in_array($fd['goods_category_id_key'], $cateId)) {
                        $cateId[] = $fd['goods_category_id_key'];
                    }
                    if ($fd['goods_category_children']) {
                        $cateId = $this->getAllCategoryId($fd['goods_category_children'], $cateId);
                    }
                } elseif ($fd['goods_category_children']) {
                    $cateId = $this->getAllCategoryId($fd['goods_category_children'], $cateId);
                }
            }
        }
        sort($cateId);
        return $cateId;
    }

    /**
     * 获取属性数组 "-" 中分
     * @param array $inputAttrValue
     * @return array
     */
    protected function getAllAttrValueId(array $inputAttrValue)
    {
        // 分离属性
        $classId = array();
        $attr_kv = array();
        $attr_value = array();
        if ($inputAttrValue) {
            foreach ($inputAttrValue as $av) {
                $av = explode('-', $av);
                if (!isset($attr_value[$av[0]])) {
                    $attr_value[$av[0]] = array();
                }
                if (!in_array($av[0], $classId)) {
                    $classId[] = $av[0];
                }
            }
            $result1 = $this->db()->table('goods_attr_class')->field('id,name')->in('id', $classId)->multi();
            $result2 = $this->db()->table('goods_attr_value')->field('id,class_id,name')->in('class_id', $classId)->multi();
            $classMap = array_combine(array_column($result1, 'goods_attr_class_id'), $result1);
            $valueMap = array_combine(array_column($result2, 'goods_attr_value_id'), $result2);
            foreach ($classMap as $ck => $cm) {
                foreach ($valueMap as $vk => $vm) {
                    if ($cm['goods_attr_class_id'] == $vm['goods_attr_value_class_id']) {
                        if (!isset($classMap[$ck]['children'])) $classMap[$ck]['children'] = array();
                        $classMap[$ck]['children'][$vk] = $vm;
                    }
                }
            }
            foreach ($inputAttrValue as $av) {
                $av = explode('-', $av);
                if (count($av) === 1) {
                    $cid = $av[0];
                    if (!empty($classMap[$cid]['children'])) {
                        foreach ($classMap[$cid]['children'] as $ccc) {
                            $attr_kv[$ccc['goods_attr_value_id']] = $classMap[$cid]['goods_attr_class_name'];
                            $attr_kv["$cid-{$ccc['goods_attr_value_id']}"] = $classMap[$cid]['goods_attr_class_name'] . ':' . $ccc['goods_attr_value_name'];
                            $attr_value[$cid][] = "$cid-{$ccc['goods_attr_value_id']}";
                        }
                    }
                } elseif (count($av) === 2) {
                    $cid = $av[0];
                    $vid = $av[1];
                    $attr_kv["$cid-$vid"] = $classMap[$cid]['goods_attr_class_name'] . ':' . $classMap[$cid]['children'][$vid]['goods_attr_value_name'];
                    $attr_value[$cid][] = "$cid-$vid";
                }
            }
        }
        return [$attr_kv, $attr_value];
    }

}