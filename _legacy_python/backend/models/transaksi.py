from sqlalchemy import Column, Integer, String, ForeignKey, DECIMAL, TIMESTAMP, func
from sqlalchemy.orm import relationship
from database import Base

class Transaksi(Base):
    __tablename__ = "transaksi"
    id = Column(Integer, primary_key=True)
    no_transaksi = Column(String(30), unique=True, nullable=False)
    pengguna_id = Column(Integer, ForeignKey("users.id"), nullable=False)
    nama_pembeli = Column(String(100))
    total_harga = Column(DECIMAL(12,2), default=0)
    bayar = Column(DECIMAL(12,2), default=0)
    kembalian = Column(DECIMAL(12,2), default=0)
    tanggal_transaksi = Column(TIMESTAMP, server_default=func.now())
    petugas = relationship("User", back_populates="transaksi")
    detail = relationship("DetailTransaksi", back_populates="transaksi", cascade="all, delete")