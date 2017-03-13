<?php 
namespace Meteorlxy\LaravelWechat\Contracts\Message;

interface Message {

	public function type();

	public function toXML();
}