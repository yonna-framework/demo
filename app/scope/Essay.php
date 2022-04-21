<?php

namespace App\Scope;

use App\Mapping\Common\Boolean;
use App\Mapping\Essay\EssayStatus;
use App\Prism\EssayPrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class Essay
 * @package App\Scope
 */
class Essay extends AbstractScope
{

    const TABLE = 'essay';

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->one();
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function multi(): array
    {
        $prism = new EssayPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getTitle() && $w->like('title', '%' . $prism->getTitle() . '%');
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
                $prism->getCategoryId() && $w->equalTo('category_id', $prism->getCategoryId());
                $prism->getIsExcellent() && $w->equalTo('is_excellent', $prism->getIsExcellent());
            })
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->multi();
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function pic(): array
    {
        $pic = [];
        $list = $this->multi();
        foreach ($list as $v) {
            if (!isset($pic[$v['essay_category_id']])) {
                $pic[$v['essay_category_id']] = [];
            }
            $essay_content = $v['essay_content'];
            preg_match_all('/<img(.*?)src="(.*?)"(.*?)>/', $essay_content, $imgs);
            if ($imgs[2]) {
                foreach ($imgs[2] as $img) {
                    $pic[$v['essay_category_id']][] = $img;
                }
            }
        }
        foreach ($pic as &$p) {
            $p = array_unique($p);
            sort($p);
        }
        return $pic;
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function page(): array
    {
        $prism = new EssayPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getTitle() && $w->like('title', '%' . $prism->getTitle() . '%');
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
                $prism->getCategoryId() && $w->equalTo('category_id', $prism->getCategoryId());
                $prism->getIsExcellent() && $w->equalTo('is_excellent', $prism->getIsExcellent());
            })
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->page($prism->getCurrent(), $prism->getPer());
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['title', 'category_id'], function ($error) {
            Exception::throw($error);
        });
        $content = $this->xoss_save($this->input('content') ?? '');
        $data = [
            'user_id' => $this->request()->getLoggingId(),
            'title' => $this->input('title'),
            'category_id' => $this->input('category_id') ?? 0,
            'status' => $this->input('status') ?? EssayStatus::DISABLED,
            'is_excellent' => $this->input('is_excellent') ?? Boolean::false,
            'likes' => $this->input('likes') ?? 0,
            'views' => $this->input('views') ?? 0,
            'content' => $content,
            'author' => $this->input('author') ?? 0,
            'publish_time' => $this->input('publish_time') ?? time(),
            'sort' => $this->input('sort') ?? 0,
        ];
        return DB::connect()->table(self::TABLE)->insert($data);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function update()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $content = $this->xoss_save($this->input('content') ?? null);
        $data = [
            'title' => $this->input('title'),
            'category_id' => $this->input('category_id'),
            'status' => $this->input('status'),
            'is_excellent' => $this->input('is_excellent'),
            'likes' => $this->input('likes'),
            'views' => $this->input('views'),
            'content' => $content,
            'author' => $this->input('author'),
            'publish_time' => $this->input('publish_time'),
            'sort' => $this->input('sort'),
        ];
        if ($data) {
            return DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
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
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->delete();
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function multiDelete()
    {
        ArrayValidator::required($this->input(), ['ids'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('id', $this->input('ids')))
            ->delete();
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
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('id', $this->input('ids')))
            ->update(["status" => $this->input('status')]);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function views()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->update([
                'views' => ['exp', '`views`+1']
            ]);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function likes()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->update([
                'likes' => ['exp', '`likes`+1']
            ]);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function excellent()
    {
        ArrayValidator::required($this->input(), ['id', 'is_excellent'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->update([
                'is_excellent' => $this->input('is_excellent') === 1 ? Boolean::true : Boolean::false
            ]);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function top()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->update([
                'sort' => time()
            ]);
    }

}