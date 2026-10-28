from pydantic import BaseModel
from typing import Optional, List
from decimal import Decimal
from datetime import datetime

class DetailTransaksiSementara(BaseModel):
    produk_id: int
    jumlah: int

class TransaksiBuat(BaseModel):
    nama_pembeli: Optional[str] = None
    daftar_barang: List[DetailTransaksiSementara]
    bayar: Decimal

class TransaksiUbah(BaseModel):
    nama_pembeli: Optional[str] = None
    daftar_barang: Optional[List[DetailTransaksiSementara]] = None
    bayar: Optional[Decimal] = None

class TransaksiRespon(BaseModel):
    id: int
    no_transaksi: str
    pengguna_id: int
    nama_pembeli: Optional[str]
    total_harga: Decimal
    bayar: Decimal
    kembalian: Decimal
    tanggal_transaksi: datetime
    
    class Config:
        from_attributes = True