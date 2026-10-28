from sqlalchemy import Column, Integer, String, Text
from sqlalchemy.orm import relationship
from database import Base

class Kategori(Base):
    __tablename__ = "kategori"
    id = Column(Integer, primary_key=True)
    nama_kategori = Column(String(50), nullable=False)
    keterangan = Column(Text)
    produk = relationship("Produk", back_populates="kategori", cascade="all, delete")