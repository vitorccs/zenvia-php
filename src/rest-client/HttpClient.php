<?php

interface HttpClient {
    /**
     * 
     * @param HttpRequest $request
     * @param int $timeout
     * @return HttpResponse 
     */
    public function makeRequest($request, $timeout=null);
}
