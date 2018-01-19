<?php


class DefaultHttpClient implements HttpClient{
    
    /** 
     * @param HttpRequest $request
     * @param int $timeout
     * @return HttpResponse 
     * @throws RuntimeException
     */
    public function makeRequest($request, $timeout=null){                
        $response = null;
		$httpSocket=null;
        try{
            $httpString = $this->parseRequest($request);               
            $httpSocket = $this->createSocket($request->getURL(), $timeout);
            $this->makeHttpRequest($httpSocket, $httpString);   			
            $responseString = $this->retrieveHttpResponse($httpSocket);
            $response = $this->parseResponse($responseString, $request);
			$this->closeSocket($httpSocket);
        }catch(Exception $ex){ 
			$this->closeSocket($httpSocket);
            $exceptionMessage='Http Request Failed. Request['.$request.'], Response['.$response.'].';            
            throw new Exception($exceptionMessage, null, $ex);   
        }
        return $response;
    }
    
    
    /**
     * 
     * @param URL $url
     * @param int $timeout
     * @return resource
     * @throws RuntimeException
     */
    private function createSocket($url, $timeout=null){        
		$host=$url->getHost();
		$port = $url->getPort() == null ? 80 :  $url->getPort();
		if($url->getScheme() == 'https'){	
			$host='ssl://'.$url->getHost();
			$port = $url->getPort() == null ? 443 :  $url->getPort();
		}		
        $errorCode = null;
        $errorDescription = null;
		$socket = null;		
		if (is_null($timeout)){
			$socket = fsockopen($host, $port, $errorCode, $errorDescription);
		}
		else{
			$socket = fsockopen($host, $port, $errorCode, $errorDescription, $timeout);
		}	
        if (!is_resource($socket)) {
            throw new RuntimeException($errorCode . " (" . $errorDescription . ")");
        }        
        return $socket;
    }
	
	private function closeSocket($socket){
		if(is_resource($socket)){
			fclose($socket);
		}
	}
    
    private function makeHttpRequest($socket, $httpString){
        $this->checkSocket($socket);
        fwrite($socket, $httpString);
    }
    
    private function checkSocket($socket){
         if(!is_resource($socket)){
            throw new RuntimeException("Invalid socket resource.");
        }        
    }
    
    /**
     * 
     * @param string $responseString
     * @param HttpRequest $request
     * @return HttpResponse
     */
    private function parseResponse($responseString, $request){
        $responseParser = new HttpResponseParser();
        $response = $responseParser->parse($responseString);    
        $response->setRequestOrigin($request);
        return $response;
    }
    
    /**     
     * @param HttpRequest $request
     * @return string  
     */
    private function parseRequest($request){
        $requestParser = new HttpRequestParser();
        $httpString = $requestParser->parse($request);  
        return $httpString;
    }
    
    /**
     * 
     * @param resource $socket
     * @return string
     * @throws RuntimeException Caso não seja possível ler o recurso do caminho de origem
     */
    private function retrieveHttpResponse($socket){
        $this->checkSocket($socket);
        $responseContent = "";   
		$line="";
        while (!feof($socket)) {   			
			$line=fgets($socket, 128);
            $responseContent .= $line;
        }		
        if($responseContent==null || trim($responseContent) == "" ){
            throw new RuntimeException("Resource requested not found. Try change the request path.");
        }
        return $responseContent;
    }    
    
    
        
}
