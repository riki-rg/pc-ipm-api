<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PC IPM Mayong — Pimpinan</title>
    <meta name="description" content="Sistem Informasi Pimpinan PC IPM Mayong — mengelola bidang, artikel, kajian, kegiatan, galeri, dan pesan masuk.">
    <style>
        :root {
            --primary: #0f3d2e;
            --primary-dark: #0a2b21;
            --accent: #d4af37;
            --text: #1b1b18;
            --text-soft: #5c5b57;
            --bg: #f7f6f2;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            max-width: 720px;
            width: 100%;
            overflow: hidden;
        }
        .banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 2.5rem 2rem;
            text-align: center;
        }
        .banner h1 {
            color: #fff;
            font-size: 1.9rem;
            letter-spacing: 0.5px;
        }
        .banner p {
            color: var(--accent);
            margin-top: 0.4rem;
            font-size: 1.05rem;
        }
        .content { padding: 2rem; }
        .content p.desc {
            color: var(--text-soft);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .feature {
            border: 1px solid #e5e3dc;
            border-radius: 8px;
            padding: 1rem;
        }
        .feature h3 { font-size: 0.95rem; margin-bottom: 0.3rem; color: var(--primary); }
        .feature p { font-size: 0.85rem; color: var(--text-soft); }
        .cta {
            display: inline-block;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            padding: 0.7rem 1.6rem;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .cta:hover { background: var(--primary-dark); }
        footer {
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: var(--text-soft);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="banner">
            <h1>PC IPM Mayong</h1>
            <p>Pimpinan Cabang &mdash; Ikatan Pelajar Muhammadiyah</p>
        </div>
        <div class="content">
            <p class="desc">
                Selamat datang di sistem informasi Pimpinan PC IPM Mayong.
                Panel admin digunakan untuk mengelola seluruh konten organisasi:
            </p>
            <div class="features">
                <div class="feature">
                    <h3>Bidang &amp; Pengurus</h3>
                    <p>Struktur pimpinan dan pembagian bidang.</p>
                </div>
                <div class="feature">
                    <h3>Artikel &amp; Kajian</h3>
                    <p>Konten literasi dan materi kajian rutin.</p>
                </div>
                <div class="feature">
                    <h3>Kegiatan &amp; Galeri</h3>
                    <p>Dokumentasi agenda dan album foto.</p>
                </div>
                <div class="feature">
                    <h3>Pesan Masuk</h3>
                    <p>Kotak kontak dari pengunjung website.</p>
                </div>
            </div>
            <a class="cta" href="/admin/login">Masuk Panel Admin</a>
        </div>
    </div>
    <footer>&copy; {{ date('Y') }} PC IPM Mayong</footer>
</body>
</html>
