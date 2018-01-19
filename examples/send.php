<?php
use Zenvia\Model\SmsFacade;
use Zenvia\Model\Sms;

require_once('./configs.php');

$smsFacade = new SmsFacade($configs['alias'], $configs['password'], $configs['webServiceUrl']);

$sms = new Sms();
$sms->setTo("550099999999");
$sms->setMsg("Este e um teste de envio de mensagem simples utilizando a api php.");
$sms->setId(uniqid());
$sms->setCallbackOption(Sms::CALLBACK_NONE);

$date = new \DateTime();
$date->setTimeZone(new DateTimeZone('America/Sao_Paulo'));
$date->setDate(2014, 7, 28);
$date->setTime(13, 50, 00);
$schedule = $date->format("Y-m-d\TH:i:s");

//Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00"
$sms->setSchedule($schedule);

try{
    //Envia a mensagem para o webservice e retorna um objeto do tipo SmsResponse com o status da mensagem enviada
    $response = $smsFacade->send($sms);

    echo "Status: ".$response->getStatusCode() . " - " . $response->getStatusDescription(); 
    echo "\nDetalhe: ".$response->getDetailCode() . " - " . $response->getDetailDescription();

    if($response->getStatusCode()!="00"){
       echo "\nMensagem não pôde ser enviada.";
    } 

}     
catch(\Exception $ex){
    echo "Falha ao fazer o envio da mensagem. Exceção: ".$ex->getMessage()."\n".$ex->getTraceAsString();
}


        
