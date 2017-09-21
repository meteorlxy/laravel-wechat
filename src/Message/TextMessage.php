<?php 
namespace Meteorlxy\LaravelWechat\Message;

class TextMessage extends Message{

	protected $MsgType = 'text';

	protected $Content;
}