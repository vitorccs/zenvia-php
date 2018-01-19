<?php

/**
 * Classe que representa uma resposta contendo um conjunto de mensagens recebidas.
 */
class SmsReceivedResponse extends SmsResponse{
    
    /**     
     * @var array Lista com as mensagens recebidas na resposta.
     */
    private $receivedMessages=array();
    
    /**     
     * Verifica se há mensagens recebidas na resposta.
     * @return bool 
     */
    public function hasMessages(){
        return count($this->receivedMessages);
    }
    
    /**
     * Adiciona uma mensagem recebida à lista de mensagens recebidas.
     * @param SmsReceived $receivedMessage
     */
    public function addReceivedMessage($receivedMessage){
        array_push($this->receivedMessages, $receivedMessage);
    }
    
    /**
     * Retorna a lista de mensagens recebidas da resposta.
     * @return array Lista com as mensagens recebidas.
     */
    public function getReceivedMessages(){
        return $this->receivedMessages;
    }
    
    
}
