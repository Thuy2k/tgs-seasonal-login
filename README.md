# TGS Seasonal Login

Khoác áo theo mùa cho trang đăng nhập WordPress (`wp-login.php`). **Chỉ đổi giao
diện** — không đụng tới form, việc kiểm tra mật khẩu hay chuyển hướng.

---

## 1. Đổi giao diện

Mở `tgs-seasonal-login.php`, sửa đúng dòng này:

```php
define('TGS_SEASONAL_LOGIN_THEME', 'tu_dong');
```

| Giá trị | Kết quả |
|---|---|
| `'mac_dinh'` | Trang đăng nhập WordPress nguyên bản, không đụng gì |
| `'trung_thu'` | Giao diện Trung Thu (trăng, đèn lồng, hoa rơi) |
| `'quoc_khanh'` | Giao diện Quốc Khánh 2/9 (pháo hoa, phi đội bay, bồ câu, bóng bay) |
| `'tu_dong'` | Tự đổi theo lịch bên dưới, hết mùa tự về nguyên bản |

**Xem thử không cần sửa file:** thêm `?login_theme=quoc_khanh` vào URL trang đăng
nhập. Chỉ ảnh hưởng trình duyệt đang mở.

**Đè từ `wp-config.php`** (tắt gấp khi có sự cố, không cần sửa file plugin):

```php
define('TGS_SEASONAL_LOGIN_THEME', 'mac_dinh');
```

**Đổi bằng code:**

```php
add_filter('tgs_seasonal_login_theme', function ($key) {
    return get_current_blog_id() === 3 ? 'quoc_khanh' : 'mac_dinh';
});
```

---

## 2. Lịch tự đổi

Khai trong `TGS_Seasonal_Login::seasons()`:

```php
['2026-08-20', '2026-09-03', 'quoc_khanh'],
['2026-09-04', '2026-09-28', 'trung_thu'],
```

Quốc Khánh rơi đúng 2/9 dương lịch nên khoảng ngày giống nhau mọi năm. Trung Thu
là rằm tháng 8 âm lịch nên ngày dương lệch nhau mỗi năm — ghi thẳng khoảng ngày
dương từng năm, chắc chắn đúng và ai đọc cũng kiểm tra được.

### ⚠ Hai điều dễ sai

**a) Hàm lấy khoảng ĐẦU TIÊN khớp, không phải khoảng khớp nhất.**
Hai mùa chồng ngày lên nhau thì mùa đứng sau **không bao giờ chạy**, mà chẳng có
gì báo lỗi. Đã dính đúng lỗi này: mốc chạy thử Trung Thu `01–31/8` nuốt trọn mùa
Quốc Khánh.

**b) Lịch này phải TRÙNG với lịch màn chờ POS**
(`tgs_pos/templates/front/partials/splash/splash-config.php`, hàm
`tgs_pos_splash_seasons()`). Đăng nhập rồi vào thẳng màn chờ — hai bên lệch mùa
thì nhân viên đăng nhập thấy cờ đỏ rồi chờ thấy đèn lồng. Không nổ gì cả, chỉ là
nhìn như hệ thống đang hỏng.

Có test soi cả hai điều trên: `test-seasonal-login.js`.

---

## 3. Thêm giao diện mới

1. Copy `themes/theme-quoc-khanh.php` thành `themes/theme-ten-moi.php`
2. Khai thêm một khối vào `TGS_Seasonal_Login::themes()`:

```php
'tet' => [
    'label'      => 'Tết Nguyên Đán',
    'body_class' => 'giao_dien_tet',   // phải khác các giao diện còn lại
    'file'       => 'theme-tet.php',
    'greeting'   => 'Chúc mừng năm mới! 🧧',
    'sub'        => 'Đăng nhập để bắt đầu ngày làm việc',
],
```

3. Trong file mới, **mọi selector phải bắt đầu bằng** `body.login.giao_dien_tet`
4. Hàm vẽ trang trí đặt tên đúng quy ước: `tgs_seasonal_login_decor_tet()` —
   plugin tự tìm theo khoá, không có thì bỏ qua
5. Đặt **tiền tố riêng** cho class và tên `@keyframes` (`ttl-`, `qkl-`, …).
   `@keyframes` không có phạm vi: trùng tên là hiệu ứng của giao diện này âm
   thầm chạy theo giao diện kia

---

## 4. Ba thứ TUYỆT ĐỐI không được phá

Đây là trang đăng nhập. Hỏng là không ai vào được hệ thống, kể cả để sửa nó.

| Phải giữ | Vì sao |
|---|---|
| Ô nhập nền **trắng đặc**, không kính mờ | Gõ mật khẩu phải nhìn rõ từng ký tự |
| Lớp trang trí `pointer-events: none` và nằm dưới form | Không thì máy bay bay ngang chặn mất cú bấm |
| `#login_error` `z-index ≥ 4`, nền đặc | Sai mật khẩu mà không thấy báo là bế tắc hoàn toàn |

Lời chúc được **nối thêm** vào `login_message`, không ghi đè — WordPress in thông
báo lỗi qua chính hook đó. Và khi đang có lỗi thì bỏ lời chúc đi: người đang
cuống vì không vào được cần thấy dòng lỗi trước, không phải lời chúc tưng bừng.

---

## 5. Ảnh nền

| File | Dung lượng | Vai trò |
|---|---|---|
| `assets/images/anh_nen_trung_thu.jpg` | 145 KB | Bản dự phòng cho trình duyệt cũ |
| `assets/images/anh_nen_trung_thu.webp` | 66 KB | Bản dùng thật |
| `assets/images/anh_nen_quoc_khanh.jpg` | 213 KB | Bản dự phòng |
| `assets/images/anh_nen_quoc_khanh.webp` | 115 KB | Bản dùng thật |

CSS khai `.jpg` trước rồi đè `image-set()` phía sau: trình duyệt mới lấy `.webp`,
trình duyệt cũ không hiểu `image-set()` thì bỏ qua dòng đó và vẫn còn `.jpg`.

Ảnh gốc `.png` (1,3–1,8 MB) **không để trong plugin này** — chúng nằm ở
`tgs_pos/assets/images/`. Tạo lại hai bản nén sau khi thay ảnh gốc:

```bash
cd wp-content/plugins
php -r '
$im = imagecreatefrompng("tgs_pos/assets/images/banervaochinhquockhanh.png");
imageinterlace($im, true);
imagejpeg($im, "tgs-seasonal-login/assets/images/anh_nen_quoc_khanh.jpg", 86);
imagewebp($im, "tgs-seasonal-login/assets/images/anh_nen_quoc_khanh.webp", 82);
imagedestroy($im);
'
```

---

## 6. Vì sao tách riêng khỏi `tgs_pos`

`wp-login.php` là hạ tầng của WordPress, dùng chung cho mọi người vào hệ thống
chứ không riêng nhân viên bán hàng. Nhét vào plugin POS thì tắt POS là mất luôn
giao diện đăng nhập, và lỗi ở POS có thể kéo sập trang đăng nhập — tức là không
ai vào được nữa.

Để riêng thì bật/tắt độc lập: có sự cố chỉ cần tắt plugin này, trang đăng nhập về
nguyên bản, không ảnh hưởng bán hàng.
