<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="naver-site-verification" content="4ed9ef80731427423db9929dad7848a70ea9e5d1" />

    <!-- 구글애드센스 -->
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

</head>

<body>
    <div style="display: flex; justify-content: center;">
        <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col" colspan="3" style="text-align: center; vertical-align:middle; width:60%;">
                        서울지하철 초단위 도착 정보시스템
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    @foreach ($linecodes_sql as $index => $linecode_sql)
        <div style="display: flex; justify-content: center;">
            <table class="table table-striped table-hover table-bordered border-dark" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col" colspan="4" style="text-align: center">
                            {{ $linecode_sql->line_name }}
                        </th>
                    </tr>
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($station_sqls as $station_sql)
                        @if ($station_sql->line_id == $linecode_sql->line_code)
                            @if ($count % 4 == 0)
                                <tr>
                            @endif
                            <th scope="col" style="text-align:center; vertical-align:middle; width:25%;">
                                <a
                                    href="{{ route('subway', ['station_name' => $station_sql->station_name]) }}">{{ $station_sql->station_name }}</a>
                            </th>
                            @if (++$count % 4 == 0)
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    @if ($count % 4 != 0)
                        </tr>
                    @endif
                </thead>
                <tbody>
                </tbody>
            </table>
            @if ($index == 0)
            @endif
        </div>
    @endforeach

    <script>
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

        });
    </script>
</body>

</html>
