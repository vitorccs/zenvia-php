<?php
/**
 * Classe que representa uma resposta contendo o status de uma mensagem.
 */
class SmsResponse {
   
    /**     
     * @var string Código do status da resposta
     */
    private $statusCode;
    /**     
     * @var string Descrição do status da resposta
     */
    private $statusDescription;
    /**     
     * @var string Código do detalhe do status da resposta
     */
    private $detailCode;
    /**     
     * @var string Descrição do detalhe do status da resposta
     */
    private $detailDescription;
    
    /**     
     * @param string $statusCode
     * @param string $statusDescription
     * @param string $detailCode
     * @param string $detailDescription
     */
    public function __construct($statusCode, $statusDescription, $detailCode, $detailDescription) {
        $this->statusCode=$statusCode;
        $this->statusDescription=$statusDescription;
        $this->detailCode=$detailCode;
        $this->detailDescription=$detailDescription;
    }
    
    /**
     * Método acessor ao código do status retornado na resposta.
     * @return string Código do status
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * Método acessor para a descrição do status retornado na resposta.
     * @return string Descrição do status
     */
    public function getStatusDescription() {
        return $this->statusDescription;
    }

    /**
     * Método acessor ao código do detalhe do status retornado na resposta.
     * @return string Código do detalhe do status
     */
    public function getDetailCode() {
        return $this->detailCode;
    }

    /**
     * Método acessor para a descrição do do detalhe do status retornado na resposta.
     * @return string Descrição do detalhe do status
     */
    public function getDetailDescription() {
        return $this->detailDescription;
    }

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    public function setStatusDescription($statusDescription) {
        $this->statusDescription = $statusDescription;
    }

    public function setDetailCode($detailCode) {
        $this->detailCode = $detailCode;
    }

    public function setDetailDescription($detailDescription) {
        $this->detailDescription = $detailDescription;
    }
    
    
}
