<?php

namespace App\Providers;
use App\Models\Setting;
use App\Models\Subassociation;
use App\Models\Users;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }


    public function boot()
    {
        $settings=Setting::get();
        foreach($settings as $k=>$v){
            $setting[$v->slug]=$v->value;
        }

        $filter['association']=Subassociation::where('status',1)->get();
        foreach($filter['association'] as $k=>$as) {
            $association[$as->id]=$as->name;
        }
        
        View::share(['setting'=>$setting,'allassociation'=>$association]);
    }
}
