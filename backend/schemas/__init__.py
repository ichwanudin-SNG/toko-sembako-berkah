from fastapi import APIRouter, Depends, HTTPException, status
from fastapi.security import OAuth2PasswordBearer, OAuth2PasswordRequestForm
from jose import JWTError, jwt
from datetime import timedelta
from sqlalchemy.orm import Session
from database import get_db
from models.user import User
from schemas.user import UserDaftar, UserRespon, Token
from utils.security import verifikasi_kata_sandi, buat_kata_sandi_terenkripsi, buat_token
import os

router = APIRouter(prefix="/api/auth", tags=["Autentikasi"])

SECRET_KEY = os.getenv("SECRET_KEY")
ALGORITHM = os.getenv("ALGORITHM", "HS256")
oauth2_scheme = OAuth2PasswordBearer(tokenUrl="api/auth/login")

async def ambil_pengguna_saat_ini(token: str = Depends(oauth2_scheme), db: Session = Depends(get_db)):
    gagal = HTTPException(status.HTTP_401_UNAUTHORIZED, "Tidak dapat diverifikasi", headers={"WWW-Authenticate": "Bearer"})
    try:
        data = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        id_pengguna = int(data.get("sub"))
    except:
        raise gagal
    pengguna = db.query(User).get(id_pengguna)
    if not pengguna: raise gagal
    return pengguna

@router.post("/daftar", response_model=UserRespon, status_code=201)
def daftar(data: UserDaftar, db: Session = Depends(get_db)):
    if db.query(User).filter(User.username == data.username).first():
        raise HTTPException(400, "Nama pengguna sudah dipakai")
    if db.query(User).filter(User.email == data.email).first():
        raise HTTPException(400, "Email sudah terdaftar")
    pengguna = User(
        username=data.username,
        email=data.email,
        nama_lengkap=data.nama_lengkap,
        peran=data.peran,
        password_hash=buat_kata_sandi_terenkripsi(data.password)
    )
    db.add(pengguna)
    db.commit()
    db.refresh(pengguna)
    return pengguna

@router.post("/login", response_model=Token)
def masuk(form: OAuth2PasswordRequestForm = Depends(), db: Session = Depends(get_db)):
    pengguna = db.query(User).filter(User.email == form.username).first()
    if not pengguna or not verifikasi_kata_sandi(form.password, pengguna.password_hash):
        raise HTTPException(401, "Email atau kata sandi salah")
    token = buat_token({"sub": str(pengguna.id)}, timedelta(minutes=480))
    return {"access_token": token, "token_type": "bearer"}