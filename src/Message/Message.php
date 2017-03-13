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
		$xml = new SimpleXMLElement('<xml></xml>');
		self::putArrayIntoSimpleXML($this->items, $xml);
		return $xml->asXML();
	}

	protected static function putArrayIntoSimpleXML(array $array, SimpleXMLElement $simplexml) {
		foreach ($array as $key => $val) {
			if (is_array($val)) {
				self::putArrayIntoSimpleXML($val, $simplexml->addChild($key));
			} elseif (is_numeric($val)){
				$simplexml->addChild($key, $val);
			} else {
				$simplexml->addChild($key, '<![CDATA['.$val.']]>');
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
}