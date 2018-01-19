<?php

 require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'util' . DIRECTORY_SEPARATOR . 'ApiClassLoader.php');

 $packages = array(
     dirname(__FILE__) . DIRECTORY_SEPARATOR .'util', 
     dirname(__FILE__) . DIRECTORY_SEPARATOR .'rest-client', 
     dirname(__FILE__) . DIRECTORY_SEPARATOR .'model'
  );
 
 ApiClassLoader::register($packages);

