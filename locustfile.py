from locust import HttpUser, task, between
import re

class PenggunaSiLacak(HttpUser):
    wait_time = between(1, 3)

    def on_start(self):
        """Ambil CSRF token, lalu login sekali di awal sesi"""
        # 1. GET halaman login dulu untuk dapat token + cookie session
        resp = self.client.get("/login")
        csrf_token = self.extract_csrf_token(resp.text)

        if not csrf_token:
            print("Gagal ambil CSRF token, cek apakah /login pakai form Blade dengan @csrf")
            return

        # 2. POST login dengan menyertakan token
        response = self.client.post("/login", {
            "_token": csrf_token,
            "email": "admin@silacak.test",
            "password": "password",
        })

        if response.status_code not in (200, 302):
            print(f"Login gagal: {response.status_code} - {response.text[:200]}")

    def extract_csrf_token(self, html):
        """Cari token dari meta tag atau hidden input"""
        match = re.search(r'name="csrf-token" content="([^"]+)"', html)
        if not match:
            match = re.search(r'name="_token" value="([^"]+)"', html)
        return match.group(1) if match else None

    @task(5)
    def lihat_dashboard(self):
        self.client.get("/dashboard", name="/dashboard")

    @task(3)
    def lihat_daftar_resi(self):
        self.client.get("/resi", name="/resi")

    @task(2)
    def lacak_resi(self):
        self.client.get("/lacak?nomor_resi=SLC-20260929-0001", name="/lacak")

    @task(1)
    def cek_tarif(self):
        self.client.get("/tarif", name="/tarif")

    @task(1)
    def filter_resi(self):
        self.client.get("/resi?status=transit", name="/resi?status=")