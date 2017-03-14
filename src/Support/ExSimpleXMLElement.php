<?php
namespace Meteorlxy\LaravelWechat\Support;

use SimpleXMLElement;

class ExSimpleXMLElement extends SimpleXMLElement {

    /**
     *  Add a CDATA child into this element
     *
     * @param string    $key
     * @param string    $cdata
     * @return ExSimpleXMLElement
     */
    public function addCDATAChild($key, $cdata) {
        $child = $this->addChild($key);
        $child->addCDATA($cdata);
        return $child;
    }

    /**
     *  Add CDATA section into this element
     *
     * @param string    $cdata
     * @return void
     */
    public function addCDATA($cdata) {
        $this_node= dom_import_simplexml($this);
        $this_owner = $this_node->ownerDocument;
        $this_node->appendChild($this_owner->createCDATASection($cdata)); 
    }
}