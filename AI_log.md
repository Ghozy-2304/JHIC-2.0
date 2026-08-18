## 2026-08-18 - Fix Railway Container Crash (Application Failed to Respond)

### Sedang / Sudah Membuat
- Membuat file `entrypoint.sh` khusus agar script startup di `/etc/entrypoint.d/99-laravel.sh` tidak mengalami syntax error di Linux container.
- Mengamankan perintah `migrate` dan `cache` dengan fallback `|| echo` agar kegagalan awal database tidak menghentikan (crash) kontainer/Nginx.
- Menambahkan `ENV HTTP_PORT=8080` dan `EXPOSE 8080` pada `Dockerfile`.

### File
- `entrypoint.sh`
- `Dockerfile`
- `AI_log.md`

### Status
DONE

### Catatan
- Penyebab error "Application failed to respond":
  Perintah `echo` sebelumnya di `Dockerfile` menghasilkan baris string `\n` literal pada file shell script di container Alpine/Debian, menyebabkan script startup error/crash sebelum Nginx + PHP-FPM sempat menyala. Dengan memisahkan ke file `entrypoint.sh` dan di-COPY langsung, script dijamin valid dan aman.

### Pekerjaan Selanjutnya
- Melakukan Push perubahan ke GitHub.

