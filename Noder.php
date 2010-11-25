<?php

class Noder extends SimpleXMLElement {
    static $escape = array(
        '&#38;' => '&amp;', 
        '&amp;' => '&amp;', 
        '&' => '&amp;'
    );
    
    public function addChild($name, $value=null, $namespace=null) {
        if (is_string($value)) {
            $value = strtr($value, self::$escape);
        }
        elseif (is_object($value) && method_exists($value, '__toString')) {
            $value = strtr((string) $value, self::$escape);
        }
        $node = parent::addChild($name, $value, $namespace);
        return $node;
    }
    
    public function addTextNode($text) {
        $node = dom_import_simplexml($this); 
        $node->appendChild(new DOMText($text));
        return $this;
    }
    
    public function importNode(Noder $node) {
        $tbimported = dom_import_simplexml($node);
        
        $me = dom_import_simplexml($this);
        $imported = $me->ownerDocument->importNode($tbimported, true);
        $me->appendChild($imported);
        
        return $this;
    }
    
    public function importString($string) {
        return $this->importNode(new Noder($string));
    }
    
    public function __toString() {
        return $this->asXml();
    }
}

function noder_load_file($filepath) {
    return new Noder($filepath, null, true);
}

function noder_load_string($filepath) {
    return new Noder($filepath, null, false);
}
