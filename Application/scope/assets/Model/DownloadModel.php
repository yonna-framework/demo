<?php

namespace Assets\Model;

class DownloadModel extends AbstractModel
{

    /**
     * @return \Assets\Bean\DownloadBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * @return array
     */
    public function access()
    {
        $url = $this->getBean()->getUrl();

        $header = $this->assetsHelper()->getHeaderByUrl($url);
        if (!$header) return $this->error('invalid url');

        $size = $header['CONTENT-LENGTH'];
        $ext = $this->assetsHelper()->getExtByFileName($header['FILE_NAME']);
        if (!$ext) $ext = $this->assetsHelper()->getExtByMime($header['CONTENT-TYPE']);
        if (!$ext) return $this->error('invalid ext');

        if ($this->getBean()->isCheckLevel()) {
            $levelInfo = $this->getUserCallLevel($this->getBean()->getAuthUid(), $ext, $size);
            if (!$levelInfo) {
                return $this->error($this->getFalseMsg());
            }
        }

        if ($size > 0) {
            $data = curlGet($url, 10);
            if (!$data) return $this->error('invalid data or too big');
        } else {
            $data = '';
        }

        $hash = $this->assetsHelper()->getFileHashByBin($data);
        $hashId = $hash[2];
        if (!$hashId) return $this->error('hash fail');

        $dir = $hash[0];
        $hash_file_name = $hashId . '.' . $ext;
        $download_url = $hash[1] . $hash_file_name;
        $filename = $header['FILE_NAME'] ?: $hashId . '.' . $ext;

        $dir = dirCheck($dir, true);
        if (!$dir) return $this->error('dir not exist');

        if (!is_file($dir . $hash_file_name)) {
            $size = @file_put_contents($dir . $hash_file_name, $data);
            if ($size === false) {
                return $this->error('can not save data to the path');
            }
        }
        $fileData = $this->db()->table('assets')->equalTo('hash_id', $hashId)->one();
        if (!$fileData) {
            $insertData = array(
                'create_time' => $this->db()->now(),
                'uid' => array($this->getBean()->getAuthUid()),
                'hash_id' => $hashId,
                'hash_file_name' => $hash_file_name,
                'file_name' => $filename,
                'file_ext' => $ext,
                'file_size' => $size,
                'content_type' => $header['CONTENT-TYPE'],
                'from_url' => $url,
                'download_url' => $download_url,
                'path' => $dir . $hash_file_name,
            );
            try {
                $this->db()->table('assets')->insert($insertData);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $fileData = $this->db()->table('assets')->equalTo('hash_id', $hashId)->one();
            if (!$fileData) {
                return $this->error('file data error');
            }
        }
        if (!in_array($this->getBean()->getAuthUid(), $fileData['assets_uid'])) {
            $fileData['assets_uid'][] = $this->getBean()->getAuthUid();
            $updateData = array(
                'uid' => $fileData['assets_uid'],
                'update_time' => $this->db()->now(),
            );
            try {
                $this->db()->table('assets')->equalTo('hash_id', $hashId)->update($updateData);
            } catch (\Exception $e) {
            }
        }
        $fileData['assets_error'] = 0;
        $fileData['assets_file_image'] = $this->getHost() . $this->assetsHelper()->getImageByContentType($fileData['assets_file_ext'], $fileData['assets_download_url']);
        $fileData['assets_download_url'] = $this->getHost() . $fileData['assets_download_url'];
        unset($fileData['assets_uid']);
        unset($fileData['assets_hash_id']);
        unset($fileData['assets_path']);
        unset($fileData['assets_from_url']);
        unset($fileData['assets_call_qty']);
        unset($fileData['assets_call_last_time']);
        unset($fileData['assets_create_time']);
        unset($fileData['assets_update_time']);
        return $this->success($fileData);
    }

}