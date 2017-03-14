<?php 
namespace Meteorlxy\LaravelWechat\Contracts\Message;

interface Message {

	/**
	 * Transfer the Message object into XML
	 *
	 * @return string
	 */
	public function toXML();
}