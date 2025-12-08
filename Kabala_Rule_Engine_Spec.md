# KABALA HOROSCOPE RULE ENGINE: SPECIFICATION V1.0

## 1. Tổng Quan Hệ Thống (System Overview)

Hệ thống được thiết kế để chuyển đổi dữ liệu lá số Tử Vi thành các phân tích tâm lý và định hướng cuộc sống. Khác với các hệ thống tử vi truyền thống, **Kabala Engine** không cổ súy mê tín dị đoan hay xem bói.

Hệ thống tập trung vào:

1. **Chẩn đoán (Diagnosis):** Tìm nguyên nhân khổ đau từ **Lòng Tham** và **Cái Tôi**.
2. **Kê toa (Prescription):** Đưa ra giải pháp dựa trên **Vòng tròn Hiếu Đạo** và thực hành **Thiền định**.

---

## 2. Cấu Trúc Dữ Liệu Quy Tắc (Data Structure)

Mỗi quy tắc (Rule) được lưu trữ dưới dạng JSON Object chuẩn hóa để đảm bảo khả năng mở rộng.

```json
{
  "rule_id": "STRING_UNIQUE",
  "domain": "ENUM [PERSONALITY, CAREER, WEALTH, RELATIONSHIP, HEALTH]",
  "priority_level": "INTEGER [1-5]",
  "conditions": {
    "palace_target": "STRING [Mệnh, Quan, Tài, Phu Thê, Tật Ách...]",
    "primary_stars": ["LIST_OF_STRINGS"],
    "auxiliary_stars": {
      "include": ["LIST_OF_STRINGS"],
      "exclude": ["LIST_OF_STRINGS"]
    },
    "brightness": "ENUM [Miếu, Vượng, Đắc, Hãm]",
    "modifiers": ["Tuần", "Triệt", "Vòng Tràng Sinh"]
  },
  "kabala_output": {
    "phenomenon": "STRING (Mô tả hiện tượng đời sống)",
    "root_cause_analysis": "STRING (Phân tích gốc rễ từ Ego/Greed)",
    "actionable_insight": "STRING (Lời khuyên hành động)",
    "spiritual_practice": "STRING (Bài tập Thiền/Luân xa cụ thể)"
  }
}
```

---

## 3. Chi Tiết Rules & Conditions (Detailed Logic)

### A. MODULE TÍNH CÁCH & CÁI TÔI (KABALA EGO)

**Mục tiêu:** Giúp người dùng thấu hiểu bản thân, nhận diện "Cái Tôi" (Ego) và "Lòng Tham" (Greed).

#### Rule A.01: Nhóm Lãnh Đạo & Cái Tôi Lớn (The Emperor Archetype)

**Điều kiện (Trigger):**
- Cung Mệnh có: Tử Vi, Thiên Phủ, hoặc Thái Dương (Miếu/Vượng).
- Hội hợp: Hóa Quyền, Tả Phù, Hữu Bật.
- Không gặp: Tuần, Triệt.

**Luận giải Kabala:**
- **Hiện tượng:** Có khí chất lãnh đạo, tự tin, quang minh.
- **Gốc rễ (Root Cause):** Cái Tôi quá lớn. Khi cái tôi chi phối, người dùng dễ rơi vào sự ích kỷ và tự cao tự đại.
- **Giải pháp (Solution):**
  - Thực hành bài học "Khiêm Tốn": Nhận thức giới hạn của bản thân.
  - Áp dụng Đạo An: Giữ tâm thế vững vàng nhưng thanh thản, không bị danh vọng chi phối.

#### Rule A.02: Nhóm Nội Tâm & Xung Đột (The Inner Conflict)

**Điều kiện (Trigger):**
- Cung Mệnh có: Cự Môn, Thiên Đồng (Hãm địa).
- Gặp sát tinh: Hóa Kỵ, Đà La, Linh Tinh.

**Luận giải Kabala:**
- **Hiện tượng:** Đa nghi, hay suy nghĩ tiêu cực, tâm trí thiếu bình an.
- **Gốc rễ:** Thiếu chữ "An" trong tâm hồn.
- **Giải pháp (Solution):**
  - Thiền An (Peaceful Meditation): Sử dụng thiền định để tạo ra sự yên bình và tập trung tinh thần.
  - Tìm kiếm niềm vui từ những điều giản đơn để giảm bớt sự đố kỵ.

### B. MODULE CÔNG DANH & SỰ NGHIỆP (KABALA CAREER)

**Mục tiêu:** Định hướng nghề nghiệp trong bối cảnh VUCA và xu hướng 20 năm tới (2024-2043).

#### Rule B.01: Nhóm Tiên Phong & Khởi Nghiệp (Warrior/Startup)

**Điều kiện (Trigger):**
- Cung Quan Lộc/Mệnh có bộ: Sát Phá Tham (Thất Sát, Phá Quân, Tham Lang).
- Đắc địa hoặc gặp: Hóa Quyền, Thiên Mã, Kình Dương.

**Luận giải Kabala:**
- **Xu hướng:** Phù hợp môi trường biến động cao, startup, lực lượng vũ trang hoặc kinh doanh mạo hiểm.
- **Lưu ý:** Cần tránh để Lòng Tham quyền lực dẫn lối sai lầm.
- **Giải pháp (Solution):**
  - Rèn luyện kỹ năng quản trị cảm xúc trong môi trường áp lực.
  - Tìm kiếm Ý nghĩa cuộc sống qua hành động và quan hệ với người khác thay vì chỉ chạy theo thành tích.

#### Rule B.02: Nhóm Chăm Sóc & Chữa Lành (Healer/Service)

**Điều kiện (Trigger):**
- Cung Quan Lộc có: Cơ Nguyệt Đồng Lương hoặc Thiên Lương chủ tọa.
- Hội sao: Thiên Quan, Thiên Phúc, Giải Thần.

**Luận giải Kabala:**
- **Xu hướng:** Rất hợp với ngành Giáo dục, Y tế, và đặc biệt là Tâm linh/Chữa lành - xu hướng nghề nghiệp tương lai.
- **Giải pháp (Solution):**
  - Phát triển năng lực Thấu cảm và Yêu thương (Luân xa 4).
  - Lấy việc phụng sự cộng đồng làm niềm vui.

### C. MODULE TÀI LỘC (WEALTH & FINANCE)

**Mục tiêu:** Đạt được sự giàu có thông qua sự "Biết Đủ" và vòng tròn Hiếu Đạo.

#### Rule C.01: Tài Lộc Bền Vững (Stable Wealth)

**Điều kiện (Trigger):**
- Cung Tài Bạch có: Vũ Khúc, Thái Âm (Sáng), Thiên Phủ.
- Hội: Lộc Tồn, Hóa Lộc.
- Không gặp: Không Kiếp.

**Luận giải Kabala:**
- **Hiện tượng:** Khả năng quản lý tài chính xuất sắc, tích lũy tốt.
- **Gốc rễ:** Đây là quả ngọt của Phúc đức.
- **Giải pháp (Solution):**
  - Duy trì vòng tròn Tài -> Hiếu: Dùng tài chính để chăm sóc cha mẹ và người thân.
  - Tránh để sự giàu có làm phình to cái Tôi.

#### Rule C.02: Phá Tài Do Tham Vọng (Volatile Wealth)

**Điều kiện (Trigger):**
- Cung Tài Bạch có: Tham Lang (Hãm), Phá Quân.
- Gặp: Địa Không, Địa Kiếp, Song Hao.

**Luận giải Kabala:**
- **Hiện tượng:** Kiếm tiền nhanh nhưng mất nhanh, đầu tư mạo hiểm.
- **Gốc rễ:** Bị chi phối bởi Lòng Tham vật chất quá mức, muốn nhiều hơn những gì mình có.
- **Giải pháp (Solution):**
  - Thực hành bài học "Biết Đủ": Hài lòng với những gì đang có.
  - Kiểm soát ham muốn "muốn nhiều hơn" để tránh khổ đau.

### D. MODULE TÌNH DUYÊN (RELATIONSHIPS)

**Mục tiêu:** Xây dựng mối quan hệ hòa hợp bằng cách giảm bớt cái Tôi.

#### Rule D.01: Khắc Khẩu & Xung Đột

**Điều kiện (Trigger):**
- Cung Phu Thê có: Cự Môn, Thất Sát.
- Gặp: Hóa Kỵ, Cô Thần, Quả Tú.

**Luận giải Kabala:**
- **Hiện tượng:** Dễ tranh cãi, cảm thấy cô đơn trong hôn nhân.
- **Gốc rễ:** Xung đột do Cái Tôi của cả hai đều lớn, đặt nhu cầu bản thân lên trên.
- **Giải pháp (Solution):**
  - Thực hành Thiền Nhân Từ (Loving-kindness Meditation) để mở rộng lòng bao dung.
  - Học cách hạ cái tôi xuống để thấu hiểu đối phương.

### E. MODULE SỨC KHỎE & LUÂN XA (HEALTH & CHAKRAS)

**Mục tiêu:** Chữa lành cơ thể và cân bằng năng lượng thông qua Luân xa.

#### Rule E.01: Căng Thẳng Thần Kinh (Luân Xa 6 & 7)

**Điều kiện (Trigger):**
- Cung Tật Ách có: Hỏa Tinh, Linh Tinh, Thiên Cơ (Hãm).

**Luận giải Kabala:**
- **Vấn đề:** Stress, mất ngủ, đau đầu, suy nghĩ quá nhiều.
- **Liên hệ Luân Xa:** Mất cân bằng Luân xa 6 (Trí tuệ) và Luân xa 7 (Khai sáng) - liên quan đến não bộ và thần kinh.
- **Giải pháp (Solution):**
  - Sử dụng nhạc tần số Hz để cân bằng Luân xa.
  - Thiền định để đưa não bộ về trạng thái tĩnh lặng.

#### Rule E.02: Tiêu Hóa & Lo Âu (Luân Xa 3)

**Điều kiện (Trigger):**
- Cung Tật Ách có: Thiên Phủ (gặp Tuần/Triệt) hoặc Tham Lang.

**Luận giải Kabala:**
- **Vấn đề:** Dạ dày kém, tiêu hóa rối loạn.
- **Liên hệ Luân Xa:** Tắc nghẽn Luân xa 3 (Quyền lực/Tự trọng) - liên quan đến hệ tiêu hóa.
- **Giải pháp (Solution):**
  - Tập trung vào sự Cân Bằng trong ăn uống và cảm xúc.

---

## 4. Logic Tích Hợp (Integration Logic)

Để hệ thống hoạt động chính xác theo tinh thần Kabala, cần áp dụng các logic ưu tiên sau:

### Nguyên tắc "An làm gốc" (The "Peace" Core)

Dù lá số tốt hay xấu, kết luận cuối cùng luôn phải hướng người dùng về trạng thái "An" (Bình an nội tâm).

**Logic:** Nếu lá số giàu (Tài Bạch tốt) nhưng Mệnh có Không Kiếp (Tâm bất an) => Đánh giá tổng quan là "Chưa trọn vẹn" -> Khuyên tu dưỡng nội tâm.

### Nguyên tắc "Vòng Tròn Hiếu Đạo"

Sử dụng vòng tròn Hiếu -> Đạo -> Đức -> Phúc -> Tài làm lộ trình cải vận.

Nếu lá số xấu (Hãm địa), hệ thống sẽ đề xuất bắt đầu lại từ chữ "Hiếu" (đối xử tốt với cha mẹ) để kích hoạt lại vòng tròn năng lượng tích cực.

### Tính năng động của Thiền Định

Tùy vào vấn đề của lá số, hệ thống gợi ý phương pháp thiền cụ thể: Thiền hơi thở, Thiền quán tưởng, hay Thiền nhân từ.

---

## Tài Liệu Tham Khảo

Tài liệu này được xây dựng dựa trên kiến thức Tử Vi Đẩu Số kết hợp với hệ thống tư tưởng Đạo An và dữ liệu từ Kabala.vn.
