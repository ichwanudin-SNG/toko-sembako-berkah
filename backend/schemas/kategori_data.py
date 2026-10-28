from pydantic import BaseModel, Field

class KategoriBuat(BaseModel):
    nama_kategori: str = Field(..., max_length=50)
    keterangan: str | None = None

class KategoriRespon(BaseModel):
    id: int
    nama_kategori: str
    keterangan: str | None
    class Config:
        from_attributes = True