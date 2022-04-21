<?php

namespace App\Scope;

use Yonna\Mapping\Mapping;
use App\Mapping\Common\Boolean;
use App\Mapping\User\MetaValueFormat;
use App\Prism\UserMetaCategoryPrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class MetaCategory
 * @package App\Scope
 */
class UserMetaCategory extends AbstractScope
{

    const TABLE = 'user_meta_category';

    /**
     * @param $value
     * @param $format
     * @return mixed
     */
    public static function valueFormat($value, $format)
    {
        switch ($format) {
            case MetaValueFormat::STRING:
                if ($value) {
                    if (is_array($value)) {
                        foreach ($value as &$vv) {
                            $vv = (string)$vv;
                        }
                    } else {
                        $value = (string)$value;
                    }
                }
                break;
            case MetaValueFormat::INTEGER:
            case MetaValueFormat::DATE:
            case MetaValueFormat::TIME:
            case MetaValueFormat::DATETIME:
                if ($value) {
                    if (is_array($value)) {
                        foreach ($value as &$vv) {
                            $vv = (int)$vv;
                        }
                    } else {
                        $value = (int)$value;
                    }
                }
                break;
            case MetaValueFormat::FLOAT1:
            case MetaValueFormat::FLOAT2:
            case MetaValueFormat::FLOAT3:
                if ($value) {
                    $precision = (int)substr($format, -1, 1);
                    if (is_array($value)) {
                        foreach ($value as &$vv) {
                            $vv = round($vv, $precision);
                        }
                    } else {
                        $value = round($value, $precision);
                    }
                }
                break;
            default:
                break;
        }
        return $value;
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['key'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('key', $this->input('key')))
            ->one();
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function multi(): array
    {
        $prism = new UserMetaCategoryPrism($this->request());
        $res = DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getKey() && $w->equalTo('key', $prism->getKey());
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
            })
            ->orderBy('sort', 'desc')
            ->multi();
        foreach ($res as $k => $v) {
            if ($v['user_meta_category_value_default']) {
                $res[$k]['user_meta_category_value_default'] = UserMetaCategory::valueFormat(
                    $v['user_meta_category_value_default'],
                    $v['user_meta_category_value_format']
                );
            }
        }
        if ($prism->isBindData()) {
            foreach ($res as $k => $v) {
                $d = $v['user_meta_category_component_data'];
                if (empty($d)) {
                    $d = null;
                } elseif (is_array($d)) {
                    $nd = [];
                    foreach ($d as $dd) {
                        $nd[] = ['value' => $dd, 'label' => $dd];
                    }
                    $d = $nd;
                } elseif (is_string($d)) {
                    $dk = explode(':', $d);
                    switch ($dk[0]) {
                        case 'mapping':
                            /**
                             * @var $m Mapping
                             */
                            $m = str_replace('_', "\\", $dk[1]);
                            $d = class_exists($m) ? $m::toAntd() : [];
                            break;
                        case 'db':
                            $dsn = explode('.', $dk[1]);
                            $conf = $dsn[0];//哪个库
                            $table = $dsn[1];//哪个表
                            $field = $dsn[2];//哪个字段（主键固定为id）
                            $list = DB::connect($conf)->table($table)->field("id")->field($field)->multi();
                            $d = [];
                            foreach ($list as $l) {
                                $d[] = ['value' => $l["{$table}_id"], 'label' => $l["{$table}_{$field}"]];
                            }
                            break;
                        default:
                            break;
                    }
                }
                $res[$k]['user_meta_category_component_data'] = $d;
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
        $prism = new UserMetaCategoryPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getKey() && $w->equalTo('key', $prism->getKey());
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
            })
            ->orderBy('sort', 'desc')
            ->page($prism->getCurrent(), $prism->getPer());
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['key', 'value_format', 'component'], function ($error) {
            Exception::throw($error);
        });
        $add = [
            'key' => $this->input('key'),
            'label' => $this->input('label') ?? $this->input('key'),
            'value_format' => $this->input('value_format'),
            'value_default' => $this->input('value_default') ?? '',
            'component' => $this->input('component'),
            'component_data' => $this->input('component_data') ?? '',
            'status' => $this->input('status') ?? Boolean::false,
            'sort' => $this->input('sort') ?? 0,
        ];
        return DB::connect()->table(self::TABLE)->insert($add);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function update()
    {
        ArrayValidator::required($this->input(), ['key'], function ($error) {
            Exception::throw($error);
        });
        $data = [
            'label' => $this->input('label'),
            'value_format' => $this->input('value_format'),
            'value_default' => $this->input('value_default'),
            'component' => $this->input('component'),
            'component_data' => $this->input('component_data'),
            'status' => $this->input('status'),
            'sort' => $this->input('sort'),
        ];
        if ($data) {
            return DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('key', $this->input('key')))
                ->update($data);
        }
        return true;
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function delete()
    {
        ArrayValidator::required($this->input(), ['key'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('key', $this->input('key')))
            ->delete();
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function multiStatus()
    {
        ArrayValidator::required($this->input(), ['keys', 'status'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('key', $this->input('keys')))
            ->update(["status" => $this->input('status')]);
    }

}