from sqlalchemy import create_engine
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker
import os
from dotenv import load_dotenv

# Muat berkas .env secara eksplisit
load_dotenv(dotenv_path=os.path.join(os.path.dirname(__file__), ".env"))

# Baca nilai dengan nilai bawaan agar tidak kosong
DB_HOST = os.getenv("DB_HOST", "localhost")
DB_PORT = os.getenv("DB_PORT", "3306")  # ← kalau kosong otomatis pakai 3306
DB_NAME = os.getenv("DB_NAME", "toko_sembako_berkah")
DB_USER = os.getenv("DB_USER", "root")
DB_PASSWORD = os.getenv("DB_PASSWORD", "")

# Susun alamat koneksi
DATABASE_URL = (
    f"mysql+pymysql://{DB_USER}:"
    f"{DB_PASSWORD}@"
    f"{DB_HOST}:"
    f"{DB_PORT}/"
    f"{DB_NAME}"
)

engine = create_engine(DATABASE_URL)
SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)
Base = declarative_base()

def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()