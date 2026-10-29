from pydantic import BaseModel
from decimal import Decimal

class DetailTransaksiBuat(BaseModel):
    transaksi_id: int
    produk_id: int
    jumlah: int
    harga_saat_jual: Decimal
    subtotal: Decimal

class DetailTransaksiRespon(BaseModel):
    id: int
    transaksi_id: int
    produk_id: int
    jumlah: int
    harga_saat_jual: Decimal
    subtotal: Decimal
    
    class Config:
        from_attributes = True