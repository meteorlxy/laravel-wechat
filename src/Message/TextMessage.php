<?php 
namespace Meteorlxy\LaravelWechat\Message;

class TextMessage extends BaseMessage{

	protected $MsgType = 'text';

	protected $Content;
}