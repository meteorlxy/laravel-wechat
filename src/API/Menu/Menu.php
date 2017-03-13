<?php
namespace Meteorlxy\LaravelWechat\API\Menu;

use Meteorlxy\LaravelWechat\Foundation\WechatAPI;

class Menu extends WechatAPI {
    protected $url = [
        'create'                 => 'cgi-bin/menu/create',
        'get'                    => 'cgi-bin/menu/get',
        'delete'                 => 'cgi-bin/menu/delete',
        'addConditional'         => 'cgi-bin/menu/addconditional',
        'deleteConditional'      => 'cgi-bin/menu/delconditional',
        'tryMatch'               => 'cgi-bin/menu/trymatch',
        'getCurrentSelfMenuInfo' => 'cgi-bin/get_current_self_menu_info'
    ];

    public function create(array $button) {
        return $this->request(
            'POST', 
            $this->url[__FUNCTION__], 
            compact('button')
        );
    }

    public function get() {
        return $this->request(
            'GET', 
            $this->url[__FUNCTION__]
        );
    }

    public function delete() {
        return $this->request(
            'GET', 
            $this->url[__FUNCTION__]
        );
    }

    public function addConditional(array $button, array $matchrule) {
        return $this->request(
            'POST', 
            $this->url[__FUNCTION__],
            compact('button', 'matchrule')
        );
    }

    public function deleteConditional($menuid) {
        return $this->request(
            'POST', 
            $this->url[__FUNCTION__],
            compact('menuid')
        );
    }

    public function tryMatch($user_id) {
        return $this->request(
            'POST', 
            $this->url[__FUNCTION__],
            compact('user_id')
        );
    }

    public function getCurrentSelfMenuInfo() {
        return $this->request(
            'GET', 
            $this->url[__FUNCTION__]
        );
    }

}