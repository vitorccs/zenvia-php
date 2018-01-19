<?php
/**
 * Classe que representa uma resposta a uma consulta de status de uma mensagem.  
 */
class SmsStatusResponse extends SmsResponse{
    /**     
     * @var string Id da mensagem enviada. 
     */
    private $id;
    /**     
     * @var string data de recebimento da mensagem no formato ISO 8601(yyyy-MM-dd'T'HH:mm:ss) 
     */
    private $received;
    /**     
     * @var string Shortcode da mensagem consultada 
     */
    private $shortCode;
    /**     
     * @var string Operadora da mensagem consultada.  
     */    
    private $mobileOperatorName;
    
    public function __construct($statusCode="", $statusDescription="", $detailCode="", $detailDescription="") {
        parent::__construct($statusCode, $statusDescription, $detailCode, $detailDescription);
    }
    
     /**
     * Método acessor ao id da mensagem consultada.
     * @return string Id da mensagem consultada.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Método acessor para a data de recebimento da mensagem consultada.
     * @return string Data de recebimento da mensagem consultada.
     */
    public function getReceived() {
        return $this->received;
    }

    /**
     * Método acessor ao shortcode da mensagem consultada.
     * @return string Shortcode da mensagem consultada.
     */
    public function getShortCode() {
        return $this->shortCode;
    }

    /**
     * Método acessor para a operadora da mensagem consultada.
     * @return string Operadora da mensagem consultada.
     */
    public function getMobileOperatorName() {
        return $this->mobileOperatorName;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setReceived($received) {
        $this->received = $received;
    }

    public function setShortCode($shortCode) {
        $this->shortCode = $shortCode;
    }

    public function setMobileOperatorName($mobileOperatorName) {
        $this->mobileOperatorName = $mobileOperatorName;
    }


    
   
}
