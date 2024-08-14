<?php

namespace Database\Seeders;

use App\Models\Gap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gaps = array(
            array(
                "id" => 1,
                "gap" => "0",
                "bobot" => 5,
                "keterangan" => "Kompetensi Sesuai Kebutuhan",
                "created_at" => "2024-08-14 05:51:15",
                "updated_at" => "2024-08-14 05:51:15",
            ),
            array(
                "id" => 2,
                "gap" => "1",
                "bobot" => 5,
                "keterangan" => "Kompetensi Kelebihan 1 Tingkat/Level",
                "created_at" => "2024-08-14 05:51:27",
                "updated_at" => "2024-08-14 05:51:27",
            ),
            array(
                "id" => 3,
                "gap" => "-1",
                "bobot" => 4,
                "keterangan" => "Kompetensi Kekurangan 1 Tingkat/Level",
                "created_at" => "2024-08-14 05:51:38",
                "updated_at" => "2024-08-14 05:51:38",
            ),
            array(
                "id" => 4,
                "gap" => "2",
                "bobot" => 4,
                "keterangan" => "Kompetensi Kelebihan 2 Tingkat/Level",
                "created_at" => "2024-08-14 05:51:50",
                "updated_at" => "2024-08-14 05:51:50",
            ),
            array(
                "id" => 5,
                "gap" => "-2",
                "bobot" => 3,
                "keterangan" => "Kompetensi Kekurangan 2 Tingkat/Level",
                "created_at" => "2024-08-14 05:52:06",
                "updated_at" => "2024-08-14 05:52:06",
            ),
            array(
                "id" => 6,
                "gap" => "3",
                "bobot" => 3,
                "keterangan" => "Kompetensi Kelebihan 3 Tingkat/Level",
                "created_at" => "2024-08-14 05:52:19",
                "updated_at" => "2024-08-14 05:52:19",
            ),
            array(
                "id" => 7,
                "gap" => "-3",
                "bobot" => 2,
                "keterangan" => "Kompetensi Kekurangan 3 Tingkat/Level",
                "created_at" => "2024-08-14 05:52:31",
                "updated_at" => "2024-08-14 05:52:31",
            ),
            array(
                "id" => 8,
                "gap" => "4",
                "bobot" => 2,
                "keterangan" => "Kompetensi Kelebihan 4 Tingkat/Level",
                "created_at" => "2024-08-14 05:52:45",
                "updated_at" => "2024-08-14 05:52:45",
            ),
            array(
                "id" => 9,
                "gap" => "-4",
                "bobot" => 1,
                "keterangan" => "Kompetensi Kekurangan 4 Tingkat/Level",
                "created_at" => "2024-08-14 05:52:56",
                "updated_at" => "2024-08-14 05:52:56",
            ),
            array(
                "id" => 10,
                "gap" => "5",
                "bobot" => 1,
                "keterangan" => "Kompetensi Kelebihan 5 Tingkat/Level",
                "created_at" => "2024-08-14 05:53:10",
                "updated_at" => "2024-08-14 05:53:10",
            ),
            array(
                "id" => 11,
                "gap" => "-5",
                "bobot" => 0,
                "keterangan" => "Kompetensi Kekurangan 5 Tingkat/Level",
                "created_at" => "2024-08-14 05:53:21",
                "updated_at" => "2024-08-14 05:53:21",
            ),
        );

        Gap::insert($gaps);
    }
}
