from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from typing import List
from database import get_db
from models.kategori import Kategori
from schemas.kategori import KategoriBuat, KategoriRespon
from routes.auth import ambil_pengguna_saat_ini

router = APIRouter(prefix="/api/kategori", tags=["Kategori"])


@router.get("/", response_model=List[KategoriRespon])
def semua_kategori(
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    return db.query(Kategori).all()


@router.post("/", response_model=KategoriRespon, status_code=201)
def tambah_kategori(
    data: KategoriBuat,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    cek = db.query(Kategori).filter(Kategori.nama_kategori == data.nama_kategori).first()
    if cek:
        raise HTTPException(status_code=400, detail="Kategori dengan nama ini sudah ada")
    
    baru = Kategori(nama_kategori=data.nama_kategori, keterangan=data.keterangan)
    db.add(baru)
    db.commit()
    db.refresh(baru)
    return baru


@router.get("/{kategori_id}", response_model=KategoriRespon)
def satu_kategori(
    kategori_id: int,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    ket = db.query(Kategori).get(kategori_id)
    if not ket:
        raise HTTPException(status_code=404, detail="Kategori tidak ditemukan")
    return ket


@router.put("/{kategori_id}", response_model=KategoriRespon)
def ubah_kategori(
    kategori_id: int,
    data: KategoriBuat,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    ket = db.query(Kategori).get(kategori_id)
    if not ket:
        raise HTTPException(status_code=404, detail="Kategori tidak ditemukan")
    
    ket.nama_kategori = data.nama_kategori
    ket.keterangan = data.keterangan
    db.commit()
    db.refresh(ket)
    return ket


@router.delete("/{kategori_id}", status_code=204)
def hapus_kategori(
    kategori_id: int,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    ket = db.query(Kategori).get(kategori_id)
    if not ket:
        raise HTTPException(status_code=404, detail="Kategori tidak ditemukan")
    db.delete(ket)
    db.commit()