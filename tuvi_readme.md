# README - Thông tin nguyên cứu và phân tích hệ thống về website Tử vi (tuvi.vn)

## 1. Form nhập liệu `.form-paper-roll`
URL gốc: https://tuvi.vn/lap-la-so-tu-vi

Form có action `/la-so` và method là post với các input:
- name
- day / month / year (ngày dương)
- hour / min
- gender
- option (1=dương, 2=âm)
- thang-xem / nam-xem (năm xem tử vi)

Sau khi nhập đủ thông tin và nhấn submit form sẽ → redirect → và kết qua ở phần `#content-la-so`

## 2. Phân tích cú pháp URL theo cấu trúc của slug
Ví dụ:
```
https://tuvi.vn/la-so-duong-nam-am-duong-nghich-ly-2-12-1910-ngo-13405?thang-xem=10&nam-xem=2025&day=1&hour=12&min=30&month=1&name=&year=1911&option=1
```

### I. Query params:
- thang-xem (tháng muốn xem)
- nam-xem (năm muốn xem)
- day (ngày)
- month (tháng)
- year (năm)
- hour (giờ)
- min (phút)
- name (name có thể rỗng)
- option (1=dương, 2=âm)

---

### II. Phân tích cấu trúc slug

Ví dụ slug:
```
/la-so-duong-nam-am-duong-nghich-ly-2-12-1910-ngo-13405
```

#### Cấu trúc:
1. `/la-so-duong` → Lá số theo ngày dương  
2. `-nam` → Giới tính  
3. `-am-duong-nghich-ly` → path phụ kèm theo  
4. `-2-12-1910` → Ngày dương/âm đã convert, dựa gender
5. `-ngo` → Chi giờ sinh → dựa vào giờ sinh → convert sang 12 con giáp
6. `-13405` → ID lá số nội bộ của tuvi.vn

---

## 3. Dữ liệu trả về sau khi gửi form hoặc truy cập theo url trong `#content-la-so`

### I. Nhận xét tổng quan
- Đánh giá chung  
- Nhận xét đại vận  
- Thông tin thầy  
- CTA (share, download)

### II. Thông tin nhân mệnh
- Họ tên
- Ngày giờ âm/dương
- Can chi (4 trụ)
- Bản mệnh nạp âm
- Cục
- Cân lượng
- Chủ mệnh
- Chủ thân
- Lai nhân cung
- ID lá số
- Slug
- Tuổi tại năm xem

### III. 12 cung
Mỗi cung gồm:
- Chi cung
- Ngũ hành
- Chính tinh
- Phụ tinh
- Trạng thái (M/V/Đ/B/H)
- Hóa tinh
- Điểm số
- Đại vận / Lưu niên

### IV. Legend chú giải
- Ý nghĩa trạng thái tinh diệu  
- Ngũ hành theo chi cung  

---