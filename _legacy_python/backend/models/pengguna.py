from sqlalchemy import Column, Integer, String, Text, Enum, TIMESTAMP
from sqlalchemy.orm import relationship
from database import Base
import enum

class PeranEnum(str, enum.Enum):
    pemilik = "pemilik"
    kasir = "kasir"

class Pengguna(Base):
    __tablename__ = "users"
    
    id = Column(Integer, primary_key=True, autoincrement=True)
    username = Column(String(50), unique=True, nullable=False)
    email = Column(String(100), unique=True, nullable=False)
    password_hash = Column(String(255), nullable=False)
    nama_lengkap = Column(String(100))
    peran = Column(Enum("pemilik", "kasir"), default="kasir")
    dibuat_pada = Column(TIMESTAMP, server_default=None)
    
    daftar_transaksi = relationship("Transaksi", back_populates="pengguna", cascade="all, delete")