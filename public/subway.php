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
                    노량진
                </th>
                <th scope="col" colspan="1" style="text-align: center">08:56</th>
            </tr>
        </thead>
    </table>


    <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%" id="up_1001">
        <thead>
            <tr>
                <th scope="col" colspan="4" style="text-align: center">
                    1호선(상행)
                </th>

            </tr>
            <tr>
                <th scope="col" style="text-align:center">행선지</th>
                <th scope="col" style="text-align:center">도착예정</th>
                <th scope="col" style="text-align:center">메시지1</th>
                <th scope="col" style="text-align:center">현재위치</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


    <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%" id="down_1001">
        <thead>
            <tr>
                <th scope="col" colspan="4" style="text-align: center">
                    1호선(하행)
                </th>

            </tr>
            <tr>
                <th scope="col" style="text-align:center">행선지</th>
                <th scope="col" style="text-align:center">도착예정</th>
                <th scope="col" style="text-align:center">메시지1</th>
                <th scope="col" style="text-align:center">현재위치</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


    <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%" id="up_1009">
        <thead>
            <tr>
                <th scope="col" colspan="4" style="text-align: center">
                    9호선(상행)
                </th>

            </tr>
            <tr>
                <th scope="col" style="text-align:center">행선지</th>
                <th scope="col" style="text-align:center">도착예정</th>
                <th scope="col" style="text-align:center">메시지1</th>
                <th scope="col" style="text-align:center">현재위치</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%" id="down_1009">
        <thead>
            <tr>
                <th scope="col" colspan="4" style="text-align: center">
                    9호선(하행)
                </th>

            </tr>
            <tr>
                <th scope="col" style="text-align:center">행선지</th>
                <th scope="col" style="text-align:center">도착예정</th>
                <th scope="col" style="text-align:center">메시지1</th>
                <th scope="col" style="text-align:center">현재위치</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>



    <script>
        var url = "/subway_ajax/{{ $station_name }}";

        function subway_ajax() {
            $.ajax({
                url: url, // 서버의 JSON 데이터 파일 경로 또는 API 엔드포인트
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#up_1001 tbody').empty();
                    $('#down_1001 tbody').empty();
                    $('#up_1009 tbody').empty();
                    $('#down_1009 tbody').empty();


                    for (i = 0; i < data.realtimeArrivalList.length; i++) {
                        if (data.realtimeArrivalList[i].updnLine == "상행") {
                            direction = "up";
                        } else {
                            direction = "down";
                        }


                        
                        barvlDt = parseInt(data.realtimeArrivalList[i].barvlDt);
                        minutes = Math.floor(barvlDt/ 60);
                        seconds = barvlDt % 60;

                        console.log(barvlDt);


                        var row = "<tr>" +
                            "<td style='text-align: center;'>" + data.realtimeArrivalList[i].trainLineNm + "</td>" +
                            "<td style='text-align: center;'>" + minutes + "분 " + seconds + "초</td>" +
                            "<td style='text-align: center;'>" + data.realtimeArrivalList[i].arvlMsg2 + "</td>" +
                            "<td style='text-align: center;'>" + data.realtimeArrivalList[i].arvlMsg3 + "</td>";

          
                     
                        $("#" + direction + "_" + data.realtimeArrivalList[i].subwayId + " tbody").append(row);
                    }
                }
            });
        }

        subway_ajax();


        var intervalId = setInterval(subway_ajax, 5000);
    </script>
</body>

</html>