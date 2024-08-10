<?php

namespace Database\Seeders;

use App\Models\KriteriaPenilaian;
use App\Models\SubKriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria_penilaians = array(
            array(
                "id" => 1,
                "aspek_id" => 1,
                "nama" => "Loyalitas",
                "bobot" => NULL,
                "factory" => "core",
                "nilai_target" => 3,
                "created_at" => "2024-08-09 19:55:20",
                "updated_at" => "2024-08-10 01:43:52",
            ),
            array(
                "id" => 2,
                "aspek_id" => 1,
                "nama" => "Kedisiplinan",
                "bobot" => NULL,
                "factory" => "core",
                "nilai_target" => 3,
                "created_at" => "2024-08-09 19:55:20",
                "updated_at" => "2024-08-10 01:43:52",
            ),
            array(
                "id" => 3,
                "aspek_id" => 1,
                "nama" => "Kinerja",
                "bobot" => NULL,
                "factory" => "core",
                "nilai_target" => 3,
                "created_at" => "2024-08-09 19:55:20",
                "updated_at" => "2024-08-10 01:43:52",
            ),
            array(
                "id" => 4,
                "aspek_id" => 1,
                "nama" => "Profesional",
                "bobot" => NULL,
                "factory" => "core",
                "nilai_target" => 3,
                "created_at" => "2024-08-09 19:55:20",
                "updated_at" => "2024-08-10 01:43:52",
            ),
            array(
                "id" => 5,
                "aspek_id" => 1,
                "nama" => "Integritas",
                "bobot" => NULL,
                "factory" => "core",
                "nilai_target" => 3,
                "created_at" => "2024-08-09 19:55:20",
                "updated_at" => "2024-08-10 01:43:52",
            ),
            array(
                "id" => 6,
                "aspek_id" => 1,
                "nama" => "Totalitas",
                "bobot" => NULL,
                "factory" => "core",
                "nilai_target" => 3,
                "created_at" => "2024-08-09 19:55:20",
                "updated_at" => "2024-08-10 01:43:52",
            ),
        );

        KriteriaPenilaian::insert($kriteria_penilaians);

        $no = 1;
        $sub_kriterias = [];
        for ($i = 1; $i < 7; $i++) {
            $sub_kriterias = array(
                array(
                    "id" => $no++,
                    "kriteria_id" => $i,
                    "nama" => "Tidak Memuaskan",
                    "bobot" => 1,
                    "created_at" => "2024-08-10 01:43:52",
                    "updated_at" => "2024-08-10 01:43:52",
                ),
                array(
                    "id" => $no++,
                    "kriteria_id" => $i,
                    "nama" => "Kurang Memuaskan",
                    "bobot" => 2,
                    "created_at" => "2024-08-10 01:43:52",
                    "updated_at" => "2024-08-10 01:43:52",
                ),
                array(
                    "id" => $no++,
                    "kriteria_id" => $i,
                    "nama" => "Memenuhi harapan",
                    "bobot" => 3,
                    "created_at" => "2024-08-10 01:43:52",
                    "updated_at" => "2024-08-10 01:43:52",
                ),
                array(
                    "id" => $no++,
                    "kriteria_id" => $i,
                    "nama" => "Melebihi Harapan",
                    "bobot" => 4,
                    "created_at" => "2024-08-10 01:43:52",
                    "updated_at" => "2024-08-10 01:43:52",
                ),
                array(
                    "id" => $no++,
                    "kriteria_id" => $i,
                    "nama" => "Luar Biasa",
                    "bobot" => 5,
                    "created_at" => "2024-08-10 01:43:52",
                    "updated_at" => "2024-08-10 01:43:52",
                ),
            );
            SubKriteria::insert($sub_kriterias);
        }
    }
}
