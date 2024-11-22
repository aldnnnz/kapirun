<?php
// app/Http/Resources/RiwayatStokResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatStokResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'perubahan_stok' => $this->perubahan_stok,
            'tipe' => $this->tipe,
            'harga_satuan' => $this->harga_satuan,
            'created_at' => $this->created_at,
            'pengguna' => [
                'id' => $this->pengguna->id,
                'nama' => $this->pengguna->nama
            ]
        ];
    }
}
