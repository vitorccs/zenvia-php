<?php

class HttpResponseParser {

    /**
     * @param string
     * @return HttpResponse 
     */
    public function parse($httpContent) {
        $httpResponse = new HttpResponse();
        $responseArray = explode("\r\n\r\n", $httpContent);
        $headersData = $responseArray[0];
        $headersArray = explode("\n", $headersData);
        $totalHeaders = count($headersArray);
        for ($i = 0; $i < $totalHeaders; $i++) {
            $indexHttpHeader = strpos($headersArray[$i], "HTTP");
            if ($indexHttpHeader !== false) {
                //HTTP/1.1 200 OK
                $httpCode = substr($headersArray[$i], $indexHttpHeader + 9, 3);
                $httpDescription = substr($headersArray[$i], $indexHttpHeader + 13);
                $httpResponse->setHttpCode(intval(trim($httpCode)));
                $httpResponse->setHttpDescription(trim($httpDescription));
            } else {
                $httpResponse->addHeader($this->parseHeader($headersArray[$i]));                
            }
        }
        $bodyData = $this->getRequestBody($headersData, $responseArray[1]);    
        $httpResponse->setBody($bodyData);
        return $httpResponse;
    }

    /**
     * 
     * @param string $headerText
     * @return HttpHeader
     */
    private function parseHeader($headerText) {
        $indexVal = strpos($headerText, ":");
        $header=null;
        if ($indexVal !== false) {
            $headerName = substr($headerText, 0, $indexVal);
            $headerValue = substr($headerText, $indexVal + 1);
            $header = new HttpHeader($headerName, trim($headerValue));
        } else {
            $header = new HttpHeader("$i", trim($headerText));
        }
        return $header;
    }

    /**
     * 
     * @param string $headersData
     * @param string $bodyData
     * @return string
     */
    private function getRequestBody($headersData, $bodyData) {
        $content = $bodyData;
        if (!(strpos($headersData, "Transfer-Encoding: chunked") === false)) {
            $aux = explode("\r\n", $bodyData);
            $countAux = count($aux);
            for ($i = 0; $i < $countAux; $i++) {
                if ($i == 0 || ($i % 2) == 0) {
                    $aux[$i] = "";
                }
            }
            $content = implode("", $aux);
        }
        return $content;
    }

}
