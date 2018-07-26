<?php

/**
 * 微信授权相关接口
 * 
 */
class Auth {
    
    private $app_id = '';
    private $app_secret = '';
    /*
     * 识别域名，进行不同公众平台授权wx为艾里不理公众平台，poster为微至成
     */
    public function __construct()
    {
        $url= $_SERVER['HTTP_HOST'];
        if( $url == 'wx.issmart.com.cn' )
        {
            $this->app_id = 'wx4a57006e7243e6df';
            $this->app_secret = '24bf3035c8717d2be8461c9e24b5ad5f';
        }
        else if( $url == 'poster.issmart.com.cn' )
        {
            $this->app_id = 'wx996bd5d838d5d827';
            $this->app_secret = 'd3927177ebc315da18681dd9876ed073';
        }
    }
    /**
     * 获取微信授权链接
     * 
     * @param string $redirect_uri 跳转地址
     * @param string $type 授权参数 base静默授权 非base则是登录授权
     */
    public function get_authorize_url($redirect_url = '', $type = 'base')
    {
        $redirect_url = urlencode($redirect_url);
        if( $type == 'base' ){
            return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->app_id}&redirect_uri={$redirect_url}&response_type=code&scope=snsapi_base&state={STATE}#wechat_redirect";
        }
        else {
            return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->app_id}&redirect_uri={$redirect_url}&response_type=code&scope=snsapi_userinfo&state={STATE}#wechat_redirect";

        }
    }

    
    /**
     * 获取授权token
     * 
     * @param string $code 通过get_authorize_url获取到的code
     */
    public function get_access_token($code = '')
    {
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_secret}&code={$code}&grant_type=authorization_code";
        $token_data = $this->http($token_url);
        
        if($token_data[0] == 200)
        {
            return json_decode($token_data[1], TRUE);
        }
        
        return FALSE;
    }
    
    /**
     * 获取授权后的微信用户信息
     * 
     * @param string $access_token
     * @param string $open_id
     */
    public function get_user_info($access_token = '', $open_id = '')
    {
        if($access_token && $open_id)
        {
            $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
            $info_data = $this->http($info_url);
            
            if($info_data[0] == 200)
            {
                return json_decode($info_data[1], TRUE);
            }
        }
        
        return FALSE;
    }
    
    public function http($url, $method, $postfields = null, $headers = array(), $debug = false)
    {
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
 
        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    $this->postdata = $postfields;
                }
                break;
        }
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
 
        $response = curl_exec($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
 
        if ($debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
 
            echo '=====info=====' . "\r\n";
            print_r(curl_getinfo($ci));
 
            echo '=====response=====' . "\r\n";
            print_r($response);
        }
        curl_close($ci);
        return array($http_code, $response);
    }
}
