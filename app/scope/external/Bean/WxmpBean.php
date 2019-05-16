<?php
namespace External\Bean;
/**
 * Date: 2018/10/16
 */
class WxmpBean extends AbstractBean
{

    protected $behaviour;
    protected $state;
    protected $return_url;
    protected $code;

    protected $requestUri;
    protected $templateMsgParams;
    protected $customMsgParams;
    protected $qrcodeParams;
    protected $qrcodeRecordKey;

    protected $signature;
    protected $timestamp;
    protected $nonce;
    protected $msg_signature;
    protected $openid;

    /**
     * @return mixed
     */
    public function getBehaviour()
    {
        return $this->behaviour;
    }

    /**
     * @param mixed $behaviour
     */
    public function setBehaviour($behaviour): void
    {
        $this->behaviour = $behaviour;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->return_url;
    }

    /**
     * @param mixed $return_url
     */
    public function setReturnUrl($return_url): void
    {
        $this->return_url = $return_url;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * @param mixed $requestUri
     */
    public function setRequestUri($requestUri): void
    {
        $this->requestUri = $requestUri;
    }

    /**
     * @return mixed
     */
    public function getTemplateMsgParams()
    {
        return $this->templateMsgParams;
    }

    /**
     * @param mixed $templateMsgParams
     */
    public function setTemplateMsgParams($templateMsgParams): void
    {
        $this->templateMsgParams = $templateMsgParams;
    }

    /**
     * @return mixed
     */
    public function getCustomMsgParams()
    {
        return $this->customMsgParams;
    }

    /**
     * @param mixed $customMsgParams
     */
    public function setCustomMsgParams($customMsgParams): void
    {
        $this->customMsgParams = $customMsgParams;
    }

    /**
     * @return mixed
     */
    public function getQrcodeParams()
    {
        return $this->qrcodeParams;
    }

    /**
     * @param mixed $qrcodeParams
     */
    public function setQrcodeParams($qrcodeParams): void
    {
        $this->qrcodeParams = $qrcodeParams;
    }

    /**
     * @return mixed
     */
    public function getQrcodeRecordKey()
    {
        return $this->qrcodeRecordKey;
    }

    /**
     * @param mixed $qrcodeRecordKey
     */
    public function setQrcodeRecordKey($qrcodeRecordKey): void
    {
        $this->qrcodeRecordKey = $qrcodeRecordKey;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @param mixed $nonce
     */
    public function setNonce($nonce): void
    {
        $this->nonce = $nonce;
    }

    /**
     * @return mixed
     */
    public function getMsgSignature()
    {
        return $this->msg_signature;
    }

    /**
     * @param mixed $msg_signature
     */
    public function setMsgSignature($msg_signature): void
    {
        $this->msg_signature = $msg_signature;
    }

    /**
     * @return mixed
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @param mixed $openid
     */
    public function setOpenid($openid): void
    {
        $this->openid = $openid;
    }


}