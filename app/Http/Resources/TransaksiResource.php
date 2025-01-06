<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nomor_nota' => $this->nomor_nota,
            'total' => $this->total,
            'jumlah_bayar' => $this->jumlah_bayar,
            'kembalian' => $this->kembalian,
            'kasir' => $this->kasir->nama,
            'pelanggan' => $this->pelanggan?->nama_pelanggan,
            'items' => DetailTransactionResource::collection($this->detailTransaksi),
            'created_at' => $this->created_at
        ];
    }
}

class DetailTransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'produk' => $this->produk->nama_produk,
            'jumlah' => $this->jumlah,
            'harga_satuan' => $this->harga_satuan,
            'subtotal' => $this->jumlah * $this->harga_satuan
        ];
    }
}