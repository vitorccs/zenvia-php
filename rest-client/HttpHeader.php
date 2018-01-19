<?php


class HttpHeader {
    
    /**     
     * @var string 
     */
    private $name;
    /**     
     * @var mixed 
     */
    private $value;
    
    public function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }    
    
    public function __toString() {
        return "[name=".$this->name.', value='.$this->value.']';
    }
   


}
