<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keputusan;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getStaff($departement_id, Request $request)
    {
        $staff = Staff::where('departement_id', $departement_id)->when($request->exists('search') ?? null, function ($query, $search) {
            $query->where('nama', 'LIKE', '%' . $search . '%');
        })->get();

        return response()->json($staff);
    }
    public function getRewardStaff(Request $request)
    {
        $staffs = $request->staff;
        $result = [];
        foreach ($staffs as $key => $staff) {
            $staff_id = $staff['staff']['id'];

            $tahun = Carbon::now()->format('Y');
            $putusan = Keputusan::where('staff_id', $staff_id)->where('jenis_putusan', 'reward')->whereYear('created_at', $tahun)->get()->count();
            $reward = 'sertifikat penghargaan';
            switch ($putusan) {
                case 0:
                    $reward = 'sertifikat penghargaan';
                    break;
                case 1:
                    $reward = 'sertifikat dan bonus uang tunai';
                    break;
                case 2:
                    $reward = 'promosi jabatan';
                    break;

                default:
                    $reward = 'sertifikat penghargaan';
                    break;
            }
            $result[$key] = [
                'staff' => $staff['staff'],
                'hasil' => $staff['hasil'],
                'reward' => $reward,
            ];
        }
        return $result;
    }
    public function getPunishmentStaff(Request $request)
    {
        $staffs = $request->staff;
        $batas = $request->batas;
        $result = [];
        $punishment = [
            'Diberikan teguran SP1',
            'memberikan tugas tambahan',
            'Dilarang melakukan perjalanan dinas',
            'Rotasi jabatan',
        ];
        foreach ($staffs as $key => $staff) {
            $staff_id = $staff['staff']['id'];

            $tahun = Carbon::now()->format('Y');
            $putusan = Keputusan::where('staff_id', $staff_id)->where('jenis_putusan', 'punishment')->whereYear('created_at', $tahun)->get()->count();

            $nilai = $staff['hasil'];

            if (array_key_exists($key, $punishment)) {
               $punish = $punishment[$key];
            }else{
                $punish = 'Rotasi Jabatan';
            }

            $result[$key] = [
                'staff' => $staff['staff'],
                'hasil' => $staff['hasil'],
                'reward' => $punish,
            ];
        }
        return $result;
    }
}
