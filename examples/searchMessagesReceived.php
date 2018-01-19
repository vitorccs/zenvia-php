<?php
use Zenvia\Model\Sms;

require_once('./configs.php');

$smsFacade = new SmsFacade($configs['alias'], $configs['password'], $configs['webServiceUrl']);

$date = new \DateTime();
$date->setDate(2014, 5, 1);
$date->setTime(0, 0, 0);

//Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00".  
$startPeriod = $date->format("Y-m-d\TH:i:s");

$date2 = new \DateTime();
$date2->setDate(2014, 7, 1);
$date2->setTime(23, 29, 29);
//Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00". 
$endPeriod = $date2->format("Y-m-d\TH:i:s");

//Id da mensagem de origem que deverá ser usado como filtro na consulta.
$smsId = "53d67682504c8";
//Celular da mensagem  que deverá ser usado como filtro na consulta.
$mobile = "550099999999";

try {

    //Pesquisa por mensagens recebidas que obedeçam ao filtro passado. Retorna um objeto do tipo SmsReceivedResponse 
    //que conterá as mensagens recebidas.
    //Os parametros startPeriod e endPeriod são obrigatórios.
    //Os parametros mobile e smsId são opcionais.
    $response = $smsFacade->searchMessagesReceived($startPeriod, $endPeriod, $mobile, $smsId);

    echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
    echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription();
    if ($response->hasMessages()) {
        $messages = $response->getReceivedMessages();
        foreach ($messages as $smsReceived) {
            echo "\nCelular: " . $smsReceived->getMobile();
            echo "\nData de recebimento: " . $smsReceived->getDateReceived();
            echo "\nMensagem: " . $smsReceived->getBody();
            //Id da mensagem que originou a mensagem de resposta
            echo "\nId da mensagem de origem: " . $smsReceived->getSmsOriginId();
        }
    } else {
        echo "\nNão foram encontradas mensagens recebidas.";
    }
} catch (\Exception $ex) {
    echo "Falha ao pesquisar pelas mensagens recebidas. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
}
