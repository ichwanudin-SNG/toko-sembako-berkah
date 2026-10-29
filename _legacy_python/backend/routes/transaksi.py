from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from datetime import datetime
from database import get_db
from models.transaksi import Transaksi
from models.detail_transaksi import DetailTransaksi
from models.produk import Produk
from schemas.transaksi import TransaksiBuat, TransaksiRespon
from routes.auth import ambil_pengguna_saat_ini

router = APIRouter(prefix="/api/transaksi", tags=["Transaksi"])


def buat_nomor_transaksi(db: Session):
    waktu = datetime.now()
    awalan = waktu.strftime("%Y%m%d")
    hitung = db.query(Transaksi).filter(
        Transaksi.no_transaksi.like(f"{awalan}%")
    ).count() + 1
    return f"{awalan}-{hitung:04d}"


@router.get("/", response_model=list[TransaksiRespon])
def semua_transaksi(
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    return db.query(Transaksi).all()


@router.post("/", response_model=TransaksiRespon, status_code=201)
def buat_transaksi(
    data: TransaksiBuat,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    no_trans = buat_nomor_transaksi(db)
    total = 0
    daftar_detail = []
    
    for barang in data.daftar_barang:
        produk = db.query(Produk).get(barang.produk_id)
        if not produk:
            raise HTTPException(status_code=404, detail=f"Produk ID {barang.produk_id} tidak ditemukan")
        if produk.stok < barang.jumlah:
            raise HTTPException(status_code=400, detail=f"Stok {produk.nama_produk} kurang")
        
        subtotal = produk.harga_jual * barang.jumlah
        total += subtotal
        daftar_detail.append({
            "produk_id": barang.produk_id,
            "jumlah": barang.jumlah,
            "harga_saat_jual": produk.harga_jual,
            "subtotal": subtotal
        })
        produk.stok -= barang.jumlah
    
    if data.bayar < total:
        raise HTTPException(status_code=400, detail="Uang bayar kurang dari total")
    
    kembalian = data.bayar - total
    
    transaksi_baru = Transaksi(
        no_transaksi=no_trans,
        pengguna_id=pengguna_saat_ini.id,
        nama_pembeli=data.nama_pembeli,
        total_harga=total,
        bayar=data.bayar,
        kembalian=kembalian
    )
    db.add(transaksi_baru)
    db.flush()
    
    for d in daftar_detail:
        db.add(DetailTransaksi(transaksi_id=transaksi_baru.id, **d))
    
    db.commit()
    db.refresh(transaksi_baru)
    return transaksi_baru


@router.get("/{transaksi_id}", response_model=TransaksiRespon)
def satu_transaksi(
    transaksi_id: int,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    t = db.query(Transaksi).get(transaksi_id)
    if not t:
        raise HTTPException(status_code=404, detail="Transaksi tidak ditemukan")
    return t