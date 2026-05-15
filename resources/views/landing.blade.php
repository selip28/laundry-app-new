<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaundryRian — Laundry Bersih, Hidup Nyaman</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --biru-tua : #0d1b4b;
            --biru     : #1a3a8f;
            --biru-muda: #2d5be3;
            --aksen    : #f0c040;
            --putih    : #ffffff;
            --abu-muda : #f5f7ff;
            --abu      : #8892a4;
            --teks     : #1a2340;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior: smooth; }
        body { font-family:'DM Sans',sans-serif; color:var(--teks); background:var(--putih); overflow-x:hidden; }
        nav {
            position:fixed; top:0; left:0; right:0; z-index:999;
            padding:1.1rem 2rem; display:flex; align-items:center; justify-content:space-between;
            background:rgba(13,27,75,.95); backdrop-filter:blur(12px);
            border-bottom:1px solid rgba(255,255,255,.08);
        }
        .nav-brand { display:flex; align-items:center; gap:.5rem; color:#fff; text-decoration:none; font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:700; }
        .nav-brand .dot { color:var(--aksen); }
        .nav-links { display:flex; gap:2rem; list-style:none; }
        .nav-links a { color:rgba(255,255,255,.75); text-decoration:none; font-size:.88rem; font-weight:500; transition:color .2s; }
        .nav-links a:hover { color:var(--aksen); }
        .nav-cta { background:var(--aksen); color:var(--biru-tua); padding:.5rem 1.3rem; border-radius:50px; font-weight:700; font-size:.85rem; text-decoration:none; transition:transform .2s,box-shadow .2s; }
        .nav-cta:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(240,192,64,.4); }
        .hero { min-height:100vh; background:linear-gradient(135deg,var(--biru-tua) 0%,#0f2266 50%,var(--biru) 100%); display:flex; align-items:center; justify-content:center; text-align:center; padding:7rem 2rem 5rem; position:relative; overflow:hidden; }
        .hero::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 60% 50% at 20% 50%,rgba(45,91,227,.2) 0%,transparent 70%),radial-gradient(ellipse 40% 60% at 80% 30%,rgba(240,192,64,.07) 0%,transparent 70%); }
        .bubble { position:absolute; border-radius:50%; background:rgba(255,255,255,.04); animation:floatUp 8s ease-in-out infinite; }
        .b1{width:280px;height:280px;top:-70px;left:-70px;animation-delay:0s}
        .b2{width:180px;height:180px;bottom:80px;right:-50px;animation-delay:2.5s}
        .b3{width:130px;height:130px;top:40%;left:4%;animation-delay:5s}
        @keyframes floatUp{0%,100%{transform:translateY(0)}50%{transform:translateY(-18px)}}
        .hero-content { position:relative; z-index:1; max-width:740px; }
        .hero-badge { display:inline-block; background:rgba(240,192,64,.15); border:1px solid rgba(240,192,64,.35); color:var(--aksen); padding:.35rem 1.1rem; border-radius:50px; font-size:.75rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; margin-bottom:1.5rem; animation:fadeDown .7s ease both; }
        .hero h1 { font-family:'Playfair Display',serif; font-size:clamp(2.6rem,6.5vw,4.8rem); font-weight:900; color:#fff; line-height:1.1; margin-bottom:1.4rem; animation:fadeDown .7s .12s ease both; }
        .hero h1 em { color:var(--aksen); font-style:normal; }
        .hero > .hero-content > p { font-size:1.05rem; color:rgba(255,255,255,.7); line-height:1.75; margin-bottom:2.5rem; animation:fadeDown .7s .24s ease both; }
        .hero-btns { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; animation:fadeDown .7s .36s ease both; }
        .btn-gold { background:var(--aksen); color:var(--biru-tua); padding:.85rem 2rem; border-radius:50px; font-weight:700; font-size:.95rem; text-decoration:none; display:inline-flex; align-items:center; gap:.45rem; box-shadow:0 8px 28px rgba(240,192,64,.35); transition:transform .2s,box-shadow .2s; }
        .btn-gold:hover { transform:translateY(-3px); box-shadow:0 14px 36px rgba(240,192,64,.5); }
        .btn-ghost { border:2px solid rgba(255,255,255,.3); color:#fff; padding:.85rem 2rem; border-radius:50px; font-weight:600; font-size:.95rem; text-decoration:none; display:inline-flex; align-items:center; gap:.45rem; transition:background .2s,border-color .2s; }
        .btn-ghost:hover { background:rgba(255,255,255,.1); border-color:rgba(255,255,255,.55); }
        .hero-stats { display:flex; gap:2.5rem; justify-content:center; flex-wrap:wrap; margin-top:3.5rem; padding-top:2.5rem; border-top:1px solid rgba(255,255,255,.1); animation:fadeDown .7s .5s ease both; }
        .stat-angka { font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:900; color:var(--aksen); }
        .stat-label { font-size:.78rem; color:rgba(255,255,255,.5); margin-top:.15rem; }
        section { padding:5rem 2rem; }
        .container { max-width:1100px; margin:0 auto; }
        .sec-label { font-size:.72rem; font-weight:700; letter-spacing:.13em; text-transform:uppercase; color:var(--biru-muda); margin-bottom:.5rem; }
        .sec-title { font-family:'Playfair Display',serif; font-size:clamp(1.7rem,3.5vw,2.6rem); font-weight:900; line-height:1.2; margin-bottom:.9rem; }
        .sec-sub { color:var(--abu); font-size:.95rem; line-height:1.7; max-width:500px; }
        .text-center { text-align:center; }
        .text-center .sec-sub { margin:0 auto; }
        #tentang { background:var(--abu-muda); }
        .tentang-wrap { display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; }
        .tentang-kiri { background:linear-gradient(135deg,var(--biru),var(--biru-muda)); border-radius:20px; padding:3rem 2rem; text-align:center; color:#fff; display:flex; flex-direction:column; align-items:center; gap:1rem; }
        .tentang-kiri .big-icon { font-size:5rem; }
        .tentang-kiri h3 { font-family:'Playfair Display',serif; font-size:1.6rem; }
        .tentang-kiri p { opacity:.75; font-size:.9rem; line-height:1.6; }
        .poin-list { list-style:none; margin-top:1.5rem; }
        .poin-list li { display:flex; align-items:flex-start; gap:.8rem; padding:.7rem 0; border-bottom:1px solid #eef0f8; font-size:.93rem; }
        .poin-list li:last-child { border:none; }
        .poin-cek { width:22px; height:22px; border-radius:50%; background:var(--biru-muda); color:#fff; display:flex; align-items:center; justify-content:center; font-size:.65rem; flex-shrink:0; margin-top:2px; }
        #layanan { background:var(--putih); }
        .layanan-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(270px,1fr)); gap:1.4rem; margin-top:2.5rem; }
        .layanan-card { border:2px solid #edf0f8; border-radius:16px; padding:1.75rem; position:relative; overflow:hidden; transition:transform .2s,border-color .2s,box-shadow .2s; }
        .layanan-card::after { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,var(--biru),var(--biru-muda)); transform:scaleX(0); transform-origin:left; transition:transform .3s; }
        .layanan-card:hover { transform:translateY(-5px); border-color:var(--biru-muda); box-shadow:0 14px 40px rgba(45,91,227,.1); }
        .layanan-card:hover::after { transform:scaleX(1); }
        .l-icon { width:50px; height:50px; border-radius:13px; background:linear-gradient(135deg,#e8eeff,#d0daff); display:flex; align-items:center; justify-content:center; font-size:1.45rem; margin-bottom:.9rem; }
        .l-nama { font-weight:700; font-size:1rem; margin-bottom:.3rem; }
        .l-desc { color:var(--abu); font-size:.84rem; line-height:1.6; margin-bottom:.9rem; }
        .l-harga { font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:700; color:var(--biru-muda); }
        .l-harga small { font-family:'DM Sans',sans-serif; font-size:.78rem; font-weight:400; color:var(--abu); }
        .l-est { display:inline-block; margin-top:.5rem; background:#f0f4ff; color:var(--biru); padding:.2rem .7rem; border-radius:50px; font-size:.73rem; font-weight:600; }
        #cabang { background:var(--abu-muda); }
        .cabang-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:1.4rem; margin-top:2.5rem; }
        .cabang-card { background:#fff; border-radius:16px; padding:1.5rem; box-shadow:0 4px 18px rgba(0,0,0,.06); transition:transform .2s,box-shadow .2s; }
        .cabang-card:hover { transform:translateY(-4px); box-shadow:0 12px 36px rgba(0,0,0,.1); }
        .cabang-kode { display:inline-block; background:linear-gradient(135deg,var(--biru),var(--biru-muda)); color:#fff; padding:.3rem .9rem; border-radius:50px; font-size:.72rem; font-weight:700; letter-spacing:.08em; margin-bottom:.9rem; }
        .cabang-nama { font-weight:700; font-size:1rem; margin-bottom:.5rem; }
        .cabang-detail { font-size:.84rem; color:var(--abu); line-height:1.7; }
        #cara { background:var(--putih); }
        .cara-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(190px,1fr)); gap:2rem; margin-top:3rem; }
        .cara-item { text-align:center; }
        .cara-no { width:54px; height:54px; border-radius:50%; background:linear-gradient(135deg,var(--biru),var(--biru-muda)); color:#fff; font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:900; display:flex; align-items:center; justify-content:center; margin:0 auto .9rem; box-shadow:0 8px 22px rgba(45,91,227,.28); }
        .cara-judul { font-weight:700; font-size:.92rem; margin-bottom:.35rem; }
        .cara-desc { color:var(--abu); font-size:.82rem; line-height:1.65; }
        #cek { background:linear-gradient(135deg,var(--biru-tua) 0%,#1a3a8f 100%); text-align:center; position:relative; overflow:hidden; }
        #cek::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 70% 80% at 50% 50%,rgba(45,91,227,.18) 0%,transparent 70%); }
        #cek .container { position:relative; z-index:1; }
        #cek h2 { font-family:'Playfair Display',serif; font-size:clamp(1.9rem,4.5vw,3rem); font-weight:900; color:#fff; margin-bottom:.8rem; }
        #cek h2 em { color:var(--aksen); font-style:normal; }
        #cek .sub-cek { color:rgba(255,255,255,.65); margin-bottom:2rem; font-size:.95rem; }
        .cek-box { display:flex; gap:.7rem; justify-content:center; flex-wrap:wrap; max-width:500px; margin:0 auto; }
        .cek-input { flex:1; min-width:220px; padding:.85rem 1.4rem; border-radius:50px; border:2px solid rgba(255,255,255,.18); background:rgba(255,255,255,.1); color:#fff; font-size:.92rem; font-family:'DM Sans',sans-serif; outline:none; transition:border-color .2s; }
        .cek-input::placeholder { color:rgba(255,255,255,.4); }
        .cek-input:focus { border-color:var(--aksen); }
        .cek-btn { background:var(--aksen); color:var(--biru-tua); padding:.85rem 1.8rem; border-radius:50px; font-weight:700; font-size:.92rem; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:transform .2s,box-shadow .2s; }
        .cek-btn:hover { transform:translateY(-2px); box-shadow:0 8px 22px rgba(240,192,64,.4); }
        .cek-hint { margin-top:1rem; font-size:.78rem; color:rgba(255,255,255,.35); }
        footer { background:var(--biru-tua); padding:2rem; text-align:center; color:rgba(255,255,255,.45); font-size:.82rem; }
        footer a { color:var(--aksen); text-decoration:none; }
        @keyframes fadeDown { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }
        .reveal { opacity:0; transform:translateY(28px); transition:opacity .65s ease,transform .65s ease; }
        .reveal.on { opacity:1; transform:translateY(0); }
        @media(max-width:768px){ .tentang-wrap{grid-template-columns:1fr} .nav-links{display:none} .hero-stats{gap:1.5rem} }
    </style>
</head>
<body>

<nav>
    <a href="#" class="nav-brand">🧺 Laundry<span class="dot">Rian</span></a>
    <ul class="nav-links">
        <li><a href="#tentang">Tentang</a></li>
        <li><a href="#layanan">Layanan</a></li>
        <li><a href="#cabang">Cabang</a></li>
        <li><a href="#cara">Cara Kerja</a></li>
    </ul>
    <a href="#cek" class="nav-cta">🔍 Cek Status</a>
</nav>

<section class="hero">
    <div class="bubble b1"></div>
    <div class="bubble b2"></div>
    <div class="bubble b3"></div>
    <div class="hero-content">
        <div class="hero-badge">⭐ Laundry Terpercaya Multi-Kota</div>
        <h1>Laundry <em>Bersih</em>,<br>Hidup Lebih Nyaman</h1>
        <p>Kami hadir di 4 wilayah dengan layanan laundry profesional, cepat, dan terjangkau.<br>Pakaian Anda kami jaga sepenuh hati dan bisa dipantau kapan saja.</p>
        <div class="hero-btns">
            <a href="#cek" class="btn-gold">🔍 Cek Status Laundry</a>
            <a href="#layanan" class="btn-ghost">📋 Lihat Layanan</a>
        </div>
        <div class="hero-stats">
            <div><div class="stat-angka">4+</div><div class="stat-label">cabang wilayah</div></div>
            <div><div class="stat-angka">100+</div><div class="stat-label">Customer Puas</div></div>
            <div><div class="stat-angka">6</div><div class="stat-label">Jenis Layanan</div></div>
            <div><div class="stat-angka">24/7</div><div class="stat-label">Tracking Online</div></div>
        </div>
    </div>
</section>

<section id="tentang">
    <div class="container">
        <div class="tentang-wrap">
            <div class="tentang-kiri reveal">
                <div class="big-icon">🧺</div>
                <h3>LaundryRian</h3>
                <p>Sistem laundry modern dengan tracking real-time via WhatsApp</p>
            </div>
            <div class="reveal">
                <div class="sec-label">Tentang Kami</div>
                <h2 class="sec-title">Mengapa Pilih LaundryRian?</h2>
                <p class="sec-sub">Bukan sekadar laundry biasa. Dengan teknologi tracking modern, Anda bisa memantau cucian kapan saja dan dari mana saja.</p>
                <ul class="poin-list">
                    <li><span class="poin-cek">✓</span><div><strong>Tracking Real-Time</strong> — Pantau status laundry via kode transaksi atau nomor HP, kapan saja.</div></li>
                    <li><span class="poin-cek">✓</span><div><strong>Harga Transparan</strong> — Tidak ada biaya tersembunyi, dihitung per kg, terlihat di nota.</div></li>
                    <li><span class="poin-cek">✓</span><div><strong>Multi Cabang</strong> — Tersedia di 4 kota besar, mudah dijangkau dari mana saja.</div></li>
                    <li><span class="poin-cek">✓</span><div><strong>Tepat Waktu</strong> — Estimasi selesai jelas sejak awal, kami komitmen menyelesaikan tepat waktu.</div></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="layanan">
    <div class="container">
        <div class="text-center reveal">
            <div class="sec-label">Layanan Kami</div>
            <h2 class="sec-title">Pilihan Layanan Lengkap</h2>
            <p class="sec-sub">Dari cuci biasa hingga dry cleaning, semua tersedia dengan harga yang bersaing.</p>
        </div>
        <div class="layanan-grid">
            <div class="layanan-card reveal"><div class="l-icon">🫧</div><div class="l-nama">Cuci &amp; Kering</div><div class="l-desc">Cuci bersih dan keringkan pakaian Anda dengan mesin pengering modern.</div><div class="l-harga">Rp 5.000 <small>/kg</small></div><div class="l-est">⏱ Est. 1 hari</div></div>
            <div class="layanan-card reveal"><div class="l-icon">👕</div><div class="l-nama">Cuci &amp; Setrika</div><div class="l-desc">Cuci bersih, keringkan, dan setrika rapi. Pakaian siap pakai langsung.</div><div class="l-harga">Rp 7.000 <small>/kg</small></div><div class="l-est">⏱ Est. 2 hari</div></div>
            <div class="layanan-card reveal"><div class="l-icon">⚡</div><div class="l-nama">Express (6 Jam)</div><div class="l-desc">Butuh cepat? Layanan kilat kami siap menyelesaikan cucian dalam 6 jam.</div><div class="l-harga">Rp 12.000 <small>/kg</small></div><div class="l-est">⏱ Est. 6 jam</div></div>
            <div class="layanan-card reveal"><div class="l-icon">🔥</div><div class="l-nama">Setrika Saja</div><div class="l-desc">Khusus pakaian yang sudah dicuci dan hanya perlu disetrika rapi.</div><div class="l-harga">Rp 4.000 <small>/kg</small></div><div class="l-est">⏱ Est. 12 jam</div></div>
            <div class="layanan-card reveal"><div class="l-icon">👟</div><div class="l-nama">Cuci Sepatu</div><div class="l-desc">Cuci bersih sepatu kesayangan Anda dengan teknik dan bahan khusus.</div><div class="l-harga">Rp 25.000 <small>/pasang</small></div><div class="l-est">⏱ Est. 2 hari</div></div>
            <div class="layanan-card reveal"><div class="l-icon">🧥</div><div class="l-nama">Dry Cleaning</div><div class="l-desc">Perawatan khusus jas, gaun, dan pakaian berbahan halus atau mewah.</div><div class="l-harga">Rp 20.000 <small>/kg</small></div><div class="l-est">⏱ Est. 3 hari</div></div>
        </div>
    </div>
</section>

<section id="cabang">
    <div class="container">
        <div class="text-center reveal">
            <div class="sec-label">Lokasi Kami</div>
            <h2 class="sec-title">Cabang Terdekat Anda</h2>
            <p class="sec-sub">Temukan outlet LaundryRian di wilayah Anda. Semua cabang terintegrasi dalam satu sistem.</p>
        </div>
        <div class="cabang-grid">
            <div class="cabang-card reveal"><div class="cabang-kode">IMYU</div><div class="cabang-nama">Cabang indramayu</div><div class="cabang-detail"><p>📍 Jl. Sudirman No. 10, Jakarta Pusat</p><p>📞 021-12345678</p><p>✅ Buka &amp; Menerima Laundry</p></div></div>
            <div class="cabang-card reveal"><div class="cabang-kode">BDG</div><div class="cabang-nama">Cabang Bandung</div><div class="cabang-detail"><p>📍 Jl. Asia Afrika No. 5, Bandung</p><p>📞 022-87654321</p><p>✅ Buka &amp; Menerima Laundry</p></div></div>
            <div class="cabang-card reveal"><div class="cabang-kode">SBY</div><div class="cabang-nama">Cabang Surabaya</div><div class="cabang-detail"><p>📍 Jl. Pemuda No. 20, Surabaya</p><p>📞 031-11223344</p><p>✅ Buka &amp; Menerima Laundry</p></div></div>
            <div class="cabang-card reveal"><div class="cabang-kode">YGY</div><div class="cabang-nama">Cabang Yogyakarta</div><div class="cabang-detail"><p>📍 Jl. Malioboro No. 15, Yogyakarta</p><p>📞 0274-556677</p><p>✅ Buka &amp; Menerima Laundry</p></div></div>
        </div>
    </div>
</section>

<section id="cara">
    <div class="container">
        <div class="text-center reveal">
            <div class="sec-label">Alur Layanan</div>
            <h2 class="sec-title">Cara Kerja LaundryRian</h2>
            <p class="sec-sub">Proses mudah dari antar sampai ambil, semua bisa dipantau secara online.</p>
        </div>
        <div class="cara-grid">
            <div class="cara-item reveal"><div class="cara-no">1</div><div class="cara-judul">Antar ke Cabang</div><div class="cara-desc">Datang ke cabang terdekat dan serahkan pakaian Anda ke petugas kami.</div></div>
            <div class="cara-item reveal"><div class="cara-no">2</div><div class="cara-judul">Terima Nota &amp; Kode</div><div class="cara-desc">Dapatkan nota beserta kode transaksi unik untuk memantau status laundry.</div></div>
            <div class="cara-item reveal"><div class="cara-no">3</div><div class="cara-judul">Pantau Status</div><div class="cara-desc">Cek status kapan saja menggunakan kode transaksi atau nomor HP Anda.</div></div>
            <div class="cara-item reveal"><div class="cara-no">4</div><div class="cara-judul">Ambil Laundry</div><div class="cara-desc">Membawa struk laundry, datang ke cabang dan ambil pakaian bersih Anda.</div></div>
        </div>
    </div>
</section>

<section id="cek">
    <div class="container">
        <h2>Cek Status <em>Laundry</em> Anda</h2>
        <p class="sub-cek">Masukkan kode transaksi dari nota, atau nomor HP yang didaftarkan saat pengantaran.</p>
        <div class="cek-box">
            <input type="text" id="inputKode" class="cek-input" placeholder="Kode transaksi atau No HP...">
            <button class="cek-btn" onclick="cekStatus()">🔍 Cek Sekarang</button>
        </div>
        <p class="cek-hint">Contoh: LDR-JKT-20240101-0001 atau 081234567890</p>
    </div>
</section>

<footer>
    <p>© <span id="thn"></span> <strong style="color:#fff">LaundryRian</strong> — Semua hak dilindungi.</p>
    <p style="margin-top:.5rem"><a href="/login">Login Admin</a> &nbsp;·&nbsp; <a href="/cek-status">Halaman Cek Status</a></p>
</footer>

<script>
    document.getElementById('thn').textContent = new Date().getFullYear();
    function cekStatus() {
        const kode = document.getElementById('inputKode').value.trim();
        if (!kode) { alert('Masukkan kode transaksi atau nomor HP terlebih dahulu.'); return; }
        window.location.href = '/cek-status?kode=' + encodeURIComponent(kode);
    }
    document.getElementById('inputKode').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') cekStatus();
    });
    const obs = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) setTimeout(() => entry.target.classList.add('on'), i * 70);
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
</body>
</html>