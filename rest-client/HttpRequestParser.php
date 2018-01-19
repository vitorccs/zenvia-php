<?php

class HttpRequestParser {
  

    /**
     * 
     * @param HttpRequest $request
     * @return type
     */
    public function parse($request){        
        $postData= $request->getBody();        
        $url = $request->getMethod() . " " . $request->getURL()->getUri().'?'.$request->getURL()->getQueryString();
        $output  =  $url . " HTTP/1.1\r\n";
        $output .= "Host: " . $request->getURL()->getHost() . "\r\n";
        $output .= "User-Agent: Zenvia PHP API\r\n";
        $output .= $this->parseCustomHeaders($request);
        $output .= "Content-Length: " . strlen($postData) . "\r\n";
        $output .= "Connection: close\r\n\r\n";
        $output .= $postData;
        return $output;        
    }
    
    /**
     * @param HttpRequest $request
     * @return string 
     */
    private function parseCustomHeaders($request){
        $headers = $request->getHeaders();
        $output = "";
        foreach($headers as $header){
            $output .= sprintf("%s:%s \r\n", $header->getName(), $header->getValue());            
        } 
        $output .= "User-Agent: Zenvia PHP API\r\n";
        return $output;
    }
    
    
}
