<?php
use Zenvia\Model\SmsFacade;
use Zenvia\Model\Sms;

require_once('./configs.php');

$smsFacade = new SmsFacade($configs['alias'], $configs['password'], $configs['webServiceUrl']);

$smsList = array();

$sms = new Sms();
$sms->setTo("550099999991");
$sms->setMsg("Este é um teste de envio de mensagem multiplo utilizando a api php.");
$sms->setId(uniqid());
$sms->setCallbackOption(Sms::CALLBACK_NONE);

$date = new \DateTime();
$date->setTimeZone(new DateTimeZone('America/Sao_Paulo'));
$date->setDate(2014, 7, 28);
$date->setTime(13, 50, 0);
$schedule = $date->format("Y-m-d\TH:i:s");

//Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00"
$sms->setSchedule($schedule);

array_push($smsList, $sms);

$sms2 = new Sms();
$sms2->setTo("550099999992");
$sms2->setMsg("Este é um teste de envio de mensagem multiplo utilizando a api php.");
$sms2->setId(uniqid());
$sms2->setCallbackOption(Sms::CALLBACK_NONE);

$date2 = new \DateTime();
$date2->setTimeZone(new DateTimeZone('America/Sao_Paulo'));
$date2->setDate(2014, 7, 28);
$date2->setTime(13, 50, 00);
$schedule2 = $date2->format("Y-m-d\TH:i:s");

//Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00"
$sms2->setSchedule($schedule2);

array_push($smsList, $sms2);

try {
//Envia a lista de mensagens para o webservice e retorna uma lista de objetos do tipo SmsResponse com os staus das mensagens enviadas
    $responseList = $smsFacade->sendMultiple($smsList);

    foreach ($responseList as $response) {
        echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
        echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription() . "\n";
    }
} catch (\Exception $ex) {
    echo "Falha ao fazer o envio das mensagens. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
}
