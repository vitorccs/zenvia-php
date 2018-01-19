<?php

class HttpResponse {
    
    /**     
     * @var int 
     */
    private $httpCode;
    /**     
     * @var string 
     */
    private $httpDescription;
    /**     
     * @var array 
     */
    private $headers=array();
    /**
     * @var string 
     */
    private $body;
    /**
      * @var HttpRequest 
     */
    private $requestOrigin;
    
    public function getHttpCode() {
        return $this->httpCode;
    }

    public function getHttpDescription() {
        return $this->httpDescription;
    }

    public function setHttpCode($httpCode) {
        $this->httpCode = $httpCode;
    }

    public function setHttpDescription($httpDescription) {
        $this->httpDescription = $httpDescription;
    }

        
    public function getHeaders() {
        return $this->headers;
    }

    public function getBody() {
        return $this->body;
    }

    public function getRequestOrigin() {
        return $this->requestOrigin;
    }
      
    public function setBody($body) {
        $this->body = $body;
    }
    
    /**
     * @param HttpHeader $header
     */
    public function addHeader($header){
        array_push($this->headers, $header);
                
    }

    public function setRequestOrigin(HttpRequest $requestOrigin) {
        $this->requestOrigin = $requestOrigin;
    }
    
    public function __toString() {     
        $headers=null;
        if(is_array($this->headers)){
            $headers = implode(", ", $this->headers);
        }
        $responseString = get_class($this)."[Http Code=".$this->httpCode.'-'.$this->httpDescription.", \nHeaders=".$headers.", \nBody=".$this->body.", Request Origin=".$this->requestOrigin."]";
        return $responseString;
    }


    
    
}
