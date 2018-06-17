# zenvia-php
Biblioteca PHP produzida pela Zenvia para integração com sua API 2.0. Colocamos no GitHub para fazer controle de versionamento e adicionar suporte PSR-4.

# Serviços da API
* Envio de um único SMS
* Envio de vários SMSs simultaneamente
* Consulta Status de um SMS
* Listar Novos SMS recebidos
* Consultar SMS recebidos por Período
* Cancelamento de SMS agendado 

# Módulo para recebimento de status (opcional)
Script para gravar o status de um SMS. A plataforma Zenvia envia o status dos SMS por uma chamada HTTP a uma URL do sistema do cliente.
Exemplo de URL: http://www.suaempresa.com.br/sistemasms/receber_status_sms_enviado.php

Este script tem a seguinte lógica:
* Recebe parâmetros de status via HTTP GET;
* Identifica em sua base de dados o SMS correspondente (pelo ID ou celular);
* Salva seu status final de entrega.


