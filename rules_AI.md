# AI AGENT RULES

File ini berisi aturan yang wajib dipatuhi AI Agent saat mengerjakan project.

---

## 1. PROJECT STACK

* Frontend: Laravel
* Backend: Laravel
* Styling: Tailwind CSS
* Database: PostgreSQL (PgSQL)
* Design reference: Figma melalui MCP

AI wajib menyesuaikan implementasi dengan struktur dan teknologi yang sudah digunakan project.

---

# 2. ATURAN UTAMA

### 2.1 Tailwind CSS

Wajib menggunakan **Tailwind CSS** untuk styling.

Jangan menggunakan CSS biasa jika kebutuhan tersebut masih dapat dilakukan menggunakan Tailwind.

Jangan membuat semau anda untuk bagian front-end atau tampilan, anda diminta untuk mengikuti apa yang ada di Figma/MCP. tanpa merubahnya sedikitpun.

Jangan menyetuh code lain yang tidak di perintah kalaupun berhubungan bilang dulu ke saya
PERHATIKAN dengan seksama ukuran component, padding, margin dll dengan ukuran yang sangat pas.Jangan pernah merubah ukuran component, padding, margin dll dengan ukuran yang sedikitpun berbeda dengan design Figma/MCP


CSS custom hanya diperbolehkan apabila:

* Tailwind benar-benar tidak dapat menangani kebutuhan tersebut dengan baik.
* Dibutuhkan oleh library/plugin tertentu.
* Ada kebutuhan teknis khusus yang memang tidak praktis jika menggunakan Tailwind.

Jika menggunakan CSS custom, gunakan seminimal mungkin.

---

### 2.2 Responsive Design

Semua halaman dan component **WAJIB responsive**.

Design responsive harus mengikuti referensi yang diberikan melalui **Figma/MCP**.

Perhatikan perbedaan:

* Mobile
* Tablet
* Desktop

Jangan hanya membuat tampilan desktop lalu mengandalkan browser untuk mengecilkannya.

Responsive layout harus dibuat berdasarkan design/reference yang diberikan.

---

# 3. FIGMA / DESIGN ACCURACY

Design dari Figma yang diberikan melalui MCP merupakan **referensi utama untuk tampilan UI**.

AI wajib memperhatikan detail sekecil mungkin, termasuk:

* Layout
* Positioning
* Width
* Height
* Spacing
* Padding
* Margin
* Gap
* Typography
* Font size
* Font weight
* Line height
* Border radius
* Border
* Shadow
* Warna
* Icon
* Image
* Alignment
* Responsive behavior
* Component state

### Spacing

Jarak antara element harus dibuat semirip mungkin dengan design Figma.

Perhatikan secara khusus:

```text
padding
margin
gap
space-x
space-y
```

Jangan menggunakan nilai spacing secara asal hanya karena terlihat "cukup mirip".

Jika nilai pada design dapat diketahui melalui Figma/MCP, gunakan nilai tersebut atau nilai Tailwind yang paling mendekati.

---

# 4. COMPONENT

Jika memungkinkan, gunakan component yang **reusable**.

Contoh component yang dapat dibuat reusable:

```text
Button
Input
Card
Navbar
Footer
Modal
Badge
Alert
Table
Form
```

Jika sebuah component memiliki struktur dan fungsi yang sama di beberapa tempat, prioritaskan penggunaan kembali component tersebut daripada membuat component baru yang duplicate.

Namun jangan memaksakan componentization jika justru membuat project kecil menjadi terlalu kompleks.

---

# 5. CODE CHANGES

AI diperbolehkan mengubah kode existing jika perubahan tersebut diperlukan untuk menyelesaikan task.

Namun:

> Jangan membuat perubahan yang menyebabkan error atau masalah baru.

Sebelum mengubah kode:

1. Pahami kode yang sedang digunakan.
2. Periksa hubungan dengan component/file lain.
3. Perkirakan dampak perubahan.
4. Lakukan perubahan seminimal mungkin.

Setelah perubahan:

1. Periksa kembali kode.
2. Pastikan tidak ada syntax error.
3. Pastikan fitur existing tidak rusak.
4. Test bagian yang berhubungan dengan perubahan.

Jangan melakukan refactor besar jika tidak diperlukan oleh task.

---

# 6. JANGAN MENGUBAH TANPA ALASAN

Jangan mengubah:

* Design yang tidak diminta.
* Component yang tidak berkaitan dengan task.
* Struktur folder tanpa alasan.
* Dependency tanpa alasan.
* Database schema tanpa kebutuhan.
* Logic existing yang tidak berkaitan dengan task.

Jika perubahan tersebut diperlukan untuk memperbaiki masalah, perubahan diperbolehkan.

---

# 7. DATABASE

Database menggunakan:

**PostgreSQL (PgSQL)**

AI harus memperhatikan compatibility dengan PostgreSQL.

Sebelum mengubah database:

1. Periksa migration yang sudah ada.
2. Periksa model.
3. Periksa relationship.
4. Periksa kode yang menggunakan data tersebut.

Jangan melakukan perubahan database yang berisiko tanpa memastikan dampaknya.

---

# 8. LOGGING / MEMORY

AI **WAJIB** mengisi dan memperbarui:

```text
AI_Log.md
```

setelah mengerjakan task yang menghasilkan perubahan pada project.

File `AI_Log.md` digunakan sebagai catatan pekerjaan Agent sehingga Agent pada percakapan berikutnya dapat memahami pekerjaan sebelumnya.

---

# 9. FORMAT AI_Log.md

saat ada pekerjaan baru buat catatan baru di bawah log terakhir jadi bukan di ganti log awalnya
Setiap pekerjaan harus dicatat dengan format berikut:

```markdown
## [Tanggal] - [Nama Pekerjaan]

### Sedang / Sudah Membuat
Jelaskan apa yang sedang atau sudah dibuat.

### File
- `path/file1`
- `path/file2`

### Status
IN PROGRESS / DONE / BLOCKED

### Catatan
- Catatan penting mengenai pekerjaan.
- Masalah yang ditemukan.
- Hal yang perlu diperhatikan.
- Keputusan design atau coding yang dibuat.

### Pekerjaan Selanjutnya
- Pekerjaan yang disarankan berikutnya.
- Perbaikan yang masih diperlukan.
- Task yang sebaiknya dikerjakan setelah ini.
```

---

# 10. CONTOH AI_Log.md

```markdown
## 2026-08-15 - Membuat Navbar

### Sedang / Sudah Membuat
Membuat Navbar berdasarkan design Figma.
Navbar dibuat responsive untuk desktop dan mobile.

### File
- `resources/views/components/navbar.blade.php`
- `resources/views/layouts/app.blade.php`
- `AI_Log.md`

### Status
DONE

### Catatan
- Menggunakan Tailwind CSS.
- Spacing disesuaikan dengan design Figma.
- Navbar dibuat sebagai reusable component.
- Responsive mobile sudah diperhatikan.
- Tidak menggunakan CSS custom.

### Pekerjaan Selanjutnya
- Membuat Hero Section berdasarkan Figma.
- Memastikan spacing Hero Section konsisten dengan Navbar.
```

---

# 11. MEMBACA LOG SEBELUM BEKERJA

Sebelum memulai task baru, AI harus membaca:

```text
rules_AI.md
AI_Log.md
```

Kemudian periksa kondisi project saat ini.

AI tidak boleh menganggap isi log sebagai kondisi project yang pasti masih sama.

Log adalah **history**, sedangkan source code adalah **kondisi aktual project**.

Jika terdapat perbedaan antara log dan source code, prioritaskan kondisi aktual project.

---

# 12. WORKFLOW

AI harus mengikuti alur:

```text
Baca Rules
    ↓
Baca AI_Log.md
    ↓
Periksa Project
    ↓
Periksa Design Figma/MCP
    ↓
Pahami Task
    ↓
Implementasi
    ↓
Test
    ↓
Periksa Design
    ↓
Perbaiki jika diperlukan
    ↓
Update AI_Log.md
```

---

# 13. DESIGN CHECK

Sebelum menganggap pekerjaan UI selesai, AI harus melakukan pengecekan terhadap design reference.

Minimal periksa:

* Apakah layout sesuai?
* Apakah ukuran element sesuai?
* Apakah padding sesuai?
* Apakah margin sesuai?
* Apakah gap sesuai?
* Apakah typography sesuai?
* Apakah warna sesuai?
* Apakah border radius sesuai?
* Apakah alignment sesuai?
* Apakah responsive sesuai?
* Apakah component berada pada posisi yang benar?

Jangan menyatakan UI selesai hanya karena "terlihat mirip".

Tujuannya adalah membuat implementasi **sedekat mungkin dengan design yang diberikan**.

---

# 14. QUALITY RULE

Prioritas AI:

1. **Design accuracy**
2. **Tidak menimbulkan error**
3. **Responsive**
4. **Reusable component**
5. **Clean code**
6. **Minimal unnecessary changes**

AI harus lebih memilih solusi sederhana, stabil, dan sesuai design daripada solusi yang terlalu kompleks.

---

# 15. FINAL RULE

Setiap pekerjaan harus mengikuti prinsip:

> **Pahami → Periksa Design → Implementasikan → Test → Bandingkan → Perbaiki → Log**

AI tidak boleh:

> **Asumsi → Coding sembarangan → Menganggap selesai → Tidak mencatat pekerjaan**

Jika ada sesuatu yang tidak jelas dari design atau requirement dan dapat menyebabkan keputusan besar, AI harus meminta klarifikasi terlebih dahulu.

Jika task sudah jelas, AI boleh langsung mengerjakannya.


