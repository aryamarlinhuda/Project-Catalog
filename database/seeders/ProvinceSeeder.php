<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [
            "Aceh",
            "Bali",
            "Bangka Belitung",
            "Banten",
            "Bengkulu",
            "DI Yogyakarta",
            "DKI Jakarta",
            "Gorontalo",
            "Jambi",
            "Jawa Barat",
            "Jawa Tengah",
            "Jawa Timur",
            "Kalimantan Barat",
            "Kalimantan Selatan",
            "Kalimantan Tengah",
            "Kalimantan Timur",
            "Kalimantan Utara",
            "Kepulauan Riau",
            "Lampung",
            "Maluku",
            "Maluku Utara",
            "Nusa Tenggara Barat",
            "Nusa Tenggara Timur",
            "Papua",
            "Papua Barat",
            "Papua Barat Daya",
            "Papua Pegunungan",
            "Papua Selatan",
            "Papua Tengah",
            "Riau",
            "Sulawesi Barat",
            "Sulawesi Selatan",
            "Sulawesi Tengah",
            "Sulawesi Tenggara",
            "Sulawesi Utara",
            "Sumatera Barat",
            "Sumatera Selatan",
            "Sumatera Utara"
        ];

        foreach ($provinces as $province) {
            Province::create([
                "name" => $province
            ]);
        }
    }
}
