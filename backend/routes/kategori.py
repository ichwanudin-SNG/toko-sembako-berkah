from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from typing import List
from database import get_db

# Sesuaikan dengan nama berkas yang dipakai
from models.kategori_data import Kategori
from schemas.kategori_data import KategoriBuat, KategoriRespon
from routes.auth import ambil_pengguna_saat_ini

router = APIRouter(prefix="/api/kategori", tags=["Kategori"])


@router.get("/", response_model=List[KategoriRespon])
def semua_kategori(
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    """Ambil semua kategori barang"""
    return db.query(Kategori).all()


@router.post("/", response_model=KategoriRespon, status_code=201)
def tambah_kategori(
    data: KategoriBuat,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    """Tambah kategori baru"""
    # Cek nama sudah ada atau belum
    cek = db.query(Kategori).filter(Kategori.nama_kategori == data.nama_kategori).first()
    if cek:
        raise HTTPException(400, "Kategori dengan nama ini sudah ada")

    kategori_baru = Kategori(
        nama_kategori=data.nama_kategori,
        keterangan=data.keterangan
    )
    db.add(kategori_baru)
    db.commit()
    db.refresh(kategori_baru)
    return kategori_baru


@router.get("/{kategori_id}", response_model=KategoriRespon)
def satu_kategori(
    kategori_id: int,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    """Ambil satu kategori berdasarkan ID"""
    kategori = db.query(Kategori).get(kategori_id)
    if not kategori:
        raise HTTPException(404, "Kategori tidak ditemukan")
    return kategori


@router.put("/{kategori_id}", response_model=KategoriRespon)
def ubah_kategori(
    kategori_id: int,
    data: KategoriBuat,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    """Ubah data kategori"""
    kategori = db.query(Kategori).get(kategori_id)
    if not kategori:
        raise HTTPException(404, "Kategori tidak ditemukan")

    kategori.nama_kategori = data.nama_kategori
    kategori.keterangan = data.keterangan
    db.commit()
    db.refresh(kategori)
    return kategori


@router.delete("/{kategori_id}", status_code=204)
def hapus_kategori(
    kategori_id: int,
    db: Session = Depends(get_db),
    pengguna_saat_ini = Depends(ambil_pengguna_saat_ini)
):
    """Hapus kategori"""
    kategori = db.query(Kategori).get(kategori_id)
    if not kategori:
        raise HTTPException(404, "Kategori tidak ditemukan")

    db.delete(kategori)
    db.commit()