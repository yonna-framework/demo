<?php
/**
 * Date: 2018/08/06
 */

namespace Common\Map;

abstract class AbstractMap
{

    private $data = array();

    /**
     * 赋值
     * @author hunzsig
     * @param $label
     * @param $value
     * @return $this
     */
    public function set($value, $label)
    {
        $this->data[$value] = $label;
        return $this;
    }

    /**
     * 根据value获取label
     * @author hunzsig
     * @param $value
     * @return mixed
     */
    public function get($value)
    {
        if (!isset($this->data[$value])) {
            return null;
        }
        return $this->data[$value];
    }

    /**
     * 获取 [ value, label ]
     * @return array
     */
    public function getMap()
    {
        $map = array();
        foreach ($this->data as $value => $label) {
            $map[] = [
                'value' => $value,
                'label' => $label
            ];
        }
        return $map;
    }

    /**
     * 获取 { key -> value }
     * @return array
     */
    public function getKV()
    {
        $map = array();
        foreach ($this->data as $value => $label) {
            $map[$value] = $label;
        }
        return $map;
    }

}