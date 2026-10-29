from sqlalchemy import Column, Integer, ForeignKey, DECIMAL
from sqlalchemy.orm import relationship
from database import Base

class DetailTransaksi(Base):
    __tablename__ = "detail_transaksi"
    id = Column(Integer, primary_key=True)
    transaksi_id = Column(Integer, ForeignKey("transaksi.id"), nullable=False)
    produk_id = Column(Integer, ForeignKey("produk.id"), nullable=False)
    jumlah = Column(Integer, nullable=False)
    harga_saat_jual = Column(DECIMAL(12,2), nullable=False)
    subtotal = Column(DECIMAL(12,2), nullable=False)
    transaksi = relationship("Transaksi", back_populates="detail")
    produk = relationship("Produk")