<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6095871392041989"
        crossorigin="anonymous"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9ZYM97R27D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-9ZYM97R27D');
    </script>

    <title>{{ $station_name }}역 - 실시간 초단위 도착정보</title>

</head>

<body>
    <div style="display: flex; justify-content: center;">
        <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col" colspan="1" style="text-align: center; vertical-align:middle; width:15%; ">
                        <a href="{{ route('index') }}">홈 화면</a>
                    </th>
                    <th scope="col" colspan="3" style="text-align: center; vertical-align:middle; width:60%;">
                        {{ $station_name }}역 도착정보
                    </th>
                    <th scope="col" colspan="1" style="text-align: center; vertical-align:middle; width:25%;"
                        id="current_time"></th>
                </tr>
            </thead>
        </table>
    </div>

    @foreach ($station_sqls as $index => $station_sql)
        <div style="display: flex; justify-content: center;">
            <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%"
                id="up_{{ $station_sql->line_id }}">
                <thead>
                    <tr>
                        <th scope="col" colspan="4" style="text-align: center">
                            {{ $station_sql->line_name }}
                            @if ($station_sql->line_id != 1002)
                                (상행)
                            @else
                                (외선)
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" style="text-align:center; vertical-align:middle; width:30%;">행선지</th>
                        <th scope="col" style="text-align:center; vertical-align:middle; width:20%;">도착예정</th>
                        <th scope="col" style="text-align:center; vertical-align:middle; width:30%;">메시지</th>
                        <th scope="col" style="text-align:center; vertical-align:middle; width:20%;">현재위치</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: center;">
            <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%"
                id="down_{{ $station_sql->line_id }}">
                <thead>
                    <tr>
                        <th scope="col" colspan="4" style="text-align: center">
                            {{ $station_sql->line_name }}
                            @if ($station_sql->line_id != 1002)
                                (하행)
                            @else
                                (내선)
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" style="text-align:center; vertical-align:middle; width:30%;">행선지</th>
                        <th scope="col" style="text-align:center; vertical-align:middle; width:20%;">도착예정</th>
                        <th scope="col" style="text-align:center; vertical-align:middle; width:30%;">메시지</th>
                        <th scope="col" style="text-align:center; vertical-align:middle; width:20%;">현재위치</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    @endforeach
    <div style="display: flex; justify-content: center;">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6095871392041989"
            crossorigin="anonymous"></script>
        
        <ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px"
            data-ad-client="ca-pub-6095871392041989" data-ad-slot="4284243830"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

    <script>
        var url = "/subway_ajax/{{ $station_name }}";

        var barvlDt_array = [];
        var btrainNo_array = [];
        var recptnDt_array = [];
        var count = 0;


        $(document).ready(function() {
            function isMobile() {
                return window.innerWidth <= 520;
            }

            function isMobile2() {
                return window.innerWidth <= 768;
            }

            function isMobile3() {
                return window.innerWidth <= 1000;
            }

            function isMobile4() {
                return window.innerWidth <= 1500;
            }

            function adjustFontSize() {
                if (isMobile()) {
                    $('td, th, button').css('font-size', '10px');
                    $('table').css('width', '100%');
                } else if (isMobile2()) {
                    $('td, th, button').css('font-size', '12px');
                    $('table').css('width', '90%');
                } else if (isMobile3()) {
                    $('td, th, button').css('font-size', '15px');
                    $('table').css('width', '70%');
                } else if (isMobile4()) {
                    $('td, th, button').css('font-size', '16px');
                    $('table').css('width', '60%');
                } else {
                    $('td, th, button').css('font-size', '17px');
                    $('table').css('width', '50%');
                }
            }

            // 최초 준비 완료 시 폰트 크기 조절
            adjustFontSize();

            // 창 크기 변경 시 폰트 크기 조절
            $(window).resize(adjustFontSize);

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

                        var hours = currentdate.getHours();
                        var minutes = currentdate.getMinutes();
                        var seconds = currentdate.getSeconds();

                        var hours = (hours < 10) ? "0" + hours : hours;
                        var minutes = (minutes < 10) ? "0" + minutes : minutes;
                        var seconds = (seconds < 10) ? "0" + seconds : seconds;

                        $("#current_time").text(hours + "시 " + minutes + "분 " + seconds + "초")

                        for (i = 0; i < data.realtimeArrivalList.length; i++) {
                            if (data.realtimeArrivalList[i].updnLine == "상행") {
                                direction = "up";
                            } else if (data.realtimeArrivalList[i].updnLine == "외선") {
                                direction = "up";
                            } else {
                                direction = "down";
                            }

                            barvlDt = parseInt(data.realtimeArrivalList[i].barvlDt);

                            if (barvlDt != 0) {
                                /*
                                if (barvlDt < 180) {
                                    if (count > 0) {
                                        index = btrainNo_array.indexOf(data.realtimeArrivalList[i]
                                            .btrainNo);

                                        if (index !== -1) {
                                            if (data.realtimeArrivalList[i].barvlDt == barvlDt_array[
                                                    index]) {
                                                data.realtimeArrivalList[i].recptnDt = recptnDt_array[
                                                    index];
                                            } else {
                                                console.log(data.realtimeArrivalList[i].trainLineNm);
                                                console.log("기존값 : " + barvlDt_array[index]);
                                                console.log("변경값 : " + data.realtimeArrivalList[i]
                                                    .barvlDt);

                                                barvlDt_array[index] = data.realtimeArrivalList[i]
                                                    .barvlDt;
                                                recptnDt_array[index] = data.realtimeArrivalList[i]
                                                    .recptnDt;

                                            }
                                        } else {
                                            if (count > 200) {
                                                barvlDt_array = [];
                                                btrainNo_array = [];
                                                recptnDt_array = [];
                                                count = 0
                                            }
                                            barvlDt_array[count] = data.realtimeArrivalList[i].barvlDt;
                                            btrainNo_array[count] = data.realtimeArrivalList[i]
                                                .btrainNo;
                                            recptnDt_array[count] = data.realtimeArrivalList[i]
                                                .recptnDt;
                                            count++;
                                        }
                                    } else {
                                        barvlDt_array[count] = data.realtimeArrivalList[i].barvlDt;
                                        btrainNo_array[count] = data.realtimeArrivalList[i].btrainNo;
                                        recptnDt_array[count] = data.realtimeArrivalList[i].recptnDt;
                                        count++;
                                    }
                                }
                                */
                                // 최신 지하철 시간
                                var givenDate = new Date(data.realtimeArrivalList[i].recptnDt);

                                // 시간 더하기
                                givenDate.setSeconds(givenDate.getSeconds() + barvlDt);

                                remain_seconds = Math.floor((givenDate - currentdate) / 1000);

                                if (remain_seconds <= 10) {
                                    barvl_message = "도착";
                                } else if (remain_seconds <= 25) {
                                    barvl_message = "진입중";
                                } else {
                                    minutes = Math.floor(remain_seconds / 60);
                                    seconds = remain_seconds % 60;
                                    barvl_message = minutes + "분 " + seconds + "초";
                                }
                            } else {
                                barvl_message = "미제공";
                            }

                            var row = "<tr>" +
                                "<td style='text-align: center; vertical-align:middle;'>" +
                                data
                                .realtimeArrivalList[i].trainLineNm +
                                "</td>" +
                                "<td style='text-align: center; vertical-align:middle;' class='arrive_time'>" +
                                barvl_message +
                                "</td>" +
                                "<td style='text-align: center; vertical-align:middle;' class='" +
                                direction + "_" + data.realtimeArrivalList[i].subwayId + "_arvlMsg2'>" +
                                data
                                .realtimeArrivalList[i].arvlMsg2 +
                                "</td>" +
                                "<td style='text-align: center; vertical-align:middle;'>" + data
                                .realtimeArrivalList[i].arvlMsg3 + "</td>";

                            $("#" + direction + "_" + data.realtimeArrivalList[i].subwayId + " tbody")
                                .append(row);
                        }
                        adjustFontSize();
                    }
                });
            }

            subway_ajax();

            var intervalId = setInterval(subway_ajax, 1000);
            /*
            // 1초마다 1초씩 시간 줄이기
            setInterval(function() {
                // 클래스가 'time1'인 모든 요소에 대해 처리
                $('.arrive_time').each(function() {
                    // 현재 내용을 가져와서 '분'과 '초'를 분리
                    var timeText = $(this).text();
                    var timeParts = timeText.split(' ');

                    // 배열의 길이 확인
                    if (timeParts.length === 2) {
                        var minutes = parseInt(timeParts[0]);
                        var seconds = parseInt(timeParts[1]);

                        // 1초씩 감소
                        if (seconds > 0) {
                            seconds--;
                        } else if (minutes > 0) {
                            minutes--;
                            seconds = 59;
                        }

                        // 시간에 따라 다른 텍스트 출력
                        if ((minutes == 0 && seconds < 20) || minutes < 0) {
                            $(this).text('도착');
                        } else if (minutes == 0 && seconds < 40) {
                            $(this).text('진입중');
                        } else if (minutes == 0 && seconds < 59) {
                            $(this).text('곧도착');
                        } else {
                            $(this).text(minutes + '분 ' + seconds + '초');
                        }
                    }

                    // 감소된 값을 다시 출력

                });
            }, 1000); // 1000 밀리초는 1초
            */

        });
    </script>
</body>

</html>
