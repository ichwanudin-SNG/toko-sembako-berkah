from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from typing import List
from database import get_db
from models.produk import Produk
from models.kategori import Kategori
from schemas.produk import ProdukBuat, ProdukRespon, ProdukUbah
from routes.auth import ambil_pengguna_saat_ini

router = APIRouter(prefix="/api/produk", tags=["Produk"])


@router.get("/", response_model=List[ProdukRespon])
def semua_produk(
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    return db.query(Produk).all()


@router.post("/", response_model=ProdukRespon, status_code=201)
def tambah_produk(
    data: ProdukBuat,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    cek_kode = db.query(Produk).filter(Produk.kode_produk == data.kode_produk).first()
    if cek_kode:
        raise HTTPException(status_code=400, detail="Kode produk sudah ada")
    
    cek_kategori = db.query(Kategori).get(data.kategori_id)
    if not cek_kategori:
        raise HTTPException(status_code=404, detail="Kategori tidak ditemukan")
    
    baru = Produk(**data.model_dump())
    db.add(baru)
    db.commit()
    db.refresh(baru)
    return baru


@router.get("/{produk_id}", response_model=ProdukRespon)
def satu_produk(
    produk_id: int,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    p = db.query(Produk).get(produk_id)
    if not p:
        raise HTTPException(status_code=404, detail="Produk tidak ditemukan")
    return p


@router.put("/{produk_id}", response_model=ProdukRespon)
def ubah_produk(
    produk_id: int,
    data: ProdukUbah,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    p = db.query(Produk).get(produk_id)
    if not p:
        raise HTTPException(status_code=404, detail="Produk tidak ditemukan")
    
    if data.kategori_id:
        cek_kategori = db.query(Kategori).get(data.kategori_id)
        if not cek_kategori:
            raise HTTPException(status_code=404, detail="Kategori tidak ditemukan")
    
    for kunci, nilai in data.model_dump(exclude_unset=True).items():
        setattr(p, kunci, nilai)
    
    db.commit()
    db.refresh(p)
    return p


@router.delete("/{produk_id}", status_code=204)
def hapus_produk(
    produk_id: int,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    p = db.query(Produk).get(produk_id)
    if not p:
        raise HTTPException(status_code=404, detail="Produk tidak ditemukan")
    db.delete(p)
    db.commit()