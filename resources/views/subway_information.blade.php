<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%">
        <thead>
            <tr>
                <th scope="col" colspan="3" style="text-align: center">
                    {{ $station_name }}역 도착정보
                </th>
                <th scope="col" colspan="1" style="text-align: center" id="current_time">08:56</th>
            </tr>
        </thead>
    </table>

    @foreach ($station_sqls as $station_sql)
        <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%"
            id="up_{{ $station_sql->line_id }}">
            <thead>
                <tr>
                    <th scope="col" colspan="4" style="text-align: center">
                        {{ $station_sql->line_name }}(상행)
                    </th>

                </tr>
                <tr>
                    <th scope="col" style="text-align:center; width:30%;">행선지</th>
                    <th scope="col" style="text-align:center; width:15%;">도착예정</th>
                    <th scope="col" style="text-align:center; width:30%;" >메시지1</th>
                    <th scope="col" style="text-align:center; width:25%;" >현재위치</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


        <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%"
            id="down_{{ $station_sql->line_id }}">
            <thead>
                <tr>
                    <th scope="col" colspan="4" style="text-align: center">
                        {{ $station_sql->line_name }}(하행)
                    </th>

                </tr>
                <tr>
                    <th scope="col" style="text-align:center; width:30%;">행선지</th>
                    <th scope="col" style="text-align:center; width:15%;">도착예정</th>
                    <th scope="col" style="text-align:center; width:30%;">메시지1</th>
                    <th scope="col" style="text-align:center; width:25%;">현재위치</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    @endforeach

    <script>
        var url = "/subway_ajax/{{ $station_name }}";


        function subway_ajax() {
            $.ajax({
                url: url, // 서버의 JSON 데이터 파일 경로 또는 API 엔드포인트
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    @foreach ($station_sqls as $station_sql)
                        $('#up_{{ $station_sql->line_id }} tbody').empty();
                        $('#down_{{ $station_sql->line_id }} tbody').empty();
                    @endforeach

                    currentdate = new Date();

                    for (i = 0; i < data.realtimeArrivalList.length; i++) {
                        if (data.realtimeArrivalList[i].updnLine == "상행") {
                            direction = "up";
                        } else {
                            direction = "down";
                        }



                        barvlDt = parseInt(data.realtimeArrivalList[i].barvlDt);

                        if (barvlDt != 0) {
                            // 최신 지하철 시간
                            var givenDate = new Date(data.realtimeArrivalList[i].recptnDt);
                            // 400초를 더함
                            givenDate.setSeconds(givenDate.getSeconds() + barvlDt);                            

                            remain_seconds = Math.floor((givenDate - currentdate) / 1000);
                            if (remain_seconds <= 20) {
                                barvl_message = "진입중";
                            } else if(remain_seconds <= 60) {
                                barvl_message = "곧 도착";
                            } else {
                                minutes = Math.floor(remain_seconds / 60);
                                seconds = remain_seconds % 60;
                                barvl_message = minutes + "분 " + seconds + "초";
                            }


                        } else {
                            barvl_message = "미제공";
                        }



                        var row = "<tr>" +
                            "<td style='text-align: center;'>" + data.realtimeArrivalList[i].trainLineNm +
                            "</td>" +
                            "<td style='text-align: center;'>" + barvl_message + "</td>" +
                            "<td style='text-align: center;'>" + data.realtimeArrivalList[i].arvlMsg2 +
                            "</td>" +
                            "<td style='text-align: center;'>" + data.realtimeArrivalList[i].arvlMsg3 + "</td>";



                        $("#" + direction + "_" + data.realtimeArrivalList[i].subwayId + " tbody").append(row);
                    }
                }
            });
        }

        subway_ajax();

        var intervalId = setInterval(subway_ajax, 10000);
    </script>
</body>

</html>
