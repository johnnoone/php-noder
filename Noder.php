<?php

class Noder extends SimpleXMLElement {
    static $escape = array(
        '&#38;' => '&amp;', 
        '&amp;' => '&amp;', 
        '&' => '&amp;'
    );
    
    /**
     * Overwrites SimpleXMLElement::addChild by escaping string
     *
     * @param mixed $name 
     * @param string|null $value 
     * @param string|null $namespace 
     * @return Noder new node
     */
    public function addChild($name, $value=null, $namespace=null) {
        if (is_string($value)) {
            $value = strtr($value, self::$escape);
        }
        elseif (is_object($value) && method_exists($value, '__toString')) {
            if ($value instanceof SimpleXMLElement) {
                // pass
            }
            else {
                // cast
                $value = strtr((string) $value, self::$escape);
            }
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
    
    /**
     * Returns parent node.
     *
     * @return Noder
     */
    public function parent() {
        return $this->first('parent::*');
    }
    
    /**
     * Return the first matched node
     *
     * @param string $query 
     * @return Noder|null
     */
    public function first($query) {
        return current($this->xpath($query));
    }
}

function noder_load_file($filepath) {
    return new Noder($filepath, null, true);
}

function noder_load_string($filepath) {
    return new Noder($filepath, null, false);
}

function noder_import_dom($node) {
    return simplexml_import_dom($node, 'Noder');
}
