<?php

namespace App\Http\Controllers\API\V1;
use App\Models\Pengguna;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PenggunaResource;

class JenisPenggunaController extends Controller
{
    public function __invoke(Request $request, Pengguna $pengguna)
    {
        $pengguna->jenis_pengguna = $request->jenis_pengguna;
        $pengguna->save();

        $pengguna_rsc = PenggunaResource::make($pengguna)->toArray($request);
        $pengguna_rsc['jenis_pengguna'] = $request->jenis_pengguna;
        return response()->json(["data"=>$pengguna_rsc]);
    }
}
