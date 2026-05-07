<style>
    /* 1. KUNCI FONT & WARNA UTAMA */
    .nav-master-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 99999;
        background: #ffffff !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        height: 85px;
        font-family: 'Poppins', sans-serif !important;
        display: flex;
        align-items: center;
    }

    /* 2. BRAND AREA (KOTAK BIRU) */
    .brand-side {
        background: linear-gradient(to right, #002299, #0039ff);
        padding: 0 40px 0 25px;
        border-radius: 0 0 100px 0;
        display: flex;
        align-items: center;
        gap: 15px;
        height: 85px;
        flex-shrink: 0;
    }

    .brand-side img {
        width: 50px;
        height: auto;
    }

    .brand-text-white {
        color: #ffffff !important;
        line-height: 1.1;
    }

    .brand-text-white .st {
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        display: block;
    }

    .brand-text-white .bt {
        font-size: 1.3rem;
        font-weight: 800;
        display: block;
        white-space: nowrap;
    }

    /* 3. SLOGAN (NEMPEL DI SAMPING LOGO) */
    .slogan-side {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-left: 20px;
    }

    .slogan-side img {
        height: 35px;
        width: auto;
    }

    /* 4. MENU NAVIGASI (DESKTOP) */
    .menu-side-wrapper {
        margin-left: auto;
        padding-right: 30px;
        height: 100%;
    }

    .nav-list-main {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        height: 100%;
    }

    .nav-item-link {
        color: #333333 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 0 18px;
        line-height: 85px;
        text-decoration: none;
        display: block;
        transition: 0.3s;
    }

    .nav-item-link:hover {
        color: #0039ff !important;
    }

    /* 5. DROPDOWN FIX */
    .dropdown {
        position: relative;
    }

    .dropdown-menu-custom {
        display: none;
        position: absolute;
        top: 85px;
        left: 0;
        background: #ffffff !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border-radius: 0 0 12px 12px;
        min-width: 220px;
        padding: 10px 0;
        z-index: 100001;
        border: none;
    }

    .dropdown:hover .dropdown-menu-custom {
        display: block;
    }

    .dropdown-item-custom {
        padding: 12px 25px;
        color: #333 !important;
        font-weight: 600;
        text-decoration: none;
        display: block;
        font-size: 0.9rem;
    }

    .dropdown-item-custom:hover {
        background: #f4f8fa;
        color: #0039ff !important;
        padding-left: 30px;
    }

    /* 6. RESPONSIVE / MOBILE BURGER */
    .toggler-btn {
        display: none;
        background: none;
        border: none;
        font-size: 2rem;
        padding-right: 20px;
        margin-left: auto;
        cursor: pointer;
    }

    @media (max-width: 1250px) {
        .slogan-side {
            display: none;
        }
    }

    @media (max-width: 991px) {
        .nav-master-container {
            height: auto;
            min-height: 85px;
            flex-wrap: wrap;
        }

        .toggler-btn {
            display: block;
        }

        .menu-side-wrapper {
            display: none;
            /* Default sembunyi di HP */
            width: 100%;
            background: #fff;
            padding: 10px 0 20px 0;
            border-top: 1px solid #eee;
        }

        .menu-side-wrapper.active {
            display: block;
        }

        /* Muncul saat burger diklik */
        .nav-list-main {
            flex-direction: column;
            align-items: flex-start;
            height: auto;
        }

        .nav-item-link {
            line-height: 60px;
            width: 100%;
            padding-left: 25px;
            border-bottom: 1px solid #f9f9f9;
        }

        .dropdown-menu-custom {
            position: static;
            box-shadow: none;
            border-left: 4px solid #0039ff;
            margin-left: 25px;
            min-width: auto;
        }

        .dropdown.active-mobile .dropdown-menu-custom {
            display: block;
        }

        .brand-side {
            height: 85px;
            border-radius: 0 0 50px 0;
        }

        .brand-text-white .bt {
            font-size: 1.1rem;
        }
    }
</style>

<div class="nav-master-container">
    <div class="brand-side">
        <img src="{{ asset('udema/bappeda/bappeda.png') }}" alt="Logo">
        <div class="brand-text-white">
            <span class="st">BAPPEDALITBANG</span>
            <span class="bt">DELI SERDANG</span>
        </div>
    </div>

    <div class="slogan-side d-none d-xl-flex">
        <img src="{{ asset('udema/img/logo/hastag_deli_serdang_sehat.png') }}" alt="Slogan 1">
        <img src="{{ asset('udema/img/logo/berakhlak_logo.png') }}" alt="Slogan 2">
        <img src="{{ asset('udema/img/logo/bangga_melayani_bangsa.png') }}" alt="Slogan 3">
    </div>

    <button class="toggler-btn" id="burgerClick">
        <i class="bi bi-list"></i>
    </button>

    <div class="menu-side-wrapper" id="menuTarget">
        <ul class="nav-list-main">
            <li><a href="#" class="nav-item-link">Beranda</a></li>
            <li class="dropdown" id="dropdownProfile">
                <a href="javascript:void(0);" class="nav-item-link">Profil <i class="bi bi-chevron-down small"></i></a>
                <div class="dropdown-menu-custom">
                    <a href="#" class="dropdown-item-custom">Visi & Misi</a>
                    <a href="#" class="dropdown-item-custom">Struktur Organisasi</a>
                    <a href="#" class="dropdown-item-custom">Unduhan</a>
                </div>
            </li>
            <li><a href="#" class="nav-item-link">Berita</a></li>
            <li><a href="#" class="nav-item-link">Galeri</a></li>
        </ul>
    </div>
</div>

<div style="height: 85px;"></div>

<script>
    // SCRIPT MANUAL AGAR TIDAK BENTROK DENGAN BOOTSTRAP/UDEMA
    document.addEventListener('DOMContentLoaded', function() {
        const burger = document.getElementById('burgerClick');
        const menu = document.getElementById('menuTarget');
        const dropProfile = document.getElementById('dropdownProfile');

        // Toggle Burger Menu (Buka/Tutup)
        burger.addEventListener('click', function() {
            menu.classList.toggle('active');
            // Ganti ikon burger ke X saat terbuka
            const icon = this.querySelector('i');
            if (menu.classList.contains('active')) {
                icon.classList.replace('bi-list', 'bi-x-lg');
            } else {
                icon.classList.replace('bi-x-lg', 'bi-list');
            }
        });

        // Toggle Dropdown Profil khusus di HP
        dropProfile.addEventListener('click', function(e) {
            if (window.innerWidth <= 991) {
                this.classList.toggle('active-mobile');
            }
        });
    });
</script>
