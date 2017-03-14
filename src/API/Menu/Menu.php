<?php
namespace Meteorlxy\LaravelWechat\API\Menu;

use Meteorlxy\LaravelWechat\API\WechatAPI;

class Menu extends WechatAPI {

    /**
     * The urls of Menu API
     *
     * @var array
     */
    protected $url = [
        'create'                 => 'cgi-bin/menu/create',
        'get'                    => 'cgi-bin/menu/get',
        'delete'                 => 'cgi-bin/menu/delete',
        'addConditional'         => 'cgi-bin/menu/addconditional',
        'deleteConditional'      => 'cgi-bin/menu/delconditional',
        'tryMatch'               => 'cgi-bin/menu/trymatch',
        'getCurrentSelfMenuInfo' => 'cgi-bin/get_current_self_menu_info'
    ];

    /**
     * Create | 自定义菜单创建接口
     *
     * @param array $button
     * @return \Illuminate\Support\Collection
     *
     * @see http://mp.weixin.qq.com/wiki/10/0234e39a2025342c17a7d23595c6b40a.html
     */
    public function create(array $button) {
        return $this->request(
            'POST', 
            $this->url[__FUNCTION__], 
            compact('button')
        );
    }

    /**
     * Get | 自定义菜单查询接口
     *
     * @return \Illuminate\Support\Collection
     *
     * @see http://mp.weixin.qq.com/wiki/5/f287d1a5b78a35a8884326312ac3e4ed.html
     */
    public function get() {
        return $this->request(
            'GET', 
            $this->url[__FUNCTION__]
        );
    }

    /**
     * Delete | 自定义菜单删除接口
     *
     * @return \Illuminate\Support\Collection
     *
     * @see http://mp.weixin.qq.com/wiki/3/de21624f2d0d3dafde085dafaa226743.html
     */
    public function delete() {
        return $this->request(
            'GET', 
            $this->url[__FUNCTION__]
        );
    }

    /**
     * Add Conditional | 创建个性化菜单 - 个性化菜单接口
     *
     * @param array $button
     * @param array $matchrule
     * @return \Illuminate\Support\Collection
     *
     * @see http://mp.weixin.qq.com/wiki/0/c48ccd12b69ae023159b4bfaa7c39c20.html
     */
    public function addConditional(array $button, array $matchrule) {
        return $this->request(
            'POST', 
            $this->url[__FUNCTION__],
            compact('button', 'matchrule')
        );
    }

    /**
     * Delete Conditional | 删除个性化菜单 - 个性化菜单接口
     *
     * @param string $menuid
     * @return \Illuminate\Support\Collection
     *
     * @see http://mp.weixin.qq.com/wiki/0/c48ccd12b69ae023159b4bfaa7c39c20.html
     */
    public function deleteConditional($menuid) {
        return $this->request(
            'POST', 
            $this->url[__FUNCTION__],
            compact('menuid')
        );
    }

    /**
     * Try Match | 测试个性化菜单匹配结果 - 个性化菜单接口
     *
     * @param string $user_id
     * @return \Illuminate\Support\Collection
     *
     * @see http://mp.weixin.qq.com/wiki/0/c48ccd12b69ae023159b4bfaa7c39c20.html
     */
    public function tryMatch($user_id) {
        return $this->request(
            'POST', 
            $this->url[__FUNCTION__],
            compact('user_id')
        );
    }

    /**
     * Get Current Self Menu Info | 获取自定义菜单配置接口
     *
     * @return \Illuminate\Support\Collection
     *
     * @see http://mp.weixin.qq.com/wiki/14/293d0cb8de95e916d1216a33fcb81fd6.html
     */
    public function getCurrentSelfMenuInfo() {
        return $this->request(
            'GET', 
            $this->url[__FUNCTION__]
        );
    }

}