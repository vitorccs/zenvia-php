<?php

/**
 * Classe que representa uma mensagem recebida.
 */
class SmsReceived {
    
   /**    
    * @var long Id da mensagem recebida.
    */
    private $id;
    /**
     * @var string Data de recebimento da mensagem.
     */
    private $dateReceived;
    /**     
     * @var string Celular da mensagem recebida.
     */
    private $mobile;
    /**
     * @var string Conteúdo da mensagem recebida.
     */
    private $body;
    /**
     * @var string Shortcode da mensagem recebida.
     */
    private $shortCode;
    /**
     * @var string Nome da operadora do celular da mensagem recebida.
     */
    private $mobileOperatorName;
    /**
     * @var string Id da mensagem que originou a mensagem recebida.
     */
    private $smsOriginId;
    
    /**
     * Método acessor ao id da mensagem.
     * @return long Id da mensagem recebida
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Método acessor para a data de recebimento da mensagem.
     * @return string Data de recebimento da mensagem no formato ISO 8601(yyyy-MM-dd'T'HH:mm:ss).  
     */
    public function getDateReceived() {
        return $this->dateReceived;
    }

    /**
     * Método acessor ao celular da mensagem recebida.
     * @return string Celular da mensagem recebida
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * Método acessor ao conteúdo da mensagem recebida.
     * @return string Conteúdo da mensagem recebida
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Método acessor ao Shortcode da mensagem recebida.
     * @return string Shortcode da mensagem recebida
     */
    public function getShortCode() {
        return $this->shortCode;
    }

    /**
     * Método acessor para a operadora do celular da mensagem recebida.
     * @return string Operadora celular da mensagem recebida
     */
    public function getMobileOperatorName() {
        return $this->mobileOperatorName;
    }

    /**
     * Método acessor ao id do SMS de origem da mensagem recebida.
     * @return string Id do SMS de origem da mensagem recebida.
     */
    public function getSmsOriginId() {
        return $this->smsOriginId;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDateReceived($dateReceived) {
        $this->dateReceived = $dateReceived;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function setShortCode($shortCode) {
        $this->shortCode = $shortCode;
    }

    public function setMobileOperatorName($mobileOperatorName) {
        $this->mobileOperatorName = $mobileOperatorName;
    }

    public function setSmsOriginId($smsOriginId) {
        $this->smsOriginId = $smsOriginId;
    }


            
    
}
