<?php 
namespace Meteorlxy\LaravelWechat\Message;

use SimpleXMLElement;
use Illuminate\Support\Collection;
use Meteorlxy\LaravelWechat\Contracts\Message\Message as MessageContract;

class Message extends Collection implements MessageContract {

	protected function getArrayableItems($items) {
			if ($items instanceof SimpleXMLElement) {
					return json_decode(json_encode($items), true);
			}
			return parent::getArrayableItems($items);
	}

	public function toXML() {
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml></xml>');
			self::putArrayIntoSimpleXML($this->items, $xml);
			// $xml = $xml->asXML();
			// $xml = preg_replace('/&lt;/', '<', $xml);
			// $xml = preg_replace('/&gt;/', '>', $xml);
			// return $xml;
			return $xml->asXML();
	}

	protected static function putArrayIntoSimpleXML(array $array, SimpleXMLElement $simplexml) {
			foreach ($array as $key => $val) {
					if (is_array($val)) {
							self::putArrayIntoSimpleXML($val, $simplexml->addChild($key));
					} elseif (is_numeric($val)){
							$simplexml->addChild($key, $val);
					} else {
							$child = $simplexml->addChild($key);
							$dom = dom_import_simplexml($child);
							$cdata = $dom->ownerDocument->createCDATASection($val);
							$dom->appendChild($cdata);
							// $simplexml->addChild($key, '<![CDATA['.$val.']]>');
					}
			}
	}

	public static function make($items = []) {
			$items['CreateTime'] = time();
			if (!isset($items['MsgType'])) {
					$items['MsgType'] = 'text';
			}
			return new static($items);
	}

	public static function fromXML(string $xml) {
			$simplexml = simplexml_load_string($xml, 'SimpleXMLElement',  LIBXML_NOCDATA | LIBXML_NOBLANKS);
			if (false === $simplexml) {
					return false;
			}
			return new static($simplexml);
	}
	
	public function __get($key) {
			return $this->get($key);
	}
	
	public function __set($key, $value) {
			return $this->put($key, $value);
	}
}