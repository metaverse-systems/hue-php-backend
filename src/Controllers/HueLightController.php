<?php

namespace MetaverseSystems\HuePHPBackend\Controllers;

use MetaverseSystems\HuePHPBackend\Models\HueLight;
use MetaverseSystems\HuePHPBackend\Models\HueBridge;
use Illuminate\Http\Request;

class HueLightController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HueBridge $bridge)
    {
        print_r($bridge->toArray());
        $url = "http://".$bridge->ipv4."/api/".$bridge->username."/lights";
        $lights = json_decode(file_get_contents($url));
        foreach($lights as $id=>$light)
        {
            $l = HueLight::where('bridge_id', $bridge->id)->where('light_id', $id)->first();
            if(!$l) $l = new HueLight;
            $l->id = (string) \Str::uuid();
            $l->bridge_id = $bridge->id;
            $l->light_id = $id;
            $l->on = $light->state->on;
            $l->brightness = $light->state->bri;
            $l->reachable = $light->state->reachable;
            $l->name = $light->name;
            $l->productname = $light->productname;
            $l->save();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HueLight  $hueLight
     * @return \Illuminate\Http\Response
     */
    public function show(HueLight $hueLight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HueLight  $hueLight
     * @return \Illuminate\Http\Response
     */
    public function edit(HueLight $hueLight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HueLight  $hueLight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HueLight $hueLight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HueLight  $hueLight
     * @return \Illuminate\Http\Response
     */
    public function destroy(HueLight $hueLight)
    {
        //
    }
}
