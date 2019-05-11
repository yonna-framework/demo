<?php
namespace System\Model;

class ScopeModel extends AbstractModel {

    private function scanModel($dir, $model = array())
    {
        $files = opendir($dir);
        while ($file = readdir($files)) {
            if ($file != '.' && $file != '..') {
                $realFile = $dir . '/' . $file;
                if (is_dir($realFile)) {
                    $model = $this->scanModel($realFile, $model);
                } elseif (strpos($file, PHP_EXT) === false) {
                    continue;
                } elseif (strpos($realFile, 'Model') !== false
                    && strpos($realFile, 'Common') === false
                    && strpos($realFile, 'Abstract') === false) {
                    $model[] = $realFile;
                }
            }
        }
        closedir($files);
        return $model;
    }

    public function getList(){
        $path = realpath(__DIR__.'/../../');
        $model = $this->scanModel($path);
        $activeDir = str_replace('\\', '/', $path);
        $scope = array();
        foreach ($model as $m) {
            $m = str_replace('\\', '/', $m);
            $modelDir = $m;
            $modelDir = str_replace($activeDir, '', $modelDir);
            $modelDir = str_replace(PHP_EXT, '', $modelDir);
            $modelDir = str_replace('/', '\\', $modelDir);
            $sss = str_replace('Model', '.', $modelDir);
            $sss = str_replace('\\', '', $sss);
            $pclass = get_class_methods(get_parent_class($modelDir));
            $class = get_class_methods($modelDir);
            $class = array_diff($class,$pclass);
            foreach ($class as $c) {
                if (strpos($c, '__') !== false) {
                    continue;
                }
                $scope[] = $sss . $c;
            }
        }
        return $this->success($scope);
    }

}