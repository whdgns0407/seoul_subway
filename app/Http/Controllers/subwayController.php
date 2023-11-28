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
            try {
                Station::create([
                    'station_name' => $row[2],
                    'line_id' => $row[0], // CSV 파일의 첫 번째 열
                    'statn_id' => $row[1], // CSV 파일의 두 번째 열
                ]);
            } catch (\Exception $e) {
                dd($e->getMessage()); // 에러 메시지 출력
            }
        }

        return response()->json(['message' => 'CSV 데이터가 성공적으로 저장되었습니다.']);
    }

    public function index()
    {
        $linecodes_sql = Linecode::get();
        $station_sqls = Station::get();

        /*
        $staions_1 = Station::where('line_id', 1001);
        $staions_2 = Station::where('line_id', 1002);
        $staions_3 = Station::where('line_id', 1003);
        $staions_4 = Station::where('line_id', 1004);
        $staions_5 = Station::where('line_id', 1005);
        $staions_6 = Station::where('line_id', 1006);
        $staions_7 = Station::where('line_id', 1007);
        $staions_8 = Station::where('line_id', 1008);
        $staions_9 = Station::where('line_id', 1009);
        $staions_gjl = Station::where('line_id', 1063);
        $staions_arex = Station::where('line_id', 1063);
        $staions_suin = Station::where('line_id', 1075);
        $staions_sinbun = Station::where('line_id', 1077);
        $staions_sinbun = Station::where('line_id', 1077);
        $staions_gyeonggang = Station::where('line_id', 1081);
        $staions_ui = Station::where('line_id', 1092);
        $staions_seohae = Station::where('line_id', 1093);
        */


        return view('welcome', ['linecodes_sql' => $linecodes_sql, 'station_sqls' => $station_sqls]);
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
