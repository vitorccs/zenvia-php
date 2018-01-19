<?php
/** 
 * Classe que serve como fachada para acesso ao webservice de envio e consulta de mensagens.   
 */
class SmsFacade {
    
   
    /**     
     * @var RestClient 
     */    
    private $client;
    /**     
     * @var string 
     */
    private $accountAlias;
    /**     
     * @var string 
     */
    private $accountPassword;
    /**
     *
     * @var string  
     */
    private $webServiceUrl;
   
    const DEFAULT_WEBSERVICE_URL="https://api-rest.zenvia360.com.br";
    
   
    
    /**     
     * @param string $accountAlias Alias da conta que será utilizada para autenticação no webservice.
     * @param string $accountPassword Senha da conta que será utilizada para autenticação no webservice.
     * @param string $webServiceUrl URL do webservice. Caso seja nulo será o usado o valor de @see SmsFacade::DEFAULT_WEBSERVICE_URL 
     */
    public function __construct($accountAlias, $accountPassword, $webServiceUrl=null) {
        $this->accountAlias = $accountAlias;                
        $this->accountPassword = $accountPassword;                
        if($webServiceUrl==null){            
            $this->webServiceUrl=self::DEFAULT_WEBSERVICE_URL;
        }
        else{
            $this->webServiceUrl=$webServiceUrl;
        }
        $this->client=new RestClient();
        
    }
    
    /**
     * Faz um envio de mensagem simples.
     * @param Sms $sms O SMS que deverá ser enviado. Este parâmetro é obrigatório
     * @param int $aggregateId O id do agrupador que deverá ser relacionado ao envio. 
     * Este parâmetro será obrigatório apenas se a conta possuir a configuração de agrupador habilitada.
     * @return SmsResponse Resposta com o status e o detalhe da mensagem enviada
     * @throws RuntimeException
     */    
    public function send($sms, $aggregateId=null){
        $headers = $this->getBaseHeaders();    
        $json = JsonConverter::smsToJson($sms, $aggregateId);                
        $client = $this->client;
        $url=$this->webServiceUrl."/services/send-sms";
        $response = $client->post($url, $json, $headers);    
        $this->checkResponse($response);
        $obj = json_decode($response->getBody());
        $sendSmsResponse=$obj->sendSmsResponse;    
        $smsResponse = new SmsResponse($sendSmsResponse->statusCode,  $sendSmsResponse->statusDescription,  $sendSmsResponse->detailCode,  $sendSmsResponse->detailDescription);
        return $smsResponse;
    }
    
    /**
     * Faz um envio de mensagem múltiplo.
     * @param array $smsList Array contendo uma lista de SMS para serem enviados.Este parâmetro é obrigatório
     * @param int $aggregateId O id do agrupador que deverá ser relacionado ao envio. 
     * Este parâmetro será obrigatório apenas se a conta possuir a configuração de agrupador habilitada.
     * @return array Lista de objetos do tipo SmsResponse.
     * @throws RuntimeException
     */
    public function sendMultiple($smsList, $aggregateId=null){
        $headers = $this->getBaseHeaders();    
        $json = JsonConverter::smsListToJson($smsList, $aggregateId);       
        $client = $this->client;
        $url=$this->webServiceUrl."/services/send-sms-multiple";
        $response = $client->post($url, $json, $headers);
        $this->checkResponse($response);
        $obj = json_decode($response->getBody());
        $responses = array();                
        if(is_object($obj)){
            foreach($obj->sendSmsMultiResponse->sendSmsResponseList as $sendSmsResponse){
                $smsResponse = new SmsResponse($sendSmsResponse->statusCode,  $sendSmsResponse->statusDescription,  $sendSmsResponse->detailCode,  $sendSmsResponse->detailDescription);
                array_push($responses, $smsResponse);
            }
        }
        return $responses;
    }
    
    /**
     * Faz o cancelamento de uma mensagem.
     * @param string $id Id da mensagem que deverá ser cancelada. Este parâmetro é obrigatório.
     * @return SmsResponse Resposta com o status e o detalhe da operação de cancelamento.
     * @throws RuntimeException
     */    
    public function cancel($id){
        $headers = $this->getBaseHeaders();           
        $client = $this->client;
        $url=$this->webServiceUrl."/services/cancel-sms/".$id;        
        $response = $client->post($url, null, $headers);    
        $this->checkResponse($response);
        $obj = json_decode($response->getBody()); 
        $cancelSmsResp=$obj->cancelSmsResp;            
        $smsResponse = new SmsResponse($cancelSmsResp->statusCode,  $cancelSmsResp->statusDescription,  $cancelSmsResp->detailCode,  $cancelSmsResp->detailDescription);
        return $smsResponse;
    }
    
    /**
     * Faz a consulta do status atual de uma mensagem enviada. 
     * @param string $id Id da mensagem a ser consultada. Este parâmetro é obrigatório.     
     * @return SmsStatusResponse Resposta com o status e o detalhe da mensagem a ser consultada.
     * @throws RuntimeException 
     */    
    public function getStatus($id){
        $headers = $this->getBaseHeaders();                                    
        $headers['Content-Type']=null;        
        $client = $this->client;
        $url=$this->webServiceUrl."/services/get-sms-status/".$id;
        $response = $client->get($url, $headers);   
        $this->checkResponse($response);
        $obj = json_decode($response->getBody());        
        $statusSms=$obj->getSmsStatusResp;           
        $statusResponse = new SmsStatusResponse();
        $statusResponse->setStatusCode($statusSms->statusCode);
        $statusResponse->setStatusDescription($statusSms->statusDescription);
        $statusResponse->setDetailCode($statusSms->detailCode);
        $statusResponse->setDetailDescription($statusSms->detailDescription);
        $statusResponse->setId($statusSms->id);
        $statusResponse->setReceived($statusSms->received);
        $statusResponse->setShortCode($statusSms->shortcode);
        $statusResponse->setMobileOperatorName($statusSms->mobileOperatorName);        
        return $statusResponse;
    }
    
    /**
     * Faz a listagem de mensagens recebidas que ainda não foram consultadas.
     * Os SMS recebidos retornados por esta consulta só poderão ser consultados apenas uma única vez  
     * de forma que se um SMS é retornado nesta consulta o mesmo não será listado novamente em uma consulta posterior.
     * Caso seja necessário consultar as mesmas mensagens recebidas múltiplas vezes, deverá ser usado o método @see SmsFacade::searchMessagesReceived
     * @return SmsReceivedResponse Resposta com as mensagens recebidas.
     * @throws RuntimeException 
     */
    public function listMessagesReceived(){
        $headers = $this->getBaseHeaders();           
        $client = $this->client;
        $url=$this->webServiceUrl."/services/received/list";
        $response = $client->post($url, null, $headers);      
        $this->checkResponse($response);
        $smsResponse = $this->parseMoList($response->getBody());     
        return $smsResponse;
    }
    
   /**
    * Faz a consulta de todas as mensagens recebidas no período informado. Este método deverá 
    * retornar todas as mensagens recebidas que coincidirem com o filtro passado 
    * independentemente se as mesmas já terem sido consultadas anteriormente.  
    * @param string $startPeriod Data inicial no formato descrito na ISO 8601(yyyy-MM-dd'T'HH:mm:ss). Este parâmetro é obrigatório.
    * @param string $endPeriod Data final no formato descrito na ISO 8601(yyyy-MM-dd'T'HH:mm:ss). Este parâmetro é obrigatório. 
    * @param string $mobile Celular a ser utilizado na pesquisa de mensagens recebidas.
    * @param $smsId $smsId Id da mensagem de origem a ser utilizado na pesquisa de mensagens recebidas.
    * @return SmsReceivedResponse Resposta com as mensagens recebidas.
    * @throws RuntimeException 
    */
    public function searchMessagesReceived($startPeriod, $endPeriod, $mobile=null, $smsId=null ){
        $headers = $this->getBaseHeaders();
        $headers['Content-Type']=null;
         $client = $this->client;
        $url=$this->webServiceUrl."/services/received/search/".rawurlencode($startPeriod).'/'.rawurlencode($endPeriod).'?';              
        if($mobile!=null){
            $url .='mobile='.rawurlencode($mobile).'&';                    
        }
        if($smsId!=null){
            $url .='mtId='.rawurlencode($smsId);                    
        } 
        $url = rtrim($url, '&');
        $response = $client->get($url, $headers);  
        $this->checkResponse($response);
        $smsResponse = $this->parseMoList($response->getBody());
        return $smsResponse;
    }
    
    /**
     * Faz o parse do json de resposta com a representação da lista de mensagens recebidas do webservice para um objeto @see SmsReceivedResponse. 
     * @param string $jsonResponse Json retornado pelo webservice.
     * @return SmsReceivedResponse Resposta com as mensagens recebidas.
     */
    private function parseMoList($jsonResponse){
        $obj = json_decode($jsonResponse);          
        $smsResponse = new SmsReceivedResponse($obj->receivedResponse->statusCode, $obj->receivedResponse->statusDescription, $obj->receivedResponse->detailCode, $obj->receivedResponse->detailDescription);
        if( is_array($obj->receivedResponse->receivedMessages) && count($obj->receivedResponse->receivedMessages) > 0  ){
            foreach($obj->receivedResponse->receivedMessages as $message){
                $receivedMessage = new SmsReceived();
                $receivedMessage->setBody($message->body);
                $receivedMessage->setDateReceived($message->dateReceived);
                $receivedMessage->setId($message->id);
                $receivedMessage->setMobile($message->mobile);
                $receivedMessage->setMobileOperatorName($message->mobileOperatorName);
                $receivedMessage->setShortCode($message->shortcode);
                $receivedMessage->setSmsOriginId($message->mtId);
                $smsResponse->addReceivedMessage($receivedMessage);
            }
        }  
        return $smsResponse;        
    }    
    
    /**
     * Verifica se o serviço retornou uma resposta válida.
     * @param HttpResponse $response
     * @throws RuntimeException Se o servidor restornou uma resposta inválida.
     */
    private function checkResponse($response){
        if($response->getHttpCode()>= 400){
            $exceptionMessage=$response->getHttpCode().' - '.$response->getHttpDescription()." \nServer Response\n".$response->getBody()."."."\nApi Request\n[".$response->getRequestOrigin();            
            throw new RuntimeException($exceptionMessage);   
        }
    }
      
    /**
     * Headers base para as requisições.
     * @return array Array associativo com os headers comuns das requisições.
     */
    private function getBaseHeaders(){
        $accountAlias=$this->accountAlias;
        $accountPassword=$this->accountPassword;        
        $headers = array(
                        'Accept'=>'application/json',
                        'Content-Type'=>'application/json; charset=UTF-8',
                        'Authorization'=> 'Basic '.  base64_encode($accountAlias.':'.$accountPassword)
                    );
        return $headers;
    }
}
