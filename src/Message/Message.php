<?php 
namespace Meteorlxy\LaravelWechat\Message;

use Illuminate\Support\Collection;
use Meteorlxy\LaravelWechat\Support\ExSimpleXMLElement;
use Meteorlxy\LaravelWechat\Exceptions\Message\WechatMessageException;
use Meteorlxy\LaravelWechat\Contracts\Message\Message as MessageContract;

class Message extends Collection implements MessageContract {

	/**
     * Results array of items from Collection or Arrayable or ExSimpleXMLElement.
     *
     * @param  mixed  $items
     * @return array
     */
	protected function getArrayableItems($items) {
		if ($items instanceof ExSimpleXMLElement) {
			return json_decode(json_encode($items), true);
		}
		return parent::getArrayableItems($items);
	}

	/**
	 * Make a new Message Object
	 *
	 * @param mixed $items
	 * @return static
	 */
	public static function make($items = []) {
		$items['CreateTime'] = time();
		if (!isset($items['MsgType'])) {
			$items['MsgType'] = 'text';
		}
		return new static($items);
	}

	/**
	 * Transfer the Message object into XML
	 *
	 * @return string
	 */
	public function toXML() {
		$xml = new ExSimpleXMLElement('<xml></xml>');
		self::putArrayIntoSimpleXML($this->items, $xml);
		return $xml->asXML();
	}

	/**
	 * Put array into ExSimpleXMLElement
	 *
	 * @param array $array
	 * @param \Meteorlxy\LaravelWechat\Support\ExSimpleXMLElement $simplexml
	 * @return void
	 */
	protected static function putArrayIntoSimpleXML(array $array, ExSimpleXMLElement $simplexml) {
		foreach ($array as $key => $val) {
			if (is_array($val)) {
				self::putArrayIntoSimpleXML($val, $simplexml->addChild($key));
			} elseif (is_numeric($val)){
				$simplexml->addChild($key, $val);
			} else {
				$simplexml->addCDATAChild($key, $val);
			}
		}
	}

	/**
	 * Check if this Message is in valid format
	 *
	 * @return bool
	 */
	public function isValid() {
		if (!isset($this->items['ToUserName']) || !isset($this->items['FromUserName']) ||
			!isset($this->items['MsgType']) || !isset($this->items['CreateTime'])) {
			return false;
		}
		return true;
	}
}