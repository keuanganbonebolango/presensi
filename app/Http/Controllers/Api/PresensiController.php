<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Traits\ImageStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class PresensiController extends Controller
{
    use ImageStorage;

    /**
     * Store presence status
     * @param Request $request
     * @return JsonResponse|void
     * @throws InvalidFormatException
     * @throws BindingResolutionException
     */
    public function store(Request $request)
    {
        $request->validate([
            'long' => ['required'],
            'lat' => ['required'],
            'alamat' => ['required'],
            'type' => ['in:in,out', 'required'],
            'gambar_presensi' => ['required']
        ]);

        $gambar_presensi = $request->file('gambar_presensi');
        $presensiType = $request->type;
        $userPresensiToday = $request->user()
            ->presensi()
            ->whereDate('created_at', Carbon::today())
            ->first();

        // is presence type equal with 'in' ?
        if ($presensiType == 'in') {
            // is $userPresenceToday not found?
            if (!$userPresensiToday) {
                $presensi = $request
                    ->user()
                    ->presensi()
                    ->create(
                        [
                            'status' => false
                        ]
                    );

                $presensi->presensidetail()->create(
                    [
                        'type' => 'in',
                        'long' => $request->long,
                        'lat' => $request->lat,
                        'gambar_presensi' => $this->uploadImage($gambar_presensi, $request->user()->name, 'presensi'),
                        'alamat' => $request->alamat
                    ]
                );

                return response()->json(
                    [
                        'message' => 'Success'
                    ],
                    Response::HTTP_CREATED
                );
            }

            // else show user has been checked in
            return response()->json(
                [
                    'message' => 'User ini telah check in',
                ],
                Response::HTTP_OK
            );
        }

        if ($presensiType == 'out') {
            if ($userPresensiToday) {

                if ($userPresensiToday->status) {
                    return response()->json(
                        [
                            'message' => 'User telah checked out',
                        ],
                        Response::HTTP_OK
                    );
                }

                $userPresensiToday->update(
                    [
                        'status' => true
                    ]
                );

                $userPresensiToday->presensidetail()->create(
                    [
                        'type' => 'out',
                        'long' => $request->long,
                        'lat' => $request->lat,
                        'gambar_presensi' => $this->uploadImage($gambar_presensi, $request->user()->name, 'presensi'),
                        'alamat' => $request->alamat
                    ]
                );

                return response()->json(
                    [
                        'message' => 'Success'
                    ],
                    Response::HTTP_CREATED
                );
            }

            return response()->json(
                [
                    'message' => 'Please do check in first',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * Get List Presences by User
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function riwayat(Request $request)
    {
        $request->validate(
            [
                'from' => ['required'],
                'to' => ['required'],
            ]
        );

        $history = $request->user()->presensi()->with('presensidetail')
            ->whereBetween(
                DB::raw('DATE(created_at)'),
                [
                    $request->from, $request->to
                ]
            )->get();

        return response()->json(
            [
                'message' => "list of presences by user",
                'data' => $history,
            ],
            Response::HTTP_OK
        );
    }
}
