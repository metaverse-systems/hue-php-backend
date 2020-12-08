<?php

namespace MetaverseSystems\HuePHPBackend\Controllers;

use MetaverseSystems\HuePHPBackend\Models\HueBridge;
use Illuminate\Http\Request;

require 'phpssdp.php';

class HueBridgeController extends \App\Http\Controllers\Controller
{
    private $bridge_models = [
      "BSB002"
    ];

    public function scan()
    {
        $devices = array();
        $bridges = array();

        $scanner = new \LqdT\phpSSDP();
        $results = $scanner::getAllDevices();

        foreach($results as $device)
        {
            $devices[$device['IP']] = $device['LOCATION'];
        }

        foreach($devices as $ip=>$url)
        {
            $description = new \SimpleXMLElement(file_get_contents($url));
            $device = $description->device;
            if(!in_array($device->modelNumber, $this->bridge_models)) continue;
            array_push($bridges, array("ip"=>$ip, "model"=>$device->modelName->__toString()));
        }
        return $bridges;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bridges = HueBridge::get();
        return $bridges;
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
        $bridge = new HueBridge;
        $bridge->local_node = 0;
        $bridge->user_id = 0;
        $bridge->id = (string)\Str::uuid();
        $bridge->model = $request->input('model');
        $bridge->ipv4 = $request->input('ip');
        $bridge->username = $request->input('username');
        $bridge->save();
        return response()->json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HueBridge  $hueBridge
     * @return \Illuminate\Http\Response
     */
    public function show(HueBridge $hueBridge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HueBridge  $hueBridge
     * @return \Illuminate\Http\Response
     */
    public function edit(HueBridge $hueBridge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HueBridge  $hueBridge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HueBridge $hueBridge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HueBridge  $hueBridge
     * @return \Illuminate\Http\Response
     */
    public function destroy(HueBridge $hueBridge)
    {
        //
    }
}
