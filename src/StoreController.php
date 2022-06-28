<?php
namespace Csnntrt\ValorantApi;
require 'vendor/autoload.php';

class StoreController extends InitClass
{
    public function show($puuid,$token,$ent_token)
    {
        $url = "https://pd.ap.a.pvp.net/store/v2/storefront/" .$puuid;
        $result = json_decode(self::getStore($url,$token,$ent_token),true);
        $skinids = $result['SkinsPanelLayout']['SingleItemOffers'];
        $SkinInfo = new SkinInfo();
        $skininfo = [];
        foreach($skinids as $skinid){
            $skininfo[] = $SkinInfo->grab($skinid);
        }
        return $skininfo;

    }
}