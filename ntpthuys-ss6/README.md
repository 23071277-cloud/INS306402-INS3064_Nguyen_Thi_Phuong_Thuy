## Part 1: Normalization Challenge

### 1. Identify Violations (Phân tích lỗi thiết kế)
Dựa trên bảng dữ liệu thô `STUDENT_GRADES_RAW`, hệ thống gặp các vấn đề sau:
- **Redundancy (Dư thừa):** `StudentName` bị lặp lại cho mỗi môn học sinh viên đăng ký. `CourseName` và thông tin giảng viên bị lặp lại cho mỗi sinh viên tham gia khóa học.
- **Update Anomalies (Bất thường cập nhật):** Nếu `ProfessorEmail` thay đổi, ta phải cập nhật ở nhiều dòng. Nếu quên một dòng, dữ liệu sẽ bị mất tính nhất quán.
- **Transitive Dependency (Phụ thuộc bắc cầu):** Tồn tại phụ thuộc `CourseID` -> `ProfessorName` -> `ProfessorEmail`. Điều này vi phạm chuẩn 3NF vì email phụ thuộc vào một thuộc tính không phải khóa.

### 2. 3NF Decomposition (Tách bảng chuẩn 3NF)
Để tối ưu, dữ liệu được tách thành 4 bảng chính:

| Table Name | Primary Key | Foreign Key | Normal Form | Description |
| :--- | :--- | :--- | :--- | :--- |
| **Students** | `student_id` | None | 3NF | Lưu thông tin định danh sinh viên. |
| **Professors** | `professor_id` | None | 3NF | Lưu thông tin giảng viên (Email, Tên). |
| **Courses** | `course_id` | `professor_id` | 3NF | Lưu thông tin môn học và giảng viên phụ trách. |
| **Enrollments** | `student_id`, `course_id` | `student_id`, `course_id` | 3NF | Bảng trung gian lưu điểm số (Grade). |


## Part 2: Relationships

Dưới đây là phân tích các mối quan hệ và vị trí đặt Khóa ngoại (Foreign Key) cho các thực thể:

1. **AUTHOR – BOOK**
   - **Relationship Type:** One-to-Many (1:N)
   - **FK Location:** Table **BOOK** (Một tác giả có thể tạo ra nhiều sách).

2. **CITIZEN – PASSPORT**
   - **Relationship Type:** One-to-One (1:1)
   - **FK Location:** Table **PASSPORT** (Một hộ chiếu thuộc về một công dân duy nhất).

3. **CUSTOMER – ORDER**
   - **Relationship Type:** One-to-Many (1:N)
   - **FK Location:** Table **ORDER** (Một khách hàng có thể đặt nhiều đơn hàng).

4. **STUDENT – CLASS**
   - **Relationship Type:** Many-to-Many (N:N)
   - **FK Location:** **Junction Table** (Cần bảng trung gian để quản lý việc một sinh viên học nhiều lớp và ngược lại).

5. **TEAM – PLAYER**
   - **Relationship Type:** One-to-Many (1:N)
   - **FK Location:** Table **PLAYER** (Một đội bóng có nhiều cầu thủ ).