<?php 
namespace Meteorlxy\LaravelWechat\Message;

abstract class Message {

	protected $toUserName;

	protected $fromUserName;

	protected $createTime;

	protected $msgType;

	protected $msgId;

	public function __construct(array $message) {
		foreach ($message as $key => $val) {
			if (property_exists($this, $key)) {
				$this->$key = $val;
			}
		}
	}

	public function type() {
		return $this->msgType;
	}

	public function toXML() {
		
	}

	
}