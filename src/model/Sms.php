<?php

/**
 * Representa uma mensagem SMS.
 */
class Sms {
    
    /**     
     * @var string Id da mensagem. Este atributo é opcional 
     */
    private $id=null;
    /**     
     * @var string Celular de destino. Este atributo é obrigatório 
     */
    private $to=null;
    /**     
     * @var string Mensagem a ser enviada. Este atributo é obrigatório 
     */
    private $msg=null;   
    /**     
     * @var string Remetente da mensagem. Este atributo é obrigatório para alguns tipos de conta 
     */
    private $from=null;
    /**     
     * @var string Tipo do callback da mensagem, pode ser NONE(não será retornado nenhum callback de status para a mensagem)
     * FINAL(serão retornados apenas os callbacks de status final para a mensagem) e 
     * ALL(todos os callbacks de status serão retornados para a mensagem). 
     */
    private $callbackOption=self::CALLBACK_NONE;    
    /**     
     * @var string Data do agendamento da mensagem no formato descrito na ISO 8601(yyyy-MM-dd'T'HH:mm:ss).
     * Este atributo é opcional e caso não seja informado serão usados a data e a hora do momento do envio.
     */    
    private $schedule=null;      
    private $timeToLive=null;
    private $expiryDate=null;
    
    const CALLBACK_NONE="NONE";
    const CALLBACK_FINAL="FINAL";
    const CALLBACK_ALL="ALL";
    
    /**     
     * Método de acesso ao id da mensagem.
     * @return string Id da mesangem.
     */
    public function getId() {
        return $this->id;
    }

    /**     
     * Método modificador de acesso do id da mensagem.
     * @param string $id Id da mensagem. 
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**     
     * Método de acesso ao remetente da mensagem.
     * @return string Remetente da mensagem.
     */
    public function getFrom() {
        return $this->from;
    }

    /**
     * Método modificador de acesso do remetente da mensagem.
     * @param string $from Remetente da mensagem.
     */
    public function setFrom($from) {
        $this->from = $from;
    }
    
    /**     
     * Método de acesso ao celular de destino da mensagem.
     * @return string Destino da mensagem
     */
    public function getTo() {
        return $this->to;
    }

    /**     
     * Método modificador de acesso do celular de destino da mensagem.
     * @param string $to Destino da mensagem
     */
    public function setTo($to) {
        $this->to = $to;
    }
    
    /**     
     * Método de acesso ao conteúdo da mensagem.
     * @return string Conteúdo da mensagem.
     */
    public function getMsg() {
        return $this->msg;
    }

    /**     
     * Método modificador de acesso do conteúdo da mensagem.
     * @param string $msg Conteúdo da mensagem.
     */
    public function setMsg($msg) {
        $this->msg = $msg;
    }
    
    /**   
     * Método de acesso para a data de agendamento da mensagem.  
     * @return string Data de agendamento da mensagem no formato ISO 8601(yyyy-MM-dd'T'HH:mm:ss)
     */
    public function getSchedule() {
        return $this->schedule;
    }

    /**     
     * @param string $schedule método modificador de acesso para a data de agendamento da mensagem.
     * O formato informado deverá ser o mesmo descrito na ISO 8601(yyyy-MM-dd'T'HH:mm:ss)
     */
    public function setSchedule($schedule) {
        $this->schedule = $schedule;
    }
    
    /**     
     * Método de acesso para o tipo de callback da mensagem.
     * @return string Tipo do callback da mensagem. 
     */
    public function getCallbackOption() {
        return $this->callbackOption;
    }

    /**     
     * Método modificador de acesso do tipo de callback da mensagem. 
     * @param string $callbackOption Tipo de do callback da mensagem. 
     * Poderá ser NONE, FINAL, ou ALL. 
     */
    public function setCallbackOption($callbackOption) {
        $this->callbackOption = $callbackOption;
    }  
    
    public function getTimeToLive() {
        return $this->timeToLive;
    }

    public function setTimeToLive($timeToLive) {
        $this->timeToLive = $timeToLive;
    }
    
    public function getExpiryDate() {
        return $this->expiryDate;
    }

    public function setExpiryDate($expiryDate) {
        $this->expiryDate = $expiryDate;
    }
    
}
