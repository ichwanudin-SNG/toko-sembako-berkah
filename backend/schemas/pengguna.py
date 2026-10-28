from pydantic import BaseModel, Field, EmailStr
from typing import Optional
from datetime import datetime

class PenggunaBuat(BaseModel):
    username: str = Field(..., max_length=50)
    email: EmailStr
    kata_sandi: str = Field(..., min_length=6)
    nama_lengkap: Optional[str] = None
    peran: Optional[str] = "kasir"

class PenggunaMasuk(BaseModel):
    username: str
    kata_sandi: str

class PenggunaRespon(BaseModel):
    id: int
    username: str
    email: str
    nama_lengkap: Optional[str]
    peran: str
    dibuat_pada: Optional[datetime]
    
    class Config:
        from_attributes = True

class Token(BaseModel):
    akses_token: str
    jenis_token: str = "bearer"