<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Station;
use App\Models\Linecode;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class subwayController extends Controller
{

    public function csv_upload()
    {

        $filePath = public_path('dd.csv');

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'CSV 파일을 찾을 수 없습니다.']);
        }

        $csvData = array_map('str_getcsv', file($filePath));


        // 헤더 제외한 데이터를 반복하면서 저장
        foreach (array_slice($csvData, 1) as $row) {
            Station::create([
                'line_id' => $row[0], // CSV 파일의 첫 번째 열
                'station_name' => $row[2], // CSV 파일의 두 번째 열
                // 추가 필드가 있다면 계속해서 추가
            ]);
        }

        return response()->json(['message' => 'CSV 데이터가 성공적으로 저장되었습니다.']);
    }

    public function index(){
        return 00;
    }


    public function subway(Request $request, $station_name)
    {
        $station_sqls = Station::join('linecodes', 'stations.line_id', '=', 'linecodes.line_code')
            ->where('stations.station_name', $station_name)->get();

        
        if ($station_sqls->isEmpty()) {
            abort(404);
        }

        return view('subway_information',  ['station_sqls' => $station_sqls, 'station_name' => $station_name,]);
    }




    public function subway_ajax(Request $request, $station_name)
    {
        $subway_api_key = env('subway_api_key');


        $url = "http://swopenapi.seoul.go.kr/api/subway/" . $subway_api_key . "/json/realtimeStationArrival/0/30/" . $station_name;

        $subway_json = Http::withHeaders([
            'Content-Type' => 'application/json',
            // 필요한 헤더 값 설정
        ])->get($url);

        return $subway_json;
    }
}
