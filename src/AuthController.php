<?php
namespace Csnntrt\ValorantApi;
require 'vendor/autoload.php';

class AuthController extends InitClass{
    private $user;
    private $pass;
    public function __construct($user,$pass)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->run('https://auth.riotgames.com/logout?client_id=prod-xsso-playvalorant&post_logout_redirect_uri=https%3A%2F%2Fxsso.playvalorant.com%2Flogout-callback&state=55d0c9cfe3ac4adf8a26d89b1b','GET','');
    }

    public function Cookies()
    {
        $url = 'https://auth.riotgames.com/api/v1/authorization';
        $method = 'POST';
        $data = '{"client_id":"play-valorant-web-prod","nonce":"1","redirect_uri":"https://playvalorant.com/opt_in","response_type":"token id_token"}';
        return $this->run($url,$method,$data);
    }

    public function Auth($user,$pass)
    {
        $url = 'https://auth.riotgames.com/api/v1/authorization';
        $method = 'PUT';
        $data = '{
      "type": "auth",
      "username": "'.$user.'",
      "password": "'.$pass.'",
      "remember": true,
      "language": "en_US"
  }';
        $result = json_decode($this->run($url,$method,$data),true);
        if($result["type"] == 'auth')
        {
            header("Location: index.php?error");
            exit();
        }
        return $result;
    }

    public function Token()
    {
        self::Cookies();
        $result = self::Auth($this->user,$this->pass);
        parse_str(parse_url($result["response"]["parameters"]["uri"])[$result["response"]["mode"]], $result);
        $token = $result['token_type'].' '.$result['access_token'];
        return $token;
        //
        //$result[access_token];
        //$result['token_type'];
    }

    public function EntitleToken($token)
    {
        $url = 'https://entitlements.auth.riotgames.com/api/token/v1';
        $result = json_decode($this->get($url,$token),true);
        return $result['entitlements_token'];
    }

    public function PUUID($token)
    {
        $url = "https://auth.riotgames.com/userinfo";
        $result = json_decode($this->get($url,$token),true);
        return $result['sub'];
    }

    public function Login()
    {
        $data = array();
        $data['token'] = self::Token();
        $data['ent_token'] = self::EntitleToken($data['token']);
        $data['puuid'] = self::PUUID($data['token']);
        return $data;
    }

    function __destruct() {
        $this->run('https://auth.riotgames.com/logout?client_id=prod-xsso-playvalorant&post_logout_redirect_uri=https%3A%2F%2Fxsso.playvalorant.com%2Flogout-callback&state=55d0c9cfe3ac4adf8a26d89b1b','GET','');
    }
}