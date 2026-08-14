<?php

/**
 * GIAO DIỆN ĐĂNG NHẬP — TRUNG THU
 *
 * In CSS + khai hàm vẽ lớp trang trí động.
 *
 * Mọi selector đều bắt đầu bằng body.giao_dien_trung_thu nên không rò sang chỗ
 * nào khác, và thắng CSS gốc của wp-login nhờ độ đặc hiệu cao hơn.
 *
 * Nguyên tắc bất di bất dịch: KHÔNG được che, thu nhỏ hay làm khó đọc ô nhập,
 * nút bấm và thông báo lỗi. Đẹp mà không đăng nhập được thì vô nghĩa.
 */

if (!defined('ABSPATH')) {
    exit;
}

$bg_webp = TGS_Seasonal_Login::asset('images/anh_nen_trung_thu.webp');
$bg_jpg  = TGS_Seasonal_Login::asset('images/anh_nen_trung_thu.jpg');
$logo    = TGS_Seasonal_Login::logo_url();
?>
<style id="tgs-seasonal-login-trung-thu">
    /* =========================================================
     * NỀN
     * ======================================================= */

    /* Chuyển sắc vẽ ngay, ảnh về thì phủ lên — không có khoảnh khắc trắng xoá */
    body.login.giao_dien_trung_thu {
        min-height: 100vh;
        background:
            radial-gradient(circle at 78% 16%, rgba(255, 236, 179, 0.5) 0%, rgba(255, 236, 179, 0) 42%),
            linear-gradient(180deg, #6a5ae0 0%, #8f7fe8 38%, #c3b6f2 68%, #e8e2fb 100%);
    }

    body.login.giao_dien_trung_thu::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        background-image: url("<?php echo esc_url($bg_jpg); ?>");
        background-image: -webkit-image-set(url("<?php echo esc_url($bg_webp); ?>") type("image/webp"),
                url("<?php echo esc_url($bg_jpg); ?>") type("image/jpeg"));
        background-image: image-set(url("<?php echo esc_url($bg_webp); ?>") type("image/webp"),
                url("<?php echo esc_url($bg_jpg); ?>") type("image/jpeg"));
        background-size: cover;
        background-position: center;
        opacity: 0;
        animation: ttl-nen-hien 900ms ease-out forwards;
        pointer-events: none;
    }

    @keyframes ttl-nen-hien {
        to { opacity: 1; }
    }

    /* Quầng sáng giữa màn để form luôn nổi trên nền tranh */
    body.login.giao_dien_trung_thu::after {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        background: radial-gradient(ellipse 44% 58% at 50% 50%, rgba(255, 255, 255, 0.55) 0%, rgba(255, 255, 255, 0) 72%);
        pointer-events: none;
    }

    body.login.giao_dien_trung_thu #login {
        position: relative;
        z-index: 3;
        padding-top: 6vh;
    }

    /* =========================================================
     * LOGO + LỜI CHÚC
     * ======================================================= */

    <?php if ($logo !== '') : ?>
    body.login.giao_dien_trung_thu h1 a {
        background-image: url("<?php echo esc_url($logo); ?>") !important;
        background-size: contain !important;
        width: 240px !important;
        height: 76px !important;
        margin-bottom: 8px;
    }
    <?php else : ?>
    /* Chưa cài logo cửa hàng thì giữ chữ W của WordPress, chỉ làm nó nổi lên
       trên nền tranh cho dễ nhìn. */
    body.login.giao_dien_trung_thu h1 a {
        filter: drop-shadow(0 2px 10px rgba(255, 255, 255, 0.95));
    }
    <?php endif; ?>

    body.login.giao_dien_trung_thu .tgs_mua_le__loi_chuc {
        margin: 0 0 16px;
        text-align: center;
        line-height: 1.55;
    }

    body.login.giao_dien_trung_thu .tgs_mua_le__loi_chuc strong {
        display: block;
        font-size: 17px;
        font-weight: 700;
        background: linear-gradient(90deg, #b23fd0 0%, #e0479b 50%, #b23fd0 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: ttl-chu-chay 5s linear infinite;
    }

    @keyframes ttl-chu-chay {
        to { background-position: 200% center; }
    }

    body.login.giao_dien_trung_thu .tgs_mua_le__loi_chuc span {
        display: block;
        margin-top: 2px;
        font-size: 13px;
        color: #5b4a8a;
        text-shadow: 0 1px 6px rgba(255, 255, 255, 0.9);
    }

    /* =========================================================
     * KHUNG FORM
     * ======================================================= */

    body.login.giao_dien_trung_thu #loginform,
    body.login.giao_dien_trung_thu #lostpasswordform,
    body.login.giao_dien_trung_thu #registerform,
    body.login.giao_dien_trung_thu #resetpassform {
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        box-shadow: 0 20px 55px rgba(76, 46, 140, 0.24);
        animation: ttl-form-len 500ms ease both;
    }

    @keyframes ttl-form-len {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    body.login.giao_dien_trung_thu label {
        color: #3b2c8f;
        font-weight: 600;
    }

    /* Ô nhập để nền TRẮNG ĐẶC, không dùng kính mờ: gõ mật khẩu phải nhìn rõ
       từng ký tự, đây không phải chỗ để làm điệu. */
    body.login.giao_dien_trung_thu input[type="text"],
    body.login.giao_dien_trung_thu input[type="password"],
    body.login.giao_dien_trung_thu input[type="email"] {
        background: #fff;
        border: 1px solid #d6c8ee;
        border-radius: 10px;
        color: #1f2937;
        box-shadow: none;
    }

    body.login.giao_dien_trung_thu input[type="text"]:focus,
    body.login.giao_dien_trung_thu input[type="password"]:focus,
    body.login.giao_dien_trung_thu input[type="email"]:focus {
        border-color: #a855f7;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.22);
    }

    body.login.giao_dien_trung_thu .wp-pwd button.wp-hide-pw .dashicons {
        color: #9333ea;
    }

    body.login.giao_dien_trung_thu .wp-submit-container,
    body.login.giao_dien_trung_thu p.submit {
        text-align: right;
    }

    body.login.giao_dien_trung_thu .button-primary,
    body.login.giao_dien_trung_thu #wp-submit {
        border: 0;
        border-radius: 10px;
        padding: 4px 22px;
        height: auto;
        min-height: 38px;
        font-weight: 700;
        text-shadow: none;
        background: linear-gradient(90deg, #a855f7 0%, #d946ef 55%, #f472b6 100%);
        box-shadow: 0 6px 18px rgba(168, 85, 247, 0.4);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    body.login.giao_dien_trung_thu .button-primary:hover,
    body.login.giao_dien_trung_thu #wp-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(168, 85, 247, 0.5);
        background: linear-gradient(90deg, #9333ea 0%, #c026d3 55%, #ec4899 100%);
    }

    /* =========================================================
     * THÔNG BÁO — phải nổi bật hơn phần trang trí
     * ======================================================= */

    body.login.giao_dien_trung_thu #login_error,
    body.login.giao_dien_trung_thu .message,
    body.login.giao_dien_trung_thu .notice {
        position: relative;
        z-index: 4;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 8px 22px rgba(76, 46, 140, 0.18);
    }

    /* =========================================================
     * LIÊN KẾT DƯỚI FORM
     * ======================================================= */

    body.login.giao_dien_trung_thu #nav,
    body.login.giao_dien_trung_thu #backtoblog {
        position: relative;
        z-index: 3;
        text-align: center;
        text-shadow: 0 1px 8px rgba(255, 255, 255, 0.95);
    }

    body.login.giao_dien_trung_thu #nav a,
    body.login.giao_dien_trung_thu #backtoblog a {
        color: #4c2e8c;
        font-weight: 600;
    }

    body.login.giao_dien_trung_thu #nav a:hover,
    body.login.giao_dien_trung_thu #backtoblog a:hover {
        color: #a21caf;
    }

    body.login.giao_dien_trung_thu .language-switcher {
        position: relative;
        z-index: 3;
    }

    body.login.giao_dien_trung_thu .privacy-policy-page-link {
        position: relative;
        z-index: 3;
    }

    /* =========================================================
     * TRANG TRÍ ĐỘNG
     * ======================================================= */

    body.login.giao_dien_trung_thu .ttl-trang-tri {
        position: fixed;
        inset: 0;
        z-index: 1;
        overflow: hidden;
        pointer-events: none;
    }

    body.login.giao_dien_trung_thu .ttl-quang-trang {
        position: absolute;
        top: 3%;
        right: 5%;
        width: 22vw;
        height: 22vw;
        max-width: 320px;
        max-height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 236, 160, 0.5) 0%, rgba(255, 236, 160, 0) 68%);
        animation: ttl-trang-tho 6s ease-in-out infinite;
    }

    @keyframes ttl-trang-tho {
        0%, 100% { transform: scale(1);    opacity: 0.75; }
        50%      { transform: scale(1.12); opacity: 1; }
    }

    body.login.giao_dien_trung_thu .ttl-den {
        position: absolute;
        bottom: -12%;
        font-size: 1.5rem;
        line-height: 1;
        opacity: 0;
        filter: drop-shadow(0 0 10px rgba(255, 170, 80, 0.75));
        animation: ttl-den-bay linear infinite;
    }

    @keyframes ttl-den-bay {
        0%   { transform: translate3d(0, 0, 0) rotate(-4deg);          opacity: 0; }
        12%  { opacity: 0.95; }
        50%  { transform: translate3d(26px, -52vh, 0) rotate(5deg);    opacity: 0.95; }
        88%  { opacity: 0.5; }
        100% { transform: translate3d(-14px, -105vh, 0) rotate(-3deg); opacity: 0; }
    }

    body.login.giao_dien_trung_thu .ttl-den--1 { left: 9%;  animation-duration: 16s; animation-delay: 0s;   font-size: 1.5rem; }
    body.login.giao_dien_trung_thu .ttl-den--2 { left: 24%; animation-duration: 20s; animation-delay: 4s;   font-size: 1.05rem; }
    body.login.giao_dien_trung_thu .ttl-den--3 { left: 74%; animation-duration: 18s; animation-delay: 8s;   font-size: 1.65rem; }
    body.login.giao_dien_trung_thu .ttl-den--4 { left: 88%; animation-duration: 22s; animation-delay: 12s;  font-size: 1.2rem; }

    body.login.giao_dien_trung_thu .ttl-sao {
        position: absolute;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 0 8px 2px rgba(255, 255, 255, 0.9);
        opacity: 0;
        animation: ttl-sao-nhay ease-in-out infinite;
    }

    @keyframes ttl-sao-nhay {
        0%, 100% { opacity: 0;    transform: scale(0.6); }
        50%      { opacity: 0.95; transform: scale(1.15); }
    }

    /* =========================================================
     * MÀN HÌNH HẸP + GIẢM CHUYỂN ĐỘNG
     * ======================================================= */

    @media (max-width: 640px) {
        body.login.giao_dien_trung_thu #login {
            padding-top: 3vh;
        }

        /* Màn nhỏ thì đèn bay chen vào form, bỏ bớt */
        body.login.giao_dien_trung_thu .ttl-den--2,
        body.login.giao_dien_trung_thu .ttl-den--4 {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        body.login.giao_dien_trung_thu #loginform,
        body.login.giao_dien_trung_thu .tgs_mua_le__loi_chuc strong,
        body.login.giao_dien_trung_thu .ttl-quang-trang,
        body.login.giao_dien_trung_thu .ttl-den,
        body.login.giao_dien_trung_thu .ttl-sao {
            animation: none !important;
        }

        body.login.giao_dien_trung_thu .ttl-den {
            display: none;
        }

        body.login.giao_dien_trung_thu .ttl-sao {
            opacity: 0.8;
        }

        body.login.giao_dien_trung_thu .tgs_mua_le__loi_chuc strong {
            background: none;
            -webkit-text-fill-color: initial;
            color: #a21caf;
        }
    }
</style>
<?php

if (!function_exists('tgs_seasonal_login_decor_trung_thu')) {
    /**
     * Lớp trang trí động. Gọi từ hook login_header nên nằm ngay đầu <body>,
     * phía sau form về mặt z-index — không bao giờ chắn đường bấm.
     */
    function tgs_seasonal_login_decor_trung_thu()
    {
        // Sao đặt vị trí cố định thay vì random: mở lại trang thấy y như cũ,
        // không bị cảm giác nhấp nháy lộn xộn.
        $sao = [
            ['top' => '10%', 'left' => '16%', 'dur' => '3.1s', 'delay' => '0s'],
            ['top' => '7%',  'left' => '41%', 'dur' => '2.6s', 'delay' => '0.8s'],
            ['top' => '20%', 'left' => '61%', 'dur' => '3.6s', 'delay' => '1.5s'],
            ['top' => '14%', 'left' => '80%', 'dur' => '2.9s', 'delay' => '0.4s'],
            ['top' => '32%', 'left' => '7%',  'dur' => '3.3s', 'delay' => '2.2s'],
            ['top' => '5%',  'left' => '90%', 'dur' => '2.4s', 'delay' => '1.2s'],
            ['top' => '38%', 'left' => '94%', 'dur' => '3.8s', 'delay' => '1.9s'],
            ['top' => '25%', 'left' => '30%', 'dur' => '2.7s', 'delay' => '2.7s'],
        ];

        echo '<div class="ttl-trang-tri" aria-hidden="true">';
        echo '<div class="ttl-quang-trang"></div>';

        foreach ($sao as $s) {
            printf(
                '<span class="ttl-sao" style="top:%s;left:%s;animation-duration:%s;animation-delay:%s"></span>',
                esc_attr($s['top']),
                esc_attr($s['left']),
                esc_attr($s['dur']),
                esc_attr($s['delay'])
            );
        }

        echo '<span class="ttl-den ttl-den--1">🏮</span>';
        echo '<span class="ttl-den ttl-den--2">🏮</span>';
        echo '<span class="ttl-den ttl-den--3">🏮</span>';
        echo '<span class="ttl-den ttl-den--4">🏮</span>';
        echo '</div>';
    }
}
