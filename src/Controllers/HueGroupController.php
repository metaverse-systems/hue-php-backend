<?php

namespace MetaverseSystems\HuePHPBackend\Controllers;

use MetaverseSystems\HuePHPBackend\Models\HueGroup;
use MetaverseSystems\HuePHPBackend\Models\HueBridge;
use MetaverseSystems\HuePHPBackend\Models\HueLight;
use MetaverseSystems\HuePHPBackend\Events\HueChangeState;
use Illuminate\Http\Request;

class HueGroupController extends \App\Http\Controllers\Controller
{
    private function setState($bridge, $group, $state)
    {
        $url = "http://".$bridge->ipv4."/api/".$bridge->username."/groups/".$group."/action";

        $ch = \curl_init($url);
        $header = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $state);
        $returned = curl_exec($ch);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HueBridge $bridge)
    {
        $url = "http://".$bridge->ipv4."/api/".$bridge->username."/groups";
        $groups = json_decode(file_get_contents($url));
        foreach($groups as $id=>$group)
        {   
            $g = HueGroup::where('bridge_id', $bridge->id)->where('group_id', $id)->first();
            if(!$g) $g = new HueGroup;
            $g->id = (string) \Str::uuid();
            $g->bridge_id = $bridge->id;
            $g->group_id = $id;
            $g->on = $group->action->on;
            $g->brightness = $group->action->bri;
            $g->type = $group->type;
            $g->class = $group->class;
            $g->name = $group->name;
            $g->save();

            foreach($group->lights as $light)
            {
                $l = HueLight::where('bridge_id', $bridge->id)->where('light_id', $light)->first();
                if(!$l) continue;
                $l->group_id = $id;
                $l->save();
            }
        }

        $groups = HueGroup::where('bridge_id', $bridge->id)->orderBy('name')->get();
        return $groups;
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
     * @param  \App\HueGroup  $hueGroup
     * @return \Illuminate\Http\Response
     */
    public function show(HueGroup $hueGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HueGroup  $hueGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(HueGroup $hueGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HueGroup  $hueGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HueBridge $bridge, $group)
    {
print_r($request->all());
        $state = new \stdClass;
        $on = $request->input('on');

        $bri = $request->input('bri');
        if($bri) $state->bri = (int)$bri;

        $change = [
            "group_id"=>$group
        ];

        if($on) 
        {
            $state->on = ($on == 1) ? true : false;
            $change["on"] = ($on == 1) ? 1 : 0;
        }

        if($bri) $change["brightness"] = $bri;

        broadcast(new HueChangeState(array($change)));

        $this->setState($bridge, $group, json_encode($state));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HueGroup  $hueGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(HueGroup $hueGroup)
    {
        //
    }
}
