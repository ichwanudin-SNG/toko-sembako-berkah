from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from datetime import datetime, timedelta
from database import get_db
from models.pengguna import Pengguna
from schemas.pengguna import PenggunaBuat, PenggunaMasuk, PenggunaRespon, Token
from utils.security import buat_kata_sandi_hash, verifikasi_kata_sandi, buat_token_akses, verifikasi_token

router = APIRouter(prefix="/api/auth", tags=["Autentikasi"])

SECRET_KEY = "toko-sembako-berkah-kunci-rahasia-2026"
ALGORITMA = "HS256"
WAKTU_KADALUARSA_JAM = 8


async def ambil_pengguna_saat_ini(token: str = Depends(verifikasi_token), db: Session = Depends(get_db)):
    if not hasattr(token, "username"):
        raise HTTPException(status_code=401, detail="Token tidak sah")
    pengguna = db.query(Pengguna).filter(Pengguna.username == token.username).first()
    if not pengguna:
        raise HTTPException(status_code=404, detail="Pengguna tidak ditemukan")
    return pengguna


@router.post("/daftar", response_model=PenggunaRespon, status_code=status.HTTP_201_CREATED)
def daftar(data: PenggunaBuat, db: Session = Depends(get_db)):
    cek_user = db.query(Pengguna).filter(Pengguna.username == data.username).first()
    if cek_user:
        raise HTTPException(status_code=400, detail="Nama pengguna sudah dipakai")
    
    cek_email = db.query(Pengguna).filter(Pengguna.email == data.email).first()
    if cek_email:
        raise HTTPException(status_code=400, detail="Email sudah terdaftar")
    
    pengguna_baru = Pengguna(
        username=data.username,
        email=data.email,
        password_hash=buat_kata_sandi_hash(data.kata_sandi),
        nama_lengkap=data.nama_lengkap,
        peran=data.peran,
        dibuat_pada=datetime.now()
    )
    db.add(pengguna_baru)
    db.commit()
    db.refresh(pengguna_baru)
    return pengguna_baru


@router.post("/masuk", response_model=Token)
def masuk(data: PenggunaMasuk, db: Session = Depends(get_db)):
    pengguna = db.query(Pengguna).filter(Pengguna.username == data.username).first()
    if not pengguna or not verifikasi_kata_sandi(data.kata_sandi, pengguna.password_hash):
        raise HTTPException(status_code=401, detail="Nama pengguna atau kata sandi salah")
    
    waktu_kadaluwarsa = timedelta(hours=WAKTU_KADALUARSA_JAM)
    token_akses = buat_token_akses(
        data={"sub": pengguna.username, "peran": pengguna.peran},
        kunci=SECRET_KEY,
        algoritma=ALGORITMA,
        kadaluwarsa=waktu_kadaluwarsa
    )
    return {"akses_token": token_akses, "jenis_token": "bearer"}


@router.get("/profil", response_model=PenggunaRespon)
def profil(pengguna_saat_ini: Pengguna = Depends(ambil_pengguna_saat_ini)):
    return pengguna_saat_ini