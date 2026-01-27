<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($urls as $u)
        <url>
            <loc>{{ $u }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach($products as $p)
        <url>
            <loc>{{ url('/p/' . $p->slug) }}</loc>
            @if(!empty($p->updated_at))
                <lastmod>{{ optional($p->updated_at)->format('Y-m-d') }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>
