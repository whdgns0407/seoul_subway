<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://subway.koreaexam.com</loc>
    </url>
    @foreach ($station_sqls as $station_sql)
        <url>
            <loc>{{ route('subway', ['station_name' => $station_sql->station_name]) }}</loc>
            <changefreq>always</changefreq>
        </url>
    @endforeach
</urlset>
