from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from database import engine, Base
from routes import auth, kategori, produk, transaksi

Base.metadata.create_all(bind=engine)

app = FastAPI(
    title="Toko Sembako Berkah — Sistem Manajemen",
    version="1.0.0"
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.include_router(auth.router)
app.include_router(kategori.router)
app.include_router(produk.router)
app.include_router(transaksi.router)

@app.get("/")
def halaman_utama():
    return {
        "nama_aplikasi": "Toko Sembako Berkah",
        "versi": "1.0.0",
        "dokumentasi": "Buka http://127.0.0.1:8000/docs untuk uji coba API"
    }