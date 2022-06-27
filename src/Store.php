<?php

namespace Csnntrt\ValorantApi;

class Store
{
    public function show($username,$password)
    {
        $Auth = new AuthController($username,$password);
        $store = new StoreController();
        $login_tokens = $Auth->Login();
        $daily = $store->show($login_tokens['puuid'], $login_tokens['token'],$login_tokens['ent_token']);
        return $daily;
    }
}