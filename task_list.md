# Kế hoạch Triển khai Module Rule Conditions

## Mục tiêu
Xây dựng chức năng quản lý Điều kiện (Conditions) cho từng Luật giải (Rule). Cho phép Admin định nghĩa các điều kiện logic (ví dụ: Cung Mệnh CÓ sao Tử Vi, Cung Thân KHÔNG CÓ Tuần Triệt...) để hệ thống tự động áp dụng luật giải.

## Danh sách công việc (Task List)

### 1. Backend API (Phục vụ Frontend Select)
- [ ] **Tạo API Route:** `/admin/api/stars` và `/admin/api/houses` (hoặc trả về data ngay trong view Edit Rule nếu không muốn call Ajax, nhưng Ajax sẽ linh hoạt hơn).
    - *Ghi chú:* Để đơn giản giai đoạn đầu, có thể truyền biến `$stars` và `$houses` trực tiếp từ `RuleController@edit` xuống View thay vì tạo API riêng.
- [ ] **Data Preparation:** Chuẩn bị danh sách `stars` (id, name), `houses` (code, label), `operators` (=, !=, IN, NOT IN, CONTAINS...).

### 2. Backend Logic (Condition Management)
- [ ] **Route:** Cập nhật route `admin.rules.update` hoặc tạo route riêng `admin.rules.conditions.store` (Vote: Update chung trong Rule update hoặc tạo endpoint API riêng lẻ).
    - *Giải pháp:* Sử dụng `RuleController@update` để xử lý cả Rule Info và danh sách Conditions (Submit form tổng).
- [ ] **Request Validation:** Cập nhật `UpdateRuleRequest` để validate mảng `conditions`.
    - Cấu trúc validate: `conditions.*.type`, `conditions.*.field`, `conditions.*.operator`, `conditions.*.value`.
- [ ] **Controller Logic:**
    - Trong `RuleController@update`:
        1. Xóa các conditions cũ (hoặc sync thông minh).
        2. Tạo các conditions mới từ request.
        3. Lưu field `value` dưới dạng JSON chuẩn.

### 3. Frontend (View & JS)
- [ ] **Cập nhật View `admin.rules.edit`:**
    - Xây dựng bảng hoặc list hiển thị conditions hiện tại.
    - Thêm form/template ẩn (HTML template) cho một dòng condition mới.
- [ ] **Javascript Logic (Dynamic Form):**
    - [ ] Hàm `addConditionRow()`: Clone template, append vào list.
    - [ ] Hàm `removeConditionRow()`: Xóa dòng khỏi DOM.
    - [ ] Xử lý Dropdown phụ thuộc (Ví dụ: Chọn Type = 'has_star' -> Hiển thị dropdown chọn Sao).
    - [ ] Xử lý Input Value: Tùy theo Operator mà hiển thị Input text hay Multi-select.

### 4. Database & Models
- [ ] **Model `RuleCondition`:** Đảm bảo `fillable` các trường: `rule_id`, `type`, `field`, `operator`, `value` (cast array/json).
- [ ] **Relationship:** Đảm bảo `Rule` hasMany `RuleCondition`.

### 5. Kiểm thử (Testing)
- [ ] Thử tạo Rule với 1 condition đơn giản (Check sao tại cung).
- [ ] Thử tạo Rule phức tạp (Nhiều conditions, OR group).
- [ ] Verify dữ liệu lưu trong DB đúng format JSON.

---
**Ước tính thời gian:** 1-2 giờ làm việc tập trung.
