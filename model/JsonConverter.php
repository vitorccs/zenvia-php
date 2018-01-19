<?php

/**
 * Classe responsável por fazer as conversões para o formato json utilizados no webservice.
 */
class JsonConverter {
    
    /**
     * Retorna a representação json de um envio simples.
     * @param Sms $sms mensagem a ser enviada
     * @param int $aggregateId id do agrupador
     * @return string|null string no formato json
     */
    public static function smsToJson($sms, $aggregateId=null){  
        $baseJson=self::getJsonBase($sms, $aggregateId);
        $json = '{"sendSmsRequest":'.$baseJson.'}';
        return $json;
    }
        
    /**
     * Retorna a representação json de um envio múltiplo.
     * @param array $smsList lista de mensagens SMS a serem enviadas.
     * @param int $aggregateId id do agrupador
     * @return string|null
     */
    public static function smsListToJson($smsList, $aggregateId=null){       
        if(is_array($smsList)){
            $json = '{"sendSmsMultiRequest":{';            
            if($aggregateId!=null){
                $json .= '"aggregateId":'.$aggregateId.',';
            }
            $json .= '"sendSmsRequestList":[';
            foreach($smsList as $sms){               
                $json .= self::getJsonBase($sms).',';                
            }      
            $json = rtrim($json, ',');
            $json .= ']}}';
            return $json;            
        }
        return null;
        
    }
    
    /**
     * 
     * @param Sms $sms
     * @param int $aggregateId
     * @return string
     */
    private static function getJsonBase($sms, $aggregateId=null){
        $obj = new stdClass();       
        if($sms->getId()!=null){
            $obj->id=$sms->getId(); 
        } 
        if($sms->getMsg()!=null){
            $obj->msg=$sms->getMsg();
        }
        if($sms->getTo()!=null){
            $obj->to=$sms->getTo();
        }
        if($sms->getCallbackOption()!=null){
            $obj->callbackOption=$sms->getCallbackOption();
        }
        if($sms->getSchedule()!=null){
            $obj->schedule=$sms->getSchedule();
        }
        if($sms->getFrom()!=null){
            $obj->from=$sms->getFrom();
        }
        if($sms->getExpiryDate()!=null){
            $obj->expiryDate=$sms->getExpiryDate();
        }
        if($sms->getTimeToLive()!=null){
            $obj->timetoLive=$sms->getTimeToLive();
        }    
        if($aggregateId!=null){
            $obj->aggregateId=$aggregateId;
        }
        
        return json_encode($obj);
        
    }
    
}
