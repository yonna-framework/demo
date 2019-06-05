<?php

$ctx = \Str::randomLetter(random_int(100,100000));
$name = md5($ctx);
$a = \Convert::limitConvert($name, 16);
$a = str_pad($a, 24, '0');
$a = str_split($a, 4);
$a = __DIR__ . '/f/' . implode(DIRECTORY_SEPARATOR, $a) . DIRECTORY_SEPARATOR;
\System::dirCheck($a,true);
file_put_contents("{$a}{$name}", $ctx);
var_dump($a);
exit();

$file = $this->request->input->getFile()[0];
file_put_contents(
    __DIR__ . DIRECTORY_SEPARATOR . $file['name'],
    file_get_contents($file['tmp_name'])
);
$val = realpath(__DIR__ . DIRECTORY_SEPARATOR . $file['name']);

$zip = new \ZipArchive();
if ($zip->open(__DIR__ . '/test.zip', \ZIPARCHIVE::CREATE) !== true) {
    throw new \Exception('无法打开文件或zip文件创建失败');
}
if (file_exists($val)) {
    //第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
    $zip->addFile($val, basename($val));
}
$zip->close();//关闭
exit();