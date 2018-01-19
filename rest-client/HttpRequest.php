<?php


class HttpRequest {
   
    const HTTP_GET="GET";
    const HTTP_POST="POST";
    const HTTP_PUT="PUT";
    const HTTP_DELETE="DELETE";    
    
    /**
     *
     * @var URL 
     */
    private $url;    
    
    /**     
     * @var array 
     */
    private $headers=array();
    /**     
     * @var string 
     */
    private $method;
    /**
     * @var string 
     */
    private $body;
  
    public function getMethod() {
        return $this->method;
    }
    
    public function setMethod($method) {
        $this->method = $method;
    }
    
    public function getHeaders(){
        return $this->headers;
    }

    /**     
     * @param HttpHeader $header
     */
    public function addHeader($header){
        array_push($this->headers, $header);
    }
    
    public function hasHeader($name){
        $hasHeader = false;
        foreach($this->headers as $header){
            if($header->getName() == $name){
                $hasHeader=true;
            }
        }
        return $hasHeader;
        
    }
    
    /**     
     * @return URL
     */
    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }


    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    
    public function __toString() {                
        $requestString = get_class($this).'[url='.$this->url.', method='.$this->method.', body='.$this->body;
        return $requestString;
    }

        
    
    
    
}
