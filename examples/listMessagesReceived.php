<?php
use Zenvia\Model\SmsFacade;

require_once('./configs.php');

$smsFacade = new SmsFacade($configs['alias'], $configs['password'], $configs['webServiceUrl']);

try {
    //Lista todas mensagens recebidas que ainda não foram consultadas. Retorna um objeto do tipo SmsReceivedResponse 
    //que conterá as mensagens recebidas.
    $response = $smsFacade->listMessagesReceived();

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
    echo "Falha ao listar as mensagens recebidas. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
}
