<?php

/**
 * Bộ khung khoác áo theo mùa cho trang đăng nhập.
 *
 * Chỉ móc vào các hook GIAO DIỆN của wp-login.php: đổi logo, thêm lời chúc, in
 * CSS và mấy lớp trang trí. KHÔNG chạm vào form, vào việc kiểm tra mật khẩu hay
 * chuyển hướng — hỏng đăng nhập là cả hệ thống đứng.
 */

if (!defined('ABSPATH')) {
    exit;
}

class TGS_Seasonal_Login
{
    /** @var array|null Giao diện đang dùng, nạp một lần cho mỗi request. */
    private static $theme = null;

    public static function init()
    {
        // Chỉ gắn hook trên chính trang đăng nhập, không đụng phần còn lại.
        add_action('login_enqueue_scripts', [__CLASS__, 'render_styles']);
        add_action('login_header', [__CLASS__, 'render_decor']);
        add_filter('login_body_class', [__CLASS__, 'body_class']);
        add_filter('login_headerurl', [__CLASS__, 'header_url']);
        add_filter('login_headertext', [__CLASS__, 'header_text']);
        add_filter('login_message', [__CLASS__, 'login_message']);
    }

    /* =====================================================================
     * CHỌN GIAO DIỆN
     * ================================================================== */

    /**
     * Lịch tự đổi. Trung Thu là rằm tháng 8 âm lịch nên ngày dương lệch nhau
     * mỗi năm — ghi thẳng khoảng ngày dương từng năm, chắc chắn đúng và ai đọc
     * cũng kiểm tra được, hơn là đi tính lịch âm trong code.
     */
    private static function seasons()
    {
        return [
            // [ từ ngày, đến ngày, giao diện ]
            ['2025-09-20', '2025-10-08', 'trung_thu'],
            ['2026-09-10', '2026-09-28', 'trung_thu'],
            ['2027-08-30', '2027-09-17', 'trung_thu'],

            // Mốc chạy thử mùa 2026 — xoá đi khi không cần nữa
            ['2026-08-01', '2026-08-31', 'trung_thu'],
        ];
    }

    private static function themes()
    {
        return [
            'mac_dinh' => [
                'label'      => 'Mặc định (WordPress nguyên bản)',
                'body_class' => '',
                'file'       => '',
                'greeting'   => '',
                'sub'        => '',
            ],

            'trung_thu' => [
                'label'      => 'Trung Thu',
                'body_class' => 'giao_dien_trung_thu',
                'file'       => 'theme-trung-thu.php',
                'greeting'   => 'Chúc bạn một mùa Trung Thu an lành 🏮',
                'sub'        => 'Đăng nhập để bắt đầu ngày làm việc',
            ],
        ];
    }

    /** @return array Mô tả giao diện đang dùng, luôn hợp lệ. */
    public static function theme()
    {
        if (self::$theme !== null) {
            return self::$theme;
        }

        $themes = self::themes();
        $key = apply_filters('tgs_seasonal_login_theme', TGS_SEASONAL_LOGIN_THEME);

        // Xem thử: ?login_theme=trung_thu — chỉ ảnh hưởng trình duyệt đang mở.
        if (!empty($_GET['login_theme'])) {
            $key = sanitize_key(wp_unslash($_GET['login_theme']));
        }

        if ($key === 'tu_dong') {
            $key = self::auto_theme();
        }

        if (!isset($themes[$key])) {
            $key = 'mac_dinh';
        }

        self::$theme = $themes[$key] + ['key' => $key];

        return self::$theme;
    }

    private static function auto_theme()
    {
        $today = current_time('Y-m-d');

        foreach (self::seasons() as $season) {
            list($from, $to, $theme) = $season;
            if ($today >= $from && $today <= $to) {
                return $theme;
            }
        }

        return 'mac_dinh';
    }

    private static function is_active()
    {
        $theme = self::theme();

        return $theme['key'] !== 'mac_dinh' && !empty($theme['file']);
    }

    /* =====================================================================
     * MÓC VÀO TRANG ĐĂNG NHẬP
     * ================================================================== */

    public static function body_class($classes)
    {
        if (self::is_active()) {
            $theme = self::theme();
            $classes[] = 'tgs_mua_le';
            $classes[] = $theme['body_class'];
        }

        return $classes;
    }

    public static function render_styles()
    {
        if (!self::is_active()) {
            return;
        }

        $theme = self::theme();
        $path = TGS_SEASONAL_LOGIN_PATH . 'themes/' . $theme['file'];

        if (file_exists($path)) {
            include $path;
        }
    }

    /**
     * Các lớp trang trí động. Hàm theme tự khai
     * tgs_seasonal_login_decor_<key>() thì gọi, không có thì thôi.
     */
    public static function render_decor()
    {
        if (!self::is_active()) {
            return;
        }

        $theme = self::theme();
        $fn = 'tgs_seasonal_login_decor_' . $theme['key'];

        if (function_exists($fn)) {
            call_user_func($fn);
        }
    }

    /** Bấm logo thì về trang chủ của chính site đang đăng nhập. */
    public static function header_url($url)
    {
        return self::is_active() ? home_url('/') : $url;
    }

    public static function header_text($text)
    {
        return self::is_active() ? get_bloginfo('name') : $text;
    }

    /**
     * Lời chúc phía trên form.
     *
     * Cẩn thận: hook login_message cũng là chỗ WordPress in thông báo lỗi và
     * hướng dẫn ("Vui lòng nhập mật khẩu", "Đã gửi email đặt lại"...). Phải nối
     * thêm vào chứ tuyệt đối không ghi đè, không thì người dùng sai mật khẩu mà
     * không thấy báo gì.
     */
    public static function login_message($message)
    {
        if (!self::is_active()) {
            return $message;
        }

        $theme = self::theme();
        if (empty($theme['greeting'])) {
            return $message;
        }

        /*
         * Đang có lỗi (sai mật khẩu, thiếu ô…) thì bỏ lời chúc đi.
         * WordPress in nội dung login_message TRƯỚC khối #login_error, nên để
         * nguyên là màn hình thành: lời chúc tưng bừng → dòng báo lỗi đỏ. Người
         * đang cuống vì không vào được cần thấy lỗi trước tiên.
         */
        if (self::has_login_error()) {
            return $message;
        }

        $html = '<div class="tgs_mua_le__loi_chuc">'
            . '<strong>' . esc_html($theme['greeting']) . '</strong>'
            . ($theme['sub'] !== '' ? '<span>' . esc_html($theme['sub']) . '</span>' : '')
            . '</div>';

        return $html . $message;
    }

    /**
     * Trang đăng nhập có đang báo lỗi không.
     *
     * Không đọc thẳng được đối tượng lỗi: wp-login.php giữ nó ở tham số cục bộ
     * $wp_error của hàm login_header(), mà bộ lọc login_message chạy bên trong
     * hàm đó nên không với tới. Chỉ có biến toàn cục $error (dạng chuỗi, dành
     * cho plugin đời cũ) là thấy được.
     *
     * Nên suy ra: nếu là POST mà trang vẫn đang vẽ lại form, tức là lần gửi vừa
     * rồi hỏng — đăng nhập được thì WordPress đã chuyển hướng đi rồi, không bao
     * giờ chạy tới đây.
     */
    private static function has_login_error()
    {
        if (!empty($GLOBALS['error'])) {
            return true;
        }

        $method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';

        return $method === 'POST';
    }

    /* =====================================================================
     * TIỆN ÍCH CHO FILE THEME
     * ================================================================== */

    /**
     * Logo hiển thị thay cho chữ W của WordPress.
     * Ưu tiên logo shop do tgs_shop_management lưu, không có thì dùng logo theme
     * hoặc site icon. Tất cả đều là hàm/option chuẩn nên không phụ thuộc plugin.
     *
     * @return string URL, rỗng nghĩa là giữ nguyên logo WordPress.
     */
    public static function logo_url()
    {
        $logo = trim((string) get_option('tgs_shop_logo', ''));
        if ($logo !== '') {
            return $logo;
        }

        $custom = get_theme_mod('custom_logo');
        if ($custom) {
            $src = wp_get_attachment_image_src($custom, 'medium');
            if (!empty($src[0])) {
                return $src[0];
            }
        }

        $icon = get_site_icon_url(192);

        return $icon ? $icon : '';
    }

    public static function asset($file)
    {
        return TGS_SEASONAL_LOGIN_URL . 'assets/' . ltrim($file, '/');
    }
}
