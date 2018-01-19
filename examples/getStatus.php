<?php

use Zenvia\Model\SmsFacade;

require_once('./configs.php');

$smsFacade = new SmsFacade($configs['alias'], $configs['password'], $configs['webServiceUrl']);

//Id da mensagem que deverá ser cancelada
$id = "53d67682504c8";

try {
    $response = $smsFacade->getStatus($id);
    //Código e descrição do status atual da mensagem
    echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
    //Código e descrição do detalhe do status atual da mensagem
    echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription();
    if ($response->getStatusCode() == "00") {
        //Id da mensagem
        echo "\nId: " . $response->getId();
        //Data de recebimento da mensagem no celular
        echo "\nRecebido em: " . $response->getReceived();
    } else {
        echo "\nStatus da mensagem não pôde ser consultado.";
    }
} catch (\Exception $ex) {
    echo "Falha ao fazer consulta de status da mensagem. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
}



     



        
