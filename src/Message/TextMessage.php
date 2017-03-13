<?php 
namespace Meteorlxy\LaravelWechat\Message;

class TextMessage extends Message{

	protected $msgType = 'text';

	protected $content;
}