<?php

class URL {

    /**
     * @var string 
     */
    private $host;

    /**
     * @var string 
     */
    private $uri;

    /**
     * @var int 
     */
    private $port;

    /**
     * @var string 
     */
    private $queryString;
	
	/**
     * @var string 
     */
    private $scheme;
    
   /**
    * @param string $url
    */
    public function  __construct($url) {
       $this->fill($url);
    }
    
    private function fill($url){
        $parsedUrl = parse_url($url);                
        $this->host=$parsedUrl['host']; 
        $this->uri=$parsedUrl['path'];
		$this->scheme=$parsedUrl['scheme'];
        if(key_exists('port', $parsedUrl)){
            $this->port=$parsedUrl['port'];        
        }
        if(key_exists('query', $parsedUrl)){
             $this->queryString=$parsedUrl['query'];
        }       
    }

    public function getHost() {
        return $this->host;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getPort() {
        return $this->port;
    }

    public function getQueryString() {
        return $this->queryString;
    }
	
	public function getScheme() {
        return $this->scheme;
    }
    
    public function __toString() {
        $urlString=$this->host;
        if($this->port!=null && $this->port!=80){
            $urlString.=':'.$this->port;
        }
        if($this->uri!=null && $this->uri!=""){
            $urlString.=$this->uri;
        }
        if($this->queryString!=null && $this->queryString!=""){
            $urlString.='?'.$this->queryString;
        }
        return $urlString;
    }
    

}
