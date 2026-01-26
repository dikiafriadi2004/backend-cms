<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdSpace;

class AdSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = [
            [
                'name' => 'Header Banner Manual',
                'title' => 'Promo Spesial Hari Ini',
                'description' => 'Dapatkan diskon hingga 50% untuk semua produk',
                'image_url' => 'https://via.placeholder.com/728x90/4F46E5/FFFFFF?text=Header+Banner+728x90',
                'link_url' => 'https://example.com/promo',
                'position' => 'header',
                'type' => 'manual_banner',
                'width' => 728,
                'height' => 90,
                'alt_text' => 'Promo Spesial Banner',
                'open_new_tab' => true,
                'sort_order' => 1,
                'status' => true,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'code' => null,
            ],
            [
                'name' => 'Sidebar AdSense',
                'title' => null,
                'description' => 'Google AdSense untuk sidebar',
                'image_url' => null,
                'link_url' => null,
                'position' => 'sidebar_top',
                'type' => 'adsense',
                'width' => null,
                'height' => null,
                'alt_text' => null,
                'open_new_tab' => true,
                'sort_order' => 1,
                'status' => true,
                'start_date' => now(),
                'end_date' => null,
                'code' => '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXX" crossorigin="anonymous"></script>
<!-- Sidebar Ad -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-XXXXXXXXXX"
     data-ad-slot="XXXXXXXXXX"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>',
            ],
            [
                'name' => 'Content Adsera',
                'title' => null,
                'description' => 'Adsera untuk konten tengah',
                'image_url' => null,
                'link_url' => null,
                'position' => 'content_middle',
                'type' => 'adsera',
                'width' => null,
                'height' => null,
                'alt_text' => null,
                'open_new_tab' => true,
                'sort_order' => 1,
                'status' => true,
                'start_date' => now(),
                'end_date' => null,
                'code' => '<div id="adsera-XXXXXXXXXX"></div>
<script type="text/javascript">
    (function() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.async = true;
        script.src = "//ads.adsera.com/js/XXXXXXXXXX.js";
        var node = document.getElementsByTagName("script")[0];
        node.parentNode.insertBefore(script, node);
    })();
</script>',
            ],
            [
                'name' => 'Footer Text Link',
                'title' => 'Kunjungi Partner Kami',
                'description' => 'Dapatkan penawaran menarik dari partner terpercaya',
                'image_url' => null,
                'link_url' => 'https://example.com/partners',
                'position' => 'footer',
                'type' => 'manual_text',
                'width' => null,
                'height' => null,
                'alt_text' => null,
                'open_new_tab' => true,
                'sort_order' => 1,
                'status' => true,
                'start_date' => now(),
                'end_date' => null,
                'code' => null,
            ],
            [
                'name' => 'Mobile Banner Manual',
                'title' => 'Download App Mobile',
                'description' => 'Download aplikasi mobile kami untuk pengalaman yang lebih baik',
                'image_url' => 'https://via.placeholder.com/320x50/EF4444/FFFFFF?text=Mobile+Banner+320x50',
                'link_url' => 'https://example.com/mobile-app',
                'position' => 'mobile_banner',
                'type' => 'manual_banner',
                'width' => 320,
                'height' => 50,
                'alt_text' => 'Download App Mobile Banner',
                'open_new_tab' => true,
                'sort_order' => 1,
                'status' => true,
                'start_date' => now(),
                'end_date' => now()->addDays(90),
                'code' => null,
            ],
            [
                'name' => 'Between Posts AdSense',
                'title' => null,
                'description' => 'AdSense di antara postingan',
                'image_url' => null,
                'link_url' => null,
                'position' => 'between_posts',
                'type' => 'adsense',
                'width' => null,
                'height' => null,
                'alt_text' => null,
                'open_new_tab' => false,
                'sort_order' => 1,
                'status' => true,
                'start_date' => now(),
                'end_date' => null,
                'code' => '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXX" crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-XXXXXXXXXX"
     data-ad-slot="XXXXXXXXXX"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>',
            ]
        ];

        foreach ($ads as $ad) {
            AdSpace::create($ad);
        }
    }
}