<?php
namespace Csnntrt\ValorantApi;
require 'vendor/autoload.php';
use Csnntrt\ValorantApi\AuthController;

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
        return $this->run($url,$method,$data);
    }

    public function Token()
    {
        self::Cookies();
        $result = json_decode(self::Auth($this->user,$this->pass),true);
        parse_str(parse_url($result["response"]["parameters"]["uri"])[$result["response"]["mode"]], $result);
        $token = $result['token_type'].' '.$result['access_token'];
        return $token;
        //
        //$result[access_token];
        //$result['token_type'];
    }

    public function EntitleToken()
    {
        $token = self::Token();
        $url = 'https://entitlements.auth.riotgames.com/api/token/v1';
        $result = json_decode($this->getEnt($url,$token),true);
        return $result['entitlements_token'];
    }

    function __destruct() {
        $this->run('https://auth.riotgames.com/logout?client_id=prod-xsso-playvalorant&post_logout_redirect_uri=https%3A%2F%2Fxsso.playvalorant.com%2Flogout-callback&state=55d0c9cfe3ac4adf8a26d89b1b','GET','');
    }
}