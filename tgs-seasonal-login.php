<?php

/**
 * Plugin Name: TGS Seasonal Login
 * Description: Khoác áo theo mùa cho trang đăng nhập WordPress (Trung Thu, Tết…). Chỉ đổi giao diện, không đụng tới cơ chế đăng nhập.
 * Version:     1.0.0
 * Author:      TGS
 * Network:     true
 *
 * =============================================================================
 * TÁCH RIÊNG KHỎI tgs_pos LÀ CÓ CHỦ Ý
 *
 * wp-login.php là hạ tầng của WordPress, dùng chung cho mọi người vào hệ thống
 * chứ không riêng nhân viên bán hàng. Nhét vào plugin POS thì:
 *   - tắt POS là mất luôn giao diện đăng nhập;
 *   - lỗi ở POS có thể kéo sập trang đăng nhập, tức là không ai vào được nữa.
 *
 * Để riêng thì bật/tắt độc lập, và nếu có sự cố chỉ cần tắt plugin này là trang
 * đăng nhập về nguyên bản, không ảnh hưởng bán hàng.
 *
 * 👉 ĐỔI GIAO DIỆN: sửa hằng TGS_SEASONAL_LOGIN_THEME ngay bên dưới.
 * Xem thêm README.md cùng thư mục.
 * =============================================================================
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TGS_SEASONAL_LOGIN_PATH', plugin_dir_path(__FILE__));
define('TGS_SEASONAL_LOGIN_URL', plugin_dir_url(__FILE__));

/* -----------------------------------------------------------------------------
 * 🎨 CHỌN GIAO DIỆN Ở ĐÂY
 *
 *   'mac_dinh'  → trang đăng nhập WordPress nguyên bản, không đụng gì
 *   'trung_thu' → giao diện Trung Thu
 *   'tu_dong'   → tự đổi theo lịch bên dưới, hết mùa tự về nguyên bản
 *
 * Có thể đè bằng wp-config.php:
 *   define('TGS_SEASONAL_LOGIN_THEME', 'mac_dinh');
 * -------------------------------------------------------------------------- */
if (!defined('TGS_SEASONAL_LOGIN_THEME')) {
    define('TGS_SEASONAL_LOGIN_THEME', 'tu_dong');
}

require_once TGS_SEASONAL_LOGIN_PATH . 'includes/class-tgs-seasonal-login.php';

TGS_Seasonal_Login::init();
