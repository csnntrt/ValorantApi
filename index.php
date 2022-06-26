<?php
require 'vendor/autoload.php';
use Csnntrt\ValorantApi\AuthController;
//use Csnntrt\ValorantApi\InitClass;
//$init = new InitClass('https://auth.riotgames.com/api/v1/authorization', 'POST', '{"client_id":"play-valorant-web-prod","nonce":"1","redirect_uri":"https://playvalorant.com/opt_in","response_type":"token id_token"}
//');
//$res = $init->run();
//echo $res;


$Auth = new AuthController('booster2231','Ferariekko123$');
//$authtoken = $Auth->Token();
$ent_token = $Auth->EntitleToken();
echo $ent_token;