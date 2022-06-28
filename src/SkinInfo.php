<?php

namespace Csnntrt\ValorantApi;
require 'vendor/autoload.php';
class SkinInfo extends InitClass
{
    public function grab($skinid)
    {

        $url = "https://valorant-api.com/v1/weapons/skinlevels/".$skinid;
        $skininfo = json_decode(self::run($url,"GET",""),true);
        return $skininfo;
    }
}