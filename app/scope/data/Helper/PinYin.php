<?php
namespace Data\Helper;
/**
 * 拼音
 * Date: 2018/05/15
 */
use Common\Helper\AbstractHelper;

class PinYin extends AbstractHelper {

    private $py = null;

    private function py(){
        if($this->py===null){
            $this->py = include_once("PinYinArray.php");
        }
        return $this->py;
    }

    public function get($letter){
        $allLetters = $this->py();
        return $word = isset($allLetters[$letter]) ? $allLetters[$letter] : $letter;
    }

    public function getFirstUpper($letter){
        $allLetters = $this->py();
        if(isset($allLetters[$letter])){
            $word = $allLetters[$letter];
            $letter = mb_substr($word,0,1,'utf-8');
            return strtoupper($letter);
        }
        return $letter;
    }

    //测试用，自行输入txt
    public function test($txt=null){
        !$txt && $txt = '莫焕晶归案后均供认，其点火的时间为4时55分左右，其用打火机两次点书本，在第一次未点燃封皮后又点燃书的内页，看到书燃起火星后将书本扔在布艺沙发上，随后沙发、窗帘被迅速引燃。故莫焕晶在案发前多次搜索与放火相关的信息，案发时点燃书本，并将已引燃的书本扔掷在易燃物上，引发大火，显系故意放火，辩护人所提莫焕晶无放火故意的辩护意见与查明的事实不符，不予采纳';
        $len = (mb_strlen($txt,'utf-8'));
        $t1 = $t2 = $t3 = '';
        for ($i=0;$i<$len;$i++){
            $firstLetter = mb_substr($txt,$i,1,'utf-8');
            $t1 .= $firstLetter;
            $t2 .= $this->get($firstLetter);
            $t3 .= $this->getFirstUpper($firstLetter);
        }
        var_dump($t1);
        var_dump($t2);
        var_dump($t3);
    }
}