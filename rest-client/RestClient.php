<?php


class RestClient {
    
    /**     
     * @var HttpClient 
     */
    private $httpClient = null;
    const DEFAULT_CONTENT_TYPE="application/x-www-form-urlencoded;charset=UTF-8";
    
    /**
     * 
     * @param HttpClient $httpClient
     */
    public function __construct($httpClient=null) {
        if($httpClient==null){
            $this->httpClient = new DefaultHttpClient();
        }
		else{
			$this->httpClient = $httpClient;
		}
    }
    
    /**
     * 
     * @param string $url
     * @param array $additionalHeaders
     * @return HttpResponse 
     * @throws RuntimeException
     */
    public function get($url, $additionalHeaders=array()){
        $response = $this->request($url, HttpRequest::HTTP_GET, null, $additionalHeaders);
        return $response;
    }    
    
    /**
     * 
     * @param string $url
     * @param string|array $data
     * @param array $additionalHeaders
     * @return HttpResponse 
     * @throws RuntimeException
     */
    public function post($url, $data=null, $additionalHeaders=array()){
        $response = $this->request($url, HttpRequest::HTTP_POST, $data, $additionalHeaders);
        return $response;
    }
    
    /**
     * 
     * @param string $url
     * @param string $method
     * @param string|array $data
     * @param string $additionalHeaders
     * @return HttpResponse 
     * @throws RuntimeException
     */
    private function request($url, $method, $data=null, $additionalHeaders=array()){
        $request = $this->createRequest($url, $method, $this->serializeRequestBody($data), $additionalHeaders);
        try{
            $response = $this->httpClient->makeRequest($request);  
        }catch(Exception $ex){            
            throw new RuntimeException($ex);
        }
        return $response;
    }
    
    /**    
     * 
     * @param string $data
     * return string
     */
    private function serializeRequestBody($data){
        $serializedData = null;        
        if($data!= null && is_array($data) ){
            $serializedData = http_build_query($data);
        }elseif ($data!= null && is_string($data)) {
            $serializedData = $data;
        }
        return $serializedData;
        
    }
    
    /**
     * 
     * @param string $url
     * @param string $method
     * @param string|array $data
     * @param array $additionalHeaders
     * @return HttpRequest
     */
    private function createRequest($url, $method, $data=null, $additionalHeaders=array()){
        $httpRequest = new HttpRequest();
        $httpRequest->setUrl(new URL($url));
        $httpRequest->setMethod($method);        
        if(is_array($additionalHeaders) && count($additionalHeaders) > 0){
            foreach($additionalHeaders as $headerName=>$headerValue){
                $httpRequest->addHeader(new HttpHeader($headerName, $headerValue));
            }            
        }
        if(!$httpRequest->hasHeader('Content-Type')){
            $httpRequest->addHeader(new HttpHeader('Content-Type', self::DEFAULT_CONTENT_TYPE));
        }
        $httpRequest->setBody($data);
        return $httpRequest;
        
    }
            
    
    
    
}
