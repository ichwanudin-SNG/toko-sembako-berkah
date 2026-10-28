from sqlalchemy import Column, Integer, String, ForeignKey, DECIMAL, TIMESTAMP, func
from sqlalchemy.orm import relationship
from database import Base

class Produk(Base):
    __tablename__ = "produk"
    id = Column(Integer, primary_key=True)
    kode_produk = Column(String(20), unique=True, nullable=False)
    nama_produk = Column(String(100), nullable=False)
    kategori_id = Column(Integer, ForeignKey("kategori.id"), nullable=False)
    stok = Column(Integer, nullable=False, default=0)
    harga_beli = Column(DECIMAL(12,2), nullable=False)
    harga_jual = Column(DECIMAL(12,2), nullable=False)
    satuan = Column(String(20), default="pcs")
    dibuat_pada = Column(TIMESTAMP, server_default=func.now())
    kategori = relationship("Kategori", back_populates="produk")