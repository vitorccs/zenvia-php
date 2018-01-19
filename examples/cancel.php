<?php
use Zenvia\Model\SmsFacade;

require_once('./configs.php');

$smsFacade = new SmsFacade($configs['alias'], $configs['password'], $configs['webServiceUrl']);

//Id da mensagem que deverá ser cancelada
$id = "id123cba";

try {
    $response = $smsFacade->cancel($id);
    //09 - Blocked 
    echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
    //002 - Message successfully canceled
    echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription();
    if ($response->getStatusCode() != "00") {
        echo "\nMensagem não pôde ser cancelada.";
    }
} catch (\Exception $ex) {
    echo "Falha ao fazer o cancelamento da mensagem. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
}
