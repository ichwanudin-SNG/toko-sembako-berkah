from pydantic import BaseModel, EmailStr, Field

class UserDaftar(BaseModel):
    username: str = Field(..., min_length=3, max_length=50)
    email: EmailStr
    password: str = Field(..., min_length=6)
    nama_lengkap: str | None = None
    peran: str = "kasir"

class UserRespon(BaseModel):
    id: int
    username: str
    email: str
    nama_lengkap: str | None
    peran: str
    class Config:
        from_attributes = True

class Token(BaseModel):
    access_token: str
    token_type: str