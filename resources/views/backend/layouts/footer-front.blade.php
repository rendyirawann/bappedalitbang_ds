<style>
    .f-blue-gradient {
        background: linear-gradient(135deg, #002299 0%, #0039ff 100%);
        color: #ffffff;
        padding: 80px 0 40px;
    }

    .f-header {
        font-weight: 800;
        font-size: 1.1rem;
        text-transform: uppercase;
        margin-bottom: 30px;
        letter-spacing: 1px;
    }

    .f-header::after {
        content: '';
        display: block;
        width: 40px;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        margin-top: 10px;
    }

    .f-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .f-list li {
        margin-bottom: 15px;
    }

    .f-list li a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: 0.3s;
        font-size: 0.9rem;
    }

    .f-list li a:hover {
        color: #fff;
        padding-left: 5px;
    }

    .f-info {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .f-info i {
        color: #fff;
        font-size: 1.1rem;
    }

    .f-map-box {
        border-radius: 15px;
        overflow: hidden;
        border: 3px solid rgba(255, 255, 255, 0.1);
        height: 160px;
    }
</style>

<footer class="f-blue-gradient">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <img src="{{ asset('udema/bappeda/bappeda.png') }}" width="50" alt="Logo">
                    <div class="text-white">
                        <div style="font-size: 0.6rem; font-weight: 600;">BAPPEDALITBANG</div>
                        <div style="font-size: 1.1rem; font-weight: 800;">DELI SERDANG</div>
                    </div>
                </div>
                <p class="small opacity-75">Badan Perencanaan Pembangunan Daerah, Penelitian dan Pengembangan Kabupaten
                    Deli Serdang.</p>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="f-header">Tautan Cepat</h5>
                <ul class="f-list">
                    <li><a href="#">Visi & Misi</a></li>
                    <li><a href="#">Struktur Organisasi</a></li>
                    <li><a href="#">Berita Terbaru</a></li>
                    <li><a href="#">Pusat Unduhan</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="f-header">Kontak</h5>
                <div class="f-info">
                    <i class="bi bi-geo-alt"></i>
                    <span>Kawasan Pemerintahan, Jl. Karya Dharma No.2, Perbarakan, Kec. Pagar Merbau, Kabupaten Deli
                        Serdang, Sumatera Utara 20551 - (061) 7951422</span>
                </div>
                <div class="f-info">
                    <i class="bi bi-envelope"></i>
                    <span>bappedalitbang@deliserdangkab.go.id</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="f-header">Lokasi</h5>
                <div class="f-map-box">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.1707323840023!2d98.86345357583967!3d3.548074296426158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30314871da38672f%3A0xe4e208e313de1df3!2sBadan%20Perencanaan%20Pembangunan%20Daerah%20Penelitian%20dan%20Pengembangan%20Deli%20Serdang!5e0!3m2!1sid!2sid!4v1774492413343!5m2!1sid!2sid"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <hr class="mt-5 opacity-10">
        <p class="text-center small opacity-50 mb-0">© {{ date('Y') }} Bappedalitbang Kabupaten Deli Serdang.</p>
    </div>
</footer>
