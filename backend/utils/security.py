from datetime import datetime, timedelta
from typing import Optional
from jose import JWTError, jwt
from passlib.context import CryptContext
import os
from dotenv import load_dotenv

load_dotenv()

pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")
SECRET_KEY = os.getenv("SECRET_KEY")
ALGORITHM = os.getenv("ALGORITHM", "HS256")
ACCESS_TOKEN_EXPIRE_MINUTES = int(os.getenv("ACCESS_TOKEN_EXPIRE_MINUTES", 480))

def verifikasi_kata_sandi(plain: str, hashed: str) -> bool:
    return pwd_context.verify(plain, hashed)

def buat_kata_sandi_terenkripsi(sandi: str) -> str:
    return pwd_context.hash(sandi)

def buat_token(data: dict, lama: Optional[timedelta] = None):
    salin = data.copy()
    kadaluwarsa = datetime.utcnow() + (lama or timedelta(minutes=ACCESS_TOKEN_EXPIRE_MINUTES))
    salin.update({"exp": kadaluwarsa})
    return jwt.encode(salin, SECRET_KEY, algorithm=ALGORITHM)