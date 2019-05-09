<?php

namespace External\Model;

use plugins\PHPMailer\PHPMailer;
use External\Bean\EmailBean;

class EmailModel extends AbstractModel
{

    /**
     * @return EmailBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * @return boolean
     */
    public function send()
    {
        $bean = $this->getBean();
        if (!$bean->getRecipients()) return $this->false('缺少收件人');
        if (!$bean->getRecipientName()) return $this->false('缺少收件人名称');
        if (!$bean->getTitle()) return $this->false('缺少标题');
        if (!$bean->getContent()) return $this->false('缺少内容');

        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), $bean->isAutoDefault());
        if (empty($externalConfigKV)) {
            return $this->false('配置错误');
        }
        $thisConfig = $externalConfigKV['email'];
        if (!$thisConfig['smtp_host']) return $this->false('无效的' . $thisConfig['smtp_host_label']);
        if (!$thisConfig['smtp_port']) return $this->false('无效的' . $thisConfig['smtp_port_label']);
        if (!$thisConfig['smtp_auth']) return $this->false('无效的' . $thisConfig['smtp_auth_label']);
        if (!$thisConfig['username']) return $this->false('无效的' . $thisConfig['username_label']);
        if (!$thisConfig['from_address']) return $this->false('无效的' . $thisConfig['from_address_label']);
        if (!$thisConfig['from_name']) return $this->false('无效的' . $thisConfig['from_name_label']);
        if (!$thisConfig['password']) return $this->false('无效的' . $thisConfig['password_label']);
        if (!$thisConfig['charset']) return $this->false('无效的' . $thisConfig['charset_label']);
        if (!$thisConfig['ishtml']) return $this->false('无效的' . $thisConfig['ishtml_label']);

        $mail = new PHPMailer(); //实例化
        $mail->IsSMTP(); //启用SMTP
        $mail->Host = $thisConfig['smtp_host']; //smtp服务器的名称
        $mail->SMTPAuth = $thisConfig['smtp_auth'] === '1' ? true : false; //启用smtp认证
        $mail->Port = $thisConfig['smtp_port']; //SMTP服务器的端口号
        $mail->Username = $thisConfig['username']; //邮箱名
        $mail->Password = $thisConfig['password']; //邮箱密码
        $mail->From = $thisConfig['from_address']; //发件人地址
        $mail->FromName = $thisConfig['from_name']; //发件人姓名
        $mail->WordWrap = 100; //设置每行字符长度
        $mail->CharSet = $thisConfig['charset']; //设置邮件编码
        $mail->Subject = $bean->getTitle(); //todo 邮件主题
        $mail->Body = $bean->getContent(); //todo 邮件内容
        $mail->AltBody = strip_tags($bean->getContent()); //邮件正文不支持HTML的备用显示
        $mail->AddAddress($bean->getRecipients(), $bean->getRecipientName()); //todo 设定地址
        $mail->IsHTML($thisConfig['ishtml'] === '1' ? true : false); //是否HTML格式邮件
        try {
            $result = $mail->Send();
        } catch (\Exception $e) {
            return $this->false($e->getMessage());
        }
        if (!$result) {
            return $this->false('发送邮件失败!');
        }
        return $this->true('sent!');
    }

}