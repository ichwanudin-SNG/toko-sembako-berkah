from datetime import datetime, timedelta
from typing import Optional
from jose import JWTError, jwt
from passlib.context import CryptContext
from fastapi import Depends, HTTPException, status
from fastapi.security import OAuth2PasswordBearer

konteks_sandi = CryptContext(schemes=["bcrypt"], deprecated="auto")
skema_oauth2 = OAuth2PasswordBearer(tokenUrl="api/auth/masuk")

def buat_kata_sandi_hash(sandi: str) -> str:
    return konteks_sandi.hash(sandi)

def verifikasi_kata_sandi(sandi_masuk: str, sandi_hash: str) -> bool:
    return konteks_sandi.verify(sandi_masuk, sandi_hash)

def buat_token_akses(data: dict, kunci: str, algoritma: str, kadaluwarsa: Optional[timedelta] = None) -> str:
    muat = data.copy()
    if kadaluwarsa:
        waktu_akhir = datetime.utcnow() + kadaluwarsa
    else:
        waktu_akhir = datetime.utcnow() + timedelta(minutes=30)
    muat.update({"exp": waktu_akhir})
    return jwt.encode(muat, kunci, algorithm=algoritma)

async def verifikasi_token(token: str = Depends(skema_oauth2)):
    kredensial_salah = HTTPException(
        status_code=status.HTTP_401_UNAUTHORIZED,
        detail="Tidak dapat memvalidasi kredensial",
        headers={"WWW-Authenticate": "Bearer"},
    )
    try:
        muat = jwt.decode(token, "toko-sembako-berkah-kunci-rahasia-2026", algorithms=["HS256"])
        username: str = muat.get("sub")
        if username is None:
            raise kredensial_salah
        class TokenData:
            def __init__(self, username):
                self.username = username
        return TokenData(username=username)
    except JWTError:
        raise kredensial_salah