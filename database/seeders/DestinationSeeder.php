<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $destinations = [
            [
                "name" => "Lawang Sewu",
                "description" => "Lawang Sewu adalah gedung bersejarah milik PT Kereta Api Indonesia (Persero) yang awalnya digunakan sebagai Kantor Pusat perusahaan kereta api swasta Nederlandsch-Indische Spoorweg Maatschappij (NISM).",
                "category_id" => 5,
                "address" => "Jl. Pemuda No.160, Sekayu, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah",
                "province_id" => 11,
                "city_id" => 143,
                "budget" => "20000",
                "latitude" => "-6.9840024720946765",
                "longitude" => "110.41081242568195"
            ],[
                "name" => "Candi Gedong Songo",
                "description" => "Gedong Songo berasal dari bahasa Jawa, “Gedong” berarti rumah atau bangunan, “Songo” berarti sembilan. Jadi Arti kata Gedongsongo adalah sembilan (kelompok) bangunan. Lokasi 9 candi yang tersebar di lereng Gunung Ungaran ini memiliki pemandangan alam yang indah.",
                "category_id" => 5,
                "address" => "Jalan Ke Candi Gedong Songo, Candi, Krajan, Banyukuning, Bandungan, Kabupaten Semarang, Jawa Tengah",
                "province_id" => 11,
                "city_id" => 133,
                "budget" => "15000",
                "latitude" => "-7.209706760514152",
                "longitude" => "110.34217267293529"
            ],[
                "name" => "Telaga Menjer",
                "description" => "Gedong Songo berasal dari bahasa Jawa, “Gedong” berarti rumah atau bangunan, “Songo” berarti sembilan. Jadi Arti kata Gedongsongo adalah sembilan (kelompok) bangunan. Lokasi 9 candi yang tersebar di lereng Gunung Ungaran ini memiliki pemandangan alam yang indah.",
                "category_id" => 5,
                "address" => "Kec. Garung, Kabupaten Wonosobo, Jawa Tengah",
                "province_id" => 11,
                "city_id" => 139,
                "budget" => "3000",
                "latitude" => "-7.268511606151799",
                "longitude" => "109.92586293644581"
            ],[
                "name" => "Pantai Kuta",
                "description" => "Pantai Kuta adalah sebuah tempat pariwisata yang terletak di kecamatan Kuta sebelah selatan Kota Denpasar, Bali, Indonesia. Daerah ini merupakan sebuah tujuan wisata turis mancanegara dan telah menjadi objek wisata andalan Pulau Bali sejak awal tahun 1970-an. Pantai Kuta sering pula disebut sebagai pantai matahari terbenam sebagai lawan dari pantai Sanur.",
                "category_id" => 2,
                "address" => "Kec. Kuta, Kabupaten Badung, Bali",
                "province_id" => 2,
                "city_id" => 24,
                "budget" => null,
                "latitude" => "-8.712178472973955",
                "longitude" => "115.16709033024156"
            ],[
                "name" => "Gunung Bromo",
                "description" => "Gunung Bromo adalah salah satu gunung api yang masih aktif di Indonesia. Gunung yang memiliki ketinggian 2.392 meter di atas permukaan laut ini merupakan destinasi andalan Jawa Timur. Gunung Bromo berdiri gagah dikelilingi kaldera atau lautan pasir seluas 10 kilometer persegi.",
                "category_id" => 6,
                "address" => "Area Gn. Bromo, Podokoyo, Kec. Tosari, Pasuruan, Jawa Timur",
                "province_id" => 12,
                "city_id" => 165,
                "budget" => "34000",
                "latitude" => "-7.941473233848667",
                "longitude" => "112.95314086361118"
            ],[
                "name" => "Taman Mini Indonesia Indah",
                "description" => "Taman Mini Indonesia Indah (TMII) merupakan rangkuman kebudayaan bangsa Indonesia, yang mencakup berbagai aspek kehidupan sehari-hari masyarakat 33 provinsi Indonesia (pada tahun 1975) yang ditampilkan dalam anjungan daerah berarsitektur tradisional, serta menampilkan aneka busana, tarian dan tradisi daerah.",
                "category_id" => 4,
                "address" => "TMII, Jl. Raya, Ceger, Kec. Cipayung, Kota Jakarta Timur, DKI Jakarta",
                "province_id" => 7,
                "city_id" => 66,
                "budget" => "25000",
                "latitude" => "-6.304280722745155",
                "longitude" => "106.89171281198382"
            ],[
                "name" => "Masjid Agung Demak",
                "description" => "Masjid Agung Demak merupakan masjid kuno yang dibangun oleh Raden Patah dari Kerajaan Demak dibantu para Walisongo pada abad ke-15 Masehi. Masjid ini masuk dalam salah satu jajaran masjid tertua di Indonesia. Lokasi Masjid Agung Demak terletak di Kampung Kauman, Kelurahan Bintoro, Kabupaten Demak, Jawa Tengah. Berada tepat di alun-alun dan pusat keramaian Demak, Masjid Agung Demak tak sulit untuk ditemukan.",
                "category_id" => 9,
                "address" => "Kampung Kauman, Kelurahan Bintoro, Kec. Demak, Kabupaten Demak, Jawa Tengah.",
                "province_id" => 11,
                "city_id" => 118,
                "budget" => null,
                "latitude" => "-6.894458170539253",
                "longitude" => "110.63722462178305"
            ]
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
