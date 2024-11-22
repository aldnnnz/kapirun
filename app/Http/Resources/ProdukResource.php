<?php
// app/Http/Resources/ProdukResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'gambar' => $this->gambar ? asset('storage/' . $this->gambar) : null,
            'kategori' => new KategoriResource($this->whenLoaded('kategori')),
            'riwayat_stok' => RiwayatStokResource::collection($this->whenLoaded('riwayatStok')),
        ];
    }
}
