<?php
namespace Meteorlxy\LaravelWechat\Contracts\Foundation;

interface AccessToken {

    /**
     * Get the access token
     *
     * @return string
     */
    public function get();

    /**
     * Update the access token
     *
     * @param  bool     $isForced
     * @return string
     */
    public function update($isForced = false);

}