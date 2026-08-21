<?php

/**
 * GIAO DIỆN ĐĂNG NHẬP — QUỐC KHÁNH 2/9
 *
 * In CSS + khai hàm vẽ lớp trang trí động.
 *
 * Mọi selector đều bắt đầu bằng body.giao_dien_quoc_khanh nên không rò sang chỗ
 * nào khác, và thắng CSS gốc của wp-login nhờ độ đặc hiệu cao hơn.
 *
 * Nguyên tắc bất di bất dịch: KHÔNG được che, thu nhỏ hay làm khó đọc ô nhập,
 * nút bấm và thông báo lỗi. Đẹp mà không đăng nhập được thì vô nghĩa. Vì vậy
 * mọi lớp trang trí đều `pointer-events: none` và nằm dưới form về z-index —
 * máy bay bay ngang qua ô mật khẩu vẫn không chặn được cú bấm nào.
 */

if (!defined('ABSPATH')) {
    exit;
}

$bg_webp = TGS_Seasonal_Login::asset('images/anh_nen_quoc_khanh.webp');
$bg_jpg  = TGS_Seasonal_Login::asset('images/anh_nen_quoc_khanh.jpg');
$logo    = TGS_Seasonal_Login::logo_url();
?>
<style id="tgs-seasonal-login-quoc-khanh">
    /* =========================================================
     * NỀN
     * ======================================================= */

    /* Chuyển sắc vẽ ngay, ảnh về thì phủ lên — không có khoảnh khắc trắng xoá */
    body.login.giao_dien_quoc_khanh {
        min-height: 100vh;
        background:
            radial-gradient(circle at 76% 18%, rgba(255, 214, 130, 0.45) 0%, rgba(255, 214, 130, 0) 44%),
            linear-gradient(180deg, #c1121f 0%, #d92b2b 40%, #e8582f 72%, #f5a15c 100%);
    }

    body.login.giao_dien_quoc_khanh::before {
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
        animation: qkl-nen-hien 900ms ease-out forwards;
        pointer-events: none;
    }

    @keyframes qkl-nen-hien {
        to { opacity: 1; }
    }

    /*
     * Quầng sáng giữa màn để form nổi trên nền tranh.
     *
     * Hẹp hơn bản Trung Thu (36%/50% thay vì 44%/58%) và nhạt hơn: nền đỏ đậm
     * hơn nền tím, quầng rộng quá thì cả giữa màn bạc trắng ra, đúng cái lỗi
     * "tấm trắng chùm mất nền" đã gặp ở màn chờ.
     */
    body.login.giao_dien_quoc_khanh::after {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        background: radial-gradient(ellipse 36% 50% at 50% 50%, rgba(255, 250, 240, 0.5) 0%, rgba(255, 250, 240, 0) 72%);
        pointer-events: none;
    }

    body.login.giao_dien_quoc_khanh #login {
        position: relative;
        z-index: 3;
        padding-top: 5vh;
        width: 340px;
    }

    /* =========================================================
     * LOGO + LỜI CHÚC
     * ======================================================= */

    <?php if ($logo !== '') : ?>
    body.login.giao_dien_quoc_khanh h1 a {
        background-image: url("<?php echo esc_url($logo); ?>") !important;
        background-size: contain !important;
        width: 240px !important;
        height: 76px !important;
        margin-bottom: 8px;
        filter: drop-shadow(0 3px 12px rgba(120, 12, 12, 0.35));
    }
    <?php else : ?>
    /* Chưa cài logo cửa hàng thì giữ chữ W của WordPress, chỉ làm nó nổi lên
       trên nền tranh cho dễ nhìn. */
    body.login.giao_dien_quoc_khanh h1 a {
        filter: drop-shadow(0 2px 10px rgba(255, 255, 255, 0.95));
    }
    <?php endif; ?>

    /* Huy hiệu ★ 2·9 ngay trên lời chúc — mốc nhận diện chính của ngày lễ */
    body.login.giao_dien_quoc_khanh .tgs_mua_le__loi_chuc::before {
        content: "★ QUỐC KHÁNH 2 · 9 · 1945";
        display: inline-block;
        margin-bottom: 10px;
        padding: 5px 16px;
        border-radius: 999px;
        background: linear-gradient(135deg, #C1121F 0%, #E0492E 60%, #F4A521 100%);
        border: 1px solid rgba(255, 236, 190, 0.9);
        box-shadow: 0 8px 22px rgba(120, 12, 12, 0.4);
        color: #FFF6E5;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1px;
        animation: qkl-huy-hieu-vao 700ms cubic-bezier(.18, 1.1, .38, 1) both;
    }

    @keyframes qkl-huy-hieu-vao {
        from { opacity: 0; transform: translateY(-10px) scale(.92); }
        to   { opacity: 1; transform: none; }
    }

    body.login.giao_dien_quoc_khanh .tgs_mua_le__loi_chuc {
        margin: 0 0 16px;
        text-align: center;
        line-height: 1.55;
    }

    body.login.giao_dien_quoc_khanh .tgs_mua_le__loi_chuc strong {
        display: block;
        font-size: 17px;
        font-weight: 700;
        background: linear-gradient(90deg, #8f1116 0%, #e63946 35%, #f4a521 55%, #e63946 75%, #8f1116 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: qkl-chu-chay 5s linear infinite;
    }

    @keyframes qkl-chu-chay {
        to { background-position: 200% center; }
    }

    body.login.giao_dien_quoc_khanh .tgs_mua_le__loi_chuc span {
        display: block;
        margin-top: 2px;
        font-size: 13px;
        color: #7a3b1f;
        text-shadow: 0 1px 6px rgba(255, 255, 255, 0.9);
    }

    /* =========================================================
     * KHUNG FORM
     * ======================================================= */

    body.login.giao_dien_quoc_khanh #loginform,
    body.login.giao_dien_quoc_khanh #lostpasswordform,
    body.login.giao_dien_quoc_khanh #registerform,
    body.login.giao_dien_quoc_khanh #resetpassform {
        position: relative;
        border: 1px solid rgba(244, 165, 33, 0.6);
        border-radius: 16px;
        background: rgba(255, 252, 248, 0.9);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        box-shadow:
            0 0 0 4px rgba(255, 255, 255, 0.3),
            0 20px 55px rgba(120, 12, 12, 0.3);
        overflow: hidden;
        animation: qkl-form-len 500ms ease both;
    }

    @keyframes qkl-form-len {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Dải cờ đỏ–vàng chạy ngang mép trên form */
    body.login.giao_dien_quoc_khanh #loginform::before,
    body.login.giao_dien_quoc_khanh #lostpasswordform::before,
    body.login.giao_dien_quoc_khanh #registerform::before,
    body.login.giao_dien_quoc_khanh #resetpassform::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background-image: repeating-linear-gradient(90deg,
                #C1121F 0px, #C1121F 42px,
                #F4A521 42px, #F4A521 72px);
        background-size: 144px 100%;
        animation: qkl-dai-co 18s linear infinite;
    }

    @keyframes qkl-dai-co {
        to { background-position: 144px 0; }
    }

    body.login.giao_dien_quoc_khanh label {
        color: #8f1116;
        font-weight: 600;
    }

    /* Ô nhập để nền TRẮNG ĐẶC, không dùng kính mờ: gõ mật khẩu phải nhìn rõ
       từng ký tự, đây không phải chỗ để làm điệu. */
    body.login.giao_dien_quoc_khanh input[type="text"],
    body.login.giao_dien_quoc_khanh input[type="password"],
    body.login.giao_dien_quoc_khanh input[type="email"] {
        background: #fff;
        border: 1px solid #f0c9a8;
        border-radius: 10px;
        color: #1f2937;
        box-shadow: none;
    }

    body.login.giao_dien_quoc_khanh input[type="text"]:focus,
    body.login.giao_dien_quoc_khanh input[type="password"]:focus,
    body.login.giao_dien_quoc_khanh input[type="email"]:focus {
        border-color: #d9433c;
        box-shadow: 0 0 0 3px rgba(217, 67, 60, 0.2);
    }

    body.login.giao_dien_quoc_khanh .wp-pwd button.wp-hide-pw .dashicons {
        color: #c1121f;
    }

    body.login.giao_dien_quoc_khanh .wp-submit-container,
    body.login.giao_dien_quoc_khanh p.submit {
        text-align: right;
    }

    body.login.giao_dien_quoc_khanh .button-primary,
    body.login.giao_dien_quoc_khanh #wp-submit {
        border: 0;
        border-radius: 10px;
        padding: 4px 22px;
        height: auto;
        min-height: 38px;
        font-weight: 700;
        text-shadow: none;
        background: linear-gradient(90deg, #C1121F 0%, #E0492E 55%, #F4A521 100%);
        box-shadow: 0 6px 18px rgba(193, 18, 31, 0.42);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    body.login.giao_dien_quoc_khanh .button-primary:hover,
    body.login.giao_dien_quoc_khanh #wp-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(193, 18, 31, 0.52);
        background: linear-gradient(90deg, #A00F1A 0%, #C93A22 55%, #E09417 100%);
    }

    /* =========================================================
     * THÔNG BÁO — phải nổi bật hơn phần trang trí
     * ======================================================= */

    body.login.giao_dien_quoc_khanh #login_error,
    body.login.giao_dien_quoc_khanh .message,
    body.login.giao_dien_quoc_khanh .notice {
        position: relative;
        z-index: 4;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 8px 22px rgba(120, 12, 12, 0.22);
    }

    /* =========================================================
     * LIÊN KẾT DƯỚI FORM
     * ======================================================= */

    body.login.giao_dien_quoc_khanh #nav,
    body.login.giao_dien_quoc_khanh #backtoblog {
        position: relative;
        z-index: 3;
        text-align: center;
        text-shadow: 0 1px 8px rgba(255, 255, 255, 0.95);
    }

    body.login.giao_dien_quoc_khanh #nav a,
    body.login.giao_dien_quoc_khanh #backtoblog a {
        color: #8f1116;
        font-weight: 600;
    }

    body.login.giao_dien_quoc_khanh #nav a:hover,
    body.login.giao_dien_quoc_khanh #backtoblog a:hover {
        color: #c1121f;
    }

    body.login.giao_dien_quoc_khanh .language-switcher {
        position: relative;
        z-index: 3;
    }

    body.login.giao_dien_quoc_khanh .privacy-policy-page-link {
        position: relative;
        z-index: 3;
    }

    /* =========================================================
     * TRANG TRÍ ĐỘNG
     * ======================================================= */

    body.login.giao_dien_quoc_khanh .qkl-trang-tri {
        position: fixed;
        inset: 0;
        z-index: 1;
        overflow: hidden;
        pointer-events: none;
    }

    /* ── Pháo hoa ────────────────────────────────────────────────────────── */
    body.login.giao_dien_quoc_khanh .qkl-phao {
        position: absolute;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        opacity: 0;
        animation: qkl-phao-no 4.5s ease-out infinite;
    }

    body.login.giao_dien_quoc_khanh .qkl-phao::before,
    body.login.giao_dien_quoc_khanh .qkl-phao::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        box-shadow:
            0 -26px 0 -2px currentColor, 0 26px 0 -2px currentColor,
            -26px 0 0 -2px currentColor, 26px 0 0 -2px currentColor,
            -18px -18px 0 -2px currentColor, 18px -18px 0 -2px currentColor,
            -18px 18px 0 -2px currentColor, 18px 18px 0 -2px currentColor;
    }

    body.login.giao_dien_quoc_khanh .qkl-phao::after {
        transform: rotate(22.5deg) scale(.72);
    }

    @keyframes qkl-phao-no {
        0%   { opacity: 0; transform: scale(.2); }
        12%  { opacity: 1; transform: scale(1); }
        34%  { opacity: 0; transform: scale(1.35); }
        100% { opacity: 0; transform: scale(1.35); }
    }

    body.login.giao_dien_quoc_khanh .qkl-phao--1 { top: 14%; left: 11%; color: #ffd166; animation-delay: 0s; }
    body.login.giao_dien_quoc_khanh .qkl-phao--2 { top: 22%; left: 87%; color: #ff8fa3; animation-delay: 1.4s; }
    body.login.giao_dien_quoc_khanh .qkl-phao--3 { top: 9%;  left: 68%; color: #ffe6a7; animation-delay: 2.6s; }
    body.login.giao_dien_quoc_khanh .qkl-phao--4 { top: 33%; left: 6%;  color: #ffd166; animation-delay: 3.5s; }
    body.login.giao_dien_quoc_khanh .qkl-phao--5 { top: 56%; left: 93%; color: #ffe6a7; animation-delay: 2.0s; }

    /* ── Sao lấp lánh ────────────────────────────────────────────────────── */
    body.login.giao_dien_quoc_khanh .qkl-sao {
        position: absolute;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #fff3c4;
        box-shadow: 0 0 8px 2px rgba(255, 226, 150, 0.9);
        opacity: 0;
        animation: qkl-sao-nhay ease-in-out infinite;
    }

    @keyframes qkl-sao-nhay {
        0%, 100% { opacity: 0;   transform: scale(0.6); }
        50%      { opacity: .95; transform: scale(1.15); }
    }

    /*
     * ── PHI ĐỘI BAY QUA ─────────────────────────────────────────────────────
     *
     * Máy bay và vệt khói nằm CHUNG một thẻ và cùng dịch chuyển, nên khói luôn
     * dính đuôi máy bay. Bay ở dải trên cùng để không cắt ngang form.
     */
    body.login.giao_dien_quoc_khanh .qkl-phi-doi {
        position: absolute;
        display: flex;
        align-items: center;
        animation: qkl-phi-doi-bay linear infinite;
        will-change: transform;
    }

    @keyframes qkl-phi-doi-bay {
        0%   { transform: translateX(-18vw); }
        100% { transform: translateX(120vw); }
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi__khoi {
        width: 88px;
        height: 5px;
        border-radius: 999px;
        margin-right: -4px;
        transform-origin: right center;
        animation: qkl-khoi-tan 2.6s ease-in-out infinite;
    }

    @keyframes qkl-khoi-tan {
        0%, 100% { opacity: .75; transform: scaleX(1); }
        50%      { opacity: .35; transform: scaleX(.82); }
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi__may-bay {
        font-size: 22px;
        line-height: 1;
        filter: drop-shadow(0 2px 5px rgba(120, 12, 12, 0.35));
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi--1 {
        top: 7%;
        animation-duration: 16s;
        animation-delay: 1s;
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi--1 .qkl-phi-doi__khoi {
        background: linear-gradient(90deg, rgba(193, 18, 31, 0) 0%, rgba(193, 18, 31, .85) 100%);
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi--2 {
        top: 11.5%;
        animation-duration: 16s;
        animation-delay: 1.55s;
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi--2 .qkl-phi-doi__khoi {
        width: 66px;
        background: linear-gradient(90deg, rgba(244, 165, 33, 0) 0%, rgba(244, 165, 33, .8) 100%);
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi--2 .qkl-phi-doi__may-bay { font-size: 17px; }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi--3 {
        top: 3.5%;
        animation-duration: 16s;
        animation-delay: 1.55s;
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi--3 .qkl-phi-doi__khoi {
        width: 66px;
        background: linear-gradient(90deg, rgba(255, 236, 190, 0) 0%, rgba(255, 236, 190, .85) 100%);
    }

    body.login.giao_dien_quoc_khanh .qkl-phi-doi--3 .qkl-phi-doi__may-bay { font-size: 17px; }

    /* ── Bồ câu bay ngang ────────────────────────────────────────────────── */
    body.login.giao_dien_quoc_khanh .qkl-bo-cau {
        position: absolute;
        font-size: 20px;
        opacity: .85;
        animation: qkl-bay-ngang linear infinite;
        will-change: transform;
    }

    @keyframes qkl-bay-ngang {
        0%   { transform: translate(-8vw, 0) scaleX(-1); }
        50%  { transform: translate(50vw, -24px) scaleX(-1); }
        100% { transform: translate(108vw, 0) scaleX(-1); }
    }

    body.login.giao_dien_quoc_khanh .qkl-bo-cau--1 { top: 20%; animation-duration: 28s; animation-delay: 0s; }
    body.login.giao_dien_quoc_khanh .qkl-bo-cau--2 { top: 32%; animation-duration: 36s; animation-delay: 7s; font-size: 15px; opacity: .6; }

    /* ── Bóng bay thả lên ────────────────────────────────────────────────── */
    body.login.giao_dien_quoc_khanh .qkl-bong-bay {
        position: absolute;
        bottom: -14%;
        font-size: 26px;
        line-height: 1;
        opacity: 0;
        animation: qkl-bong-len linear infinite;
        will-change: transform;
    }

    @keyframes qkl-bong-len {
        0%   { transform: translate3d(0, 0, 0) rotate(-5deg);          opacity: 0; }
        10%  { opacity: .9; }
        50%  { transform: translate3d(22px, -60vh, 0) rotate(6deg);    opacity: .9; }
        90%  { opacity: .35; }
        100% { transform: translate3d(-12px, -118vh, 0) rotate(-4deg); opacity: 0; }
    }

    body.login.giao_dien_quoc_khanh .qkl-bong-bay--1 { left: 7%;  animation-duration: 20s; animation-delay: 0s; }
    body.login.giao_dien_quoc_khanh .qkl-bong-bay--2 { left: 22%; animation-duration: 25s; animation-delay: 6s;  font-size: 18px; }
    body.login.giao_dien_quoc_khanh .qkl-bong-bay--3 { left: 78%; animation-duration: 22s; animation-delay: 10s; font-size: 22px; }
    body.login.giao_dien_quoc_khanh .qkl-bong-bay--4 { left: 92%; animation-duration: 27s; animation-delay: 14s; font-size: 16px; }

    /*
     * ── KIM TUYẾN RƠI ───────────────────────────────────────────────────────
     * Vẽ bằng thẻ rỗng tô màu, KHÔNG dùng emoji: emoji mỗi hệ điều hành vẽ một
     * kiểu, mà ở đây cần đúng hai màu đỏ và vàng của lá cờ.
     */
    body.login.giao_dien_quoc_khanh .qkl-kim-tuyen {
        position: absolute;
        top: -8%;
        width: 7px;
        height: 12px;
        border-radius: 2px;
        opacity: .85;
        animation: qkl-kim-tuyen-roi linear infinite;
        will-change: transform;
    }

    @keyframes qkl-kim-tuyen-roi {
        0%   { transform: translate3d(0, 0, 0) rotate(0deg); }
        100% { transform: translate3d(38px, 118vh, 0) rotate(540deg); }
    }

    /* =========================================================
     * MÀN HÌNH HẸP + GIẢM CHUYỂN ĐỘNG
     * ======================================================= */

    @media (max-width: 640px) {
        body.login.giao_dien_quoc_khanh #login {
            padding-top: 3vh;
            width: auto;
        }

        /* Màn nhỏ thì mấy thứ bay chen thẳng vào form, bỏ bớt */
        body.login.giao_dien_quoc_khanh .qkl-phi-doi--2,
        body.login.giao_dien_quoc_khanh .qkl-phi-doi--3,
        body.login.giao_dien_quoc_khanh .qkl-bong-bay--2,
        body.login.giao_dien_quoc_khanh .qkl-bong-bay--4,
        body.login.giao_dien_quoc_khanh .qkl-phao--5 {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        body.login.giao_dien_quoc_khanh::before,
        body.login.giao_dien_quoc_khanh #loginform,
        body.login.giao_dien_quoc_khanh #loginform::before,
        body.login.giao_dien_quoc_khanh .tgs_mua_le__loi_chuc strong,
        body.login.giao_dien_quoc_khanh .tgs_mua_le__loi_chuc::before,
        body.login.giao_dien_quoc_khanh .qkl-phao,
        body.login.giao_dien_quoc_khanh .qkl-sao,
        body.login.giao_dien_quoc_khanh .qkl-phi-doi,
        body.login.giao_dien_quoc_khanh .qkl-phi-doi__khoi,
        body.login.giao_dien_quoc_khanh .qkl-bo-cau,
        body.login.giao_dien_quoc_khanh .qkl-bong-bay,
        body.login.giao_dien_quoc_khanh .qkl-kim-tuyen {
            animation: none !important;
        }

        body.login.giao_dien_quoc_khanh::before {
            opacity: 1;
        }

        body.login.giao_dien_quoc_khanh .qkl-sao {
            opacity: 0.8;
        }

        body.login.giao_dien_quoc_khanh .qkl-phao {
            opacity: .5;
            transform: scale(1);
        }

        /*
         * Mấy thứ bay ngang / rơi xuống mà đứng im thì thành vật thể lơ lửng
         * giữa màn hình, khó hiểu hơn là không có. Bỏ hẳn.
         */
        body.login.giao_dien_quoc_khanh .qkl-phi-doi,
        body.login.giao_dien_quoc_khanh .qkl-bo-cau,
        body.login.giao_dien_quoc_khanh .qkl-bong-bay,
        body.login.giao_dien_quoc_khanh .qkl-kim-tuyen {
            display: none;
        }

        /* Chữ chuyển sắc mà tắt animation thì đứng ở một màu — ép về đỏ đặc */
        body.login.giao_dien_quoc_khanh .tgs_mua_le__loi_chuc strong {
            background: none;
            -webkit-text-fill-color: initial;
            color: #b01118;
        }
    }
</style>
<?php

if (!function_exists('tgs_seasonal_login_decor_quoc_khanh')) {
    /**
     * Lớp trang trí động. Gọi từ hook login_header nên nằm ngay đầu <body>,
     * phía sau form về mặt z-index — không bao giờ chắn đường bấm.
     */
    function tgs_seasonal_login_decor_quoc_khanh()
    {
        /*
         * Sao và kim tuyến đặt vị trí cố định thay vì random: mở lại trang thấy
         * y như cũ, không bị cảm giác trang tự đổi mỗi lần tải.
         */
        $sao = [
            ['top' => '9%',  'left' => '15%', 'dur' => '3.1s', 'delay' => '0s'],
            ['top' => '6%',  'left' => '39%', 'dur' => '2.6s', 'delay' => '0.8s'],
            ['top' => '18%', 'left' => '59%', 'dur' => '3.6s', 'delay' => '1.5s'],
            ['top' => '13%', 'left' => '81%', 'dur' => '2.9s', 'delay' => '0.4s'],
            ['top' => '30%', 'left' => '5%',  'dur' => '3.3s', 'delay' => '2.2s'],
            ['top' => '4%',  'left' => '91%', 'dur' => '2.4s', 'delay' => '1.2s'],
            ['top' => '37%', 'left' => '95%', 'dur' => '3.8s', 'delay' => '1.9s'],
            ['top' => '24%', 'left' => '28%', 'dur' => '2.7s', 'delay' => '2.7s'],
            ['top' => '44%', 'left' => '12%', 'dur' => '3.4s', 'delay' => '0.6s'],
            ['top' => '48%', 'left' => '88%', 'dur' => '2.8s', 'delay' => '3.1s'],
        ];

        echo '<div class="qkl-trang-tri" aria-hidden="true">';

        for ($i = 1; $i <= 5; $i++) {
            printf('<span class="qkl-phao qkl-phao--%d"></span>', $i);
        }

        foreach ($sao as $s) {
            printf(
                '<span class="qkl-sao" style="top:%s;left:%s;animation-duration:%s;animation-delay:%s"></span>',
                esc_attr($s['top']),
                esc_attr($s['left']),
                esc_attr($s['dur']),
                esc_attr($s['delay'])
            );
        }

        // Kim tuyến: 14 mảnh xen kẽ đỏ / vàng, rơi lệch giờ nhau
        for ($i = 0; $i < 14; $i++) {
            printf(
                '<span class="qkl-kim-tuyen" style="left:%s;background:%s;animation-duration:%s;animation-delay:%s"></span>',
                esc_attr((3 + ($i * 61) % 94) . '%'),
                esc_attr($i % 2 === 0 ? '#C1121F' : '#F4A521'),
                esc_attr((9 + ($i % 4) * 2.5) . 's'),
                esc_attr((($i % 7) * 1.6) . 's')
            );
        }

        echo '<span class="qkl-bo-cau qkl-bo-cau--1">🕊️</span>';
        echo '<span class="qkl-bo-cau qkl-bo-cau--2">🕊️</span>';

        for ($i = 1; $i <= 4; $i++) {
            printf('<span class="qkl-bong-bay qkl-bong-bay--%d">🎈</span>', $i);
        }

        for ($i = 1; $i <= 3; $i++) {
            printf(
                '<div class="qkl-phi-doi qkl-phi-doi--%d">'
                    . '<span class="qkl-phi-doi__khoi"></span>'
                    . '<span class="qkl-phi-doi__may-bay">✈️</span>'
                    . '</div>',
                $i
            );
        }

        echo '</div>';
    }
}
