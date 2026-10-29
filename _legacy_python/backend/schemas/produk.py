from pydantic import BaseModel, Field
from typing import Optional
from decimal import Decimal

class ProdukBuat(BaseModel):
    kode_produk: str = Field(..., max_length=20)
    nama_produk: str = Field(..., max_length=100)
    kategori_id: int
    stok: int = 0
    harga_beli: Decimal
    harga_jual: Decimal
    satuan: str = "pcs"

class ProdukUbah(BaseModel):
    kode_produk: Optional[str] = Field(None, max_length=20)
    nama_produk: Optional[str] = Field(None, max_length=100)
    kategori_id: Optional[int] = None
    stok: Optional[int] = None
    harga_beli: Optional[Decimal] = None
    harga_jual: Optional[Decimal] = None
    satuan: Optional[str] = None

class ProdukRespon(BaseModel):
    id: int
    kode_produk: str
    nama_produk: str
    kategori_id: int
    stok: int
    harga_beli: Decimal
    harga_jual: Decimal
    satuan: str
    
    class Config:
        from_attributes = True