// Alamat API
const API_DASAR = "http://127.0.0.1:8000";

// Ambil token dari penyimpanan lokal
function ambilToken() {
    return localStorage.getItem("token");
}

// Simpan token
function simpanToken(token) {
    localStorage.setItem("token", token);
}

// Hapus token
function hapusToken() {
    localStorage.removeItem("token");
}

// Cek status masuk
function sudahMasuk() {
    return !!ambilToken();
}

// Ambil data profil
async function ambilProfil() {
    if (!sudahMasuk()) return;
    try {
        const res = await fetch(`${API_DASAR}/api/auth/profil`, {
            headers: {
                "Authorization": `Bearer ${ambilToken()}`
            }
        });
        if (res.ok) {
            const data = await res.json();
            const elNama = document.getElementById("namaPengguna");
            const elEmail = document.getElementById("emailPengguna");
            const elPeran = document.getElementById("peranPengguna");
            const elTgl = document.getElementById("tanggalBergabung");
            
            if (elNama) elNama.textContent = data.username;
            if (elEmail) elEmail.textContent = data.email;
            if (elPeran) elPeran.textContent = data.peran;
            if (elTgl) elTgl.textContent = data.dibuat_pada ? new Date(data.dibuat_pada).toLocaleDateString("id-ID") : "-";
        }
    } catch (e) {
        console.log("Gagal ambil profil:", e);
    }
}

// Keluar
const tombolKeluar = document.getElementById("tombolKeluar");
if (tombolKeluar) {
    tombolKeluar.addEventListener("click", (e) => {
        e.preventDefault();
        hapusToken();
        window.location.href = "login.html";
    });
}

// Jalankan saat halaman profil dibuka
if (document.getElementById("namaPengguna")) {
    ambilProfil();
}

// Form Masuk
const formMasuk = document.querySelector("form[action*='masuk']") || document.querySelector("form");
if (formMasuk && window.location.pathname.includes("login")) {
    formMasuk.addEventListener("submit", async (e) => {
        e.preventDefault();
        const username = formMasuk.querySelector("input[type='text']").value;
        const kata_sandi = formMasuk.querySelector("input[type='password']").value;
        
        try {
            const res = await fetch(`${API_DASAR}/api/auth/masuk`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ username, kata_sandi })
            });
            const data = await res.json();
            if (res.ok && data.akses_token) {
                simpanToken(data.akses_token);
                alert("Berhasil masuk!");
                window.location.href = "index.html";
            } else {
                alert(data.detail || "Gagal masuk");
            }
        } catch (err) {
            alert("Tidak terhubung ke server");
        }
    });
}

// Form Daftar
if (window.location.pathname.includes("daftar")) {
    const formDaftar = document.querySelector("form");
    if (formDaftar) {
        formDaftar.addEventListener("submit", async (e) => {
            e.preventDefault();
            const inputs = formDaftar.querySelectorAll("input");
            const nama_lengkap = inputs[0].value;
            const username = inputs[1].value;
            const email = inputs[2].value;
            const kata_sandi = inputs[3].value;
            
            try {
                const res = await fetch(`${API_DASAR}/api/auth/daftar`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ username, email, kata_sandi, nama_lengkap, peran: "kasir" })
                });
                const data = await res.json();
                if (res.ok) {
                    alert("Berhasil daftar! Silakan masuk.");
                    window.location.href = "login.html";
                } else {
                    alert(data.detail || "Gagal daftar");
                }
            } catch (err) {
                alert("Tidak terhubung ke server");
            }
        });
    }
}

console.log("✅ Aplikasi Toko Sembako Berkah siap!");