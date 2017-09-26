<?php
namespace Meteorlxy\LaravelWechat\API\Template;

use Meteorlxy\LaravelWechat\API\WechatAPI;

class Template extends WechatAPI {
    protected $url = [
        'setIndustry'       => 'cgi-bin/template/api_set_industry',
        'getIndustry'       => 'cgi-bin/template/get_industry',
        'addTemplate'       => 'cgi-bin/template/api_add_template',
        'getTemplates'      => 'cgi-bin/template/get_all_private_template',
        'deleteTemplate'    => 'cgi-bin/template/del_private_template',
        'send'              => 'cgi-bin/message/template/send',
    ];
    
    public function setIndustry($id1, $id2 = '') {
        return $this->request(
            'POST',
            $this->url[__FUNCTION__],
            [
                'industry_id1' => $id1,
                'industry_id2' => $id2,
            ]
        );
    }
    
    public function getIndustry() {
        return $this->request(
            'GET',
            $this->url[__FUNCTION__]
        );
    }
    
    public function addTemplate($id) {
        return $this->request(
            'POST',
            $this->url[__FUNCTION__], 
            [
                'template_id_short' => $id
            ]
        );
    }
    
    public function getTemplates() {
        return $this->request(
            'GET',
            $this->url[__FUNCTION__]
        );
    }
    
    public function deleteTemplate($id) {
        return $this->request(
            'POST',
            $this->url[__FUNCTION__], 
            [
                'template_id' => $id
            ]
        );
    }
    
    public function send(array $template) {
        return $this->request(
            'POST',
            $this->url[__FUNCTION__], 
            $template
        );
    }

}