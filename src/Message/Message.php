<?php 
namespace Meteorlxy\LaravelWechat\Message;

use SimpleXMLElement;
use Illuminate\Support\Collection;
use Meteorlxy\LaravelWechat\Contracts\Message\Message as MessageContract;

class Message extends Collection implements MessageContract {

		/**
     * Results array of items from Collection or Arrayable.
     *
     * @param  mixed  $items
     * @return array
     */
		protected function getArrayableItems($items) {
				if ($items instanceof SimpleXMLElement) {
						return json_decode(json_encode($items), true);
				}
				return parent::getArrayableItems($items);
		}
		
		/**
		 * Get a message instance from XML string
		 * 
		 * @param  string  $xml
		 * @return \Meteorlxy\LaravelWechat\Message\Message
		 */
		public static function fromXML(string $xml) {
				$simplexml = simplexml_load_string($xml, 'SimpleXMLElement',  LIBXML_NOCDATA | LIBXML_NOBLANKS);
				if (false === $simplexml) {
						return false;
				}
				return new static($simplexml);
		}
		
		/**
		 * Make a message instance from array
		 * 
		 * @param  array  $items
		 * @return \Meteorlxy\LaravelWechat\Message\Message
		 */
		public static function make($items = []) {
				
				if (!isset($items['MsgType'])) {
						$items['MsgType'] = 'text';
				}
				
				if (!isset($items['CreateTime'])) {
						$items['CreateTime'] = time();
				}
				
				return new static($items);
		}
		
		/**
		 * Get the XML string of this message instance
		 * 
		 * @return string
		 */
		public function toXML() {
				$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml></xml>');
				self::putArrayIntoSimpleXML($this->items, $xml);
				return $xml->asXML();
		}
		
		/**
		 * Put an array into a SimpleXMLElement instance
		 * 
		 * @param  array  $array
		 * @param  \SimpleXMLElement  $simplexml
		 * @return void
		 */
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
						}
				}
		}
		
		/**
		 * Get item of this message
		 * 
		 * @param  string  $key
		 * @return mixed
		 */
		public function __get($key) {
				return $this->get($key);
		}
		
		/**
		 * Set item of this message
		 * 
		 * @param  string  $key
		 * @param  mixed   $value
		 * @return mixed
		 */
		
		public function __set($key, $value) {
				return $this->put($key, $value);
		}
}