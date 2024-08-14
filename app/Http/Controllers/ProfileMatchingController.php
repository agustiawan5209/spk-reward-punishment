<?php

namespace App\Http\Controllers;

use App\Models\Gap;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\AspekKriteria;
use App\Models\KriteriaPenilaian;
use App\Models\Staff;

/**
 * Kelas ProfileMatchingController untuk mengelola proses matching profil
 */
class ProfileMatchingController extends Controller
{
    private $kategori_id;
    private $matirx_hasil;

    /**
     * Konstruktor untuk menginisialisasi kategori ID
     *
     * @param int $kategori_id
     */
    public function __construct($kategori_id)
    {
        $this->kategori_id = $kategori_id;
    }

    /**
     * Fungsi untuk menghasilkan peringkat hasil matching profil
     *
     * @param array $mtx Matriks hasil matching profil
     * @return array Peringkat hasil matching profil
     *
     * Contoh:
     * $mtx = [
     *     '1-2' => 0.5,
     *     '1-3' => 0.6,
     *     '2-1' => 0.7,
     *     '2-3' => 0.8,
     * ];
     * $result = $this->resultRank($mtx);
     * print_r($result);
     */
    public function resultRank()
    {
        $result = [];

        foreach ($this->matirx_hasil as $key => $value) {
            // Memecah key berdasarkan tanda "-"
            list($firstPart, $secondPart) = explode("-", $key);

            // Jika key pertama sudah ada di result, tambahkan nilai, jika tidak, inisialisasi
            if (isset($result[$firstPart])) {
                $result[$firstPart][$key] = $value;
            } else {
                $result[$firstPart][$key] = $value;
            }
        }

        $rank = [];
        foreach ($result as $key => $value) {
            $staff = Staff::with(['departement'])->findOrFail($key);
            $rank[$key] = [
                'staff' => $staff,
                'hasil' => array_sum($value) / count($value),
            ];
        }

        return $rank;
    }

    /**
     * Fungsi untuk mendapatkan matriks penilaian karyawan
     *
     * @return array Matriks penilaian karyawan
     *
     * Contoh:
     * $matrix = $this->matrixPenilai();
     * print_r($matrix);
     */
    public function matrixPenilai()
    {
        $penilaian = Penilaian::with(['datapenilaian'])->where('kategori_id', $this->kategori_id)->get();

        $matrix = [];

        $matrix_selisih = [];
        $matrix_penilaian = [];
        $matrix_factory = [];
        $matrix_total = [];
        foreach ($penilaian as $key => $value) {
            // Cek Jika data penilaian ada

            if ($value->datapenilaian->count() > 0) {
                // Membuat Key untuk matrix
                // Id Dari Staff dan ID dari staff penilai
                $key_id = $value->staff_id . '-' . $value->staff_penilai_id;
                $Key_karyawan = $value->staff['nama'] . '-'. $value->staff_penilai_id;

                // Profile Ideal
                $ProfileIdeal = $this->getProfileIdeal($value->aspek_id);
                // Factory Core
                $factory_core = $this->getFactoryCore($value->aspek_id);
                // Factory Secondary
                $factory_secondary = $this->getFactorySecondary($value->aspek_id);
                // Aspek Kriteria
                $aspek = $this->getAspek($value->aspek_id);

                //Masukkan Nilai Bobot ke dalam matrix;
                $matrix[$key_id] = [];
                $matrix_selisih[$Key_karyawan] = [];
                $matrix_penilaian[$Key_karyawan] = [];
                $matrix_factory[$Key_karyawan] = [];
                $matrix_total[$Key_karyawan] = [];

                $data_penilaian = $value->datapenilaian;
                $cf = [];
                $sf = [];
                foreach ($data_penilaian as $col => $item) {

                    // Cari Kriteria Berdasarkan ID;
                    $kriteria = KriteriaPenilaian::find($item->kriteria_id);
                    if ($kriteria == null) {
                        $kriteria = $item->kriteria;
                    }

                    // Mendapatkan Nilai Selisih pada core factory
                    if ($kriteria->factory == 'core') {
                        $selisih_gap = $this->hitungSelisih($item->nilai, $ProfileIdeal[$col]);

                        $cf[$col] = $selisih_gap;
                        $matrix_selisih[$Key_karyawan][$col] = $selisih_gap;
                        $matrix_penilaian[$Key_karyawan][$col] = $selisih_gap;

                        // Mendapatkan Nilai Selisih pada secondary factory
                    } else if ($kriteria->factory == 'secondary') {
                        $selisih_gap = $this->hitungSelisih($item->nilai, $ProfileIdeal[$col]);

                        $sf[$col] = $selisih_gap;
                        $matrix_selisih[$Key_karyawan][$col] = $selisih_gap;
                        $matrix_penilaian[$Key_karyawan][$col] = $item->nilai;
                    }
                }
                // Menghitung nilai total setelah menghitung nilai selisih pada gap dan factory
                $matrix[$key_id] = $this->getValueTotal($factory_core, $factory_secondary, $this->getFactoryValue($cf), $this->getFactoryValue($sf));
                $matrix_total[$Key_karyawan] = $this->getValueTotal($factory_core, $factory_secondary, $this->getFactoryValue($cf), $this->getFactoryValue($sf));
                $matrix_factory[$Key_karyawan] = [$this->getFactoryValue($cf), $this->getFactoryValue($sf)];
            }
        }
        $this->matirx_hasil = $matrix;
        return [
            'rank' => $this->resultRank(),
            'nilai_total' => $matrix[$key_id],
            'hitung_selisih'=> $matrix_selisih,
            'matrix_penilaian'=> $matrix_penilaian,
            'matrix_factory'=> $matrix_factory,
            'matrix_total'=> $matrix_total,
        ];
    }

    /**
     * Fungsi untuk mendapatkan nilai core factory pada aspek kriteria
     *
     * @param int $aspek_id
     * @return numeric Nilai core factory
     *
     * Contoh:
     * $factory_core = $this->getFactoryCore(1);
     * echo $factory_core;
     */
    public function getFactoryCore($aspek_id)
    {
        $factory = AspekKriteria::find($aspek_id);

        return $factory->core_factory;
    }

    /**
     * Fungsi untuk mendapatkan nilai secondary factory pada aspek kriteria
     *
     * @param int $aspek_id
     * @return numeric Nilai secondary factory
     *
     * Contoh:
     * $factory_secondary = $this->getFactorySecondary(1);
     * echo $factory_secondary;
     */
    public function getFactorySecondary($aspek_id)
    {
        $factory = AspekKriteria::find($aspek_id);

        return $factory->secondary_factory;
    }

    /**
     * Fungsi untuk mendapatkan nilai aspek
     *
     * @param int $aspek_id
     * @return object Aspek
     *
     * Contoh:
     * $aspek = $this->getAspek(1);
     * print_r($aspek);
     */
    public function getAspek($aspek_id)
    {
        $aspek = AspekKriteria::with(['kriteriapenilaian'])->find($aspek_id);
        return $aspek;
    }

    /**
     * Fungsi untuk mendapatkan profile ideal dari masing-masing kriteria
     *
     * @param int $aspek_id
     * @return array Profile ideal
     *
     * Contoh:
     * $profile_ideal = $this->getProfileIdeal(1);
     * print_r($profile_ideal);
     */
    public function getProfileIdeal($aspek_id)
    {
        $aspek = AspekKriteria::with(['kriteriapenilaian'])->find($aspek_id);
        $kriteria = $aspek->kriteriapenilaian;
        $ProfileIdeal = [];
        foreach ($kriteria as $key => $value) {
            $ProfileIdeal[$key] = $value->nilai_target;
        }

        return $ProfileIdeal;
    }

    /**
     * Fungsi untuk menghitung selisih antara nilai dan target
     *
     * @param numeric $profile Nilai
     * @param numeric $ideal Target
     * @return numeric Selisih
     *
     * Contoh:
     * $selisih = $this->hitungSelisih(10, 15);
     * echo $selisih;
     */
    public function hitungSelisih($profile, $ideal)
    {
        if (is_numeric($profile) && is_numeric($ideal)) {
            return $this->getGap($ideal - $profile);
        } else {
            return 0;
        }
    }

    /**
     * Fungsi untuk mendapatkan nilai gap
     *
     * @param numeric $value Nilai
     * @return numeric Nilai gap
     *
     * Contoh:
     * $gap = $this->getGap(5);
     * echo $gap;
     */
    private function getGap($value)
    {
        $gap = Gap::where('gap', '=', $value)->first();

        return intval($gap->bobot);
    }

    /**
     * Fungsi untuk mendapatkan nilai factory
     *
     * @param array $factory Nilai factory
     * @return numeric Nilai factory
     *
     * Contoh:
     * $factory_value = $this->getFactoryValue([1, 2, 3]);
     * echo $factory_value;
     */
    private function getFactoryValue($factory = [])
    {
        $result = array_sum($factory) / count($factory);
        return $result;
    }

    /**
     * Fungsi untuk mendapatkan nilai total
     *
     * @param numeric $core_factory Nilai core factory
     * @param numeric $secondary_factory Nilai secondary factory
     * @param numeric $cf Nilai CF
     * @param numeric $sf Nilai SF
     * @return numeric Nilai total
     *
     * Contoh:
     * $total = $this->getValueTotal(10, 20, 30, 40);
     * echo $total;
     */
    private function getValueTotal($core_factory, $secondary_factory, $cf, $sf)
    {
        return (($core_factory / 100) * $cf) + (($secondary_factory / 100) * $sf);
    }
}
