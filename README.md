# Marie Bridal Management System

Hệ thống quản lý tiệm váy cưới với các chức năng chính: quản lý khách hàng, quản lý sản phẩm, quản lý hợp đồng, quản lý nhân viên và báo cáo thống kê.

## Yêu cầu chức năng

### Yêu cầu chung
- Giao diện responsive (Desktop & Mobile)
- Thiết kế hiện đại, trẻ trung
- Hỗ trợ tiếng Việt

### Phân quyền người dùng
- Admin: Toàn quyền quản lý hệ thống
- Manager: Quản lý nhân viên, khách hàng, công việc
- Pre-photo: Chụp ảnh trước cưới
- Wed-photo: Chụp ảnh ngày cưới
- Telesale: Tư vấn khách hàng qua điện thoại
- Fanpage: Tư vấn khách hàng qua mạng xã hội
- Sale: Tư vấn khách hàng tại cửa hàng (Khách đã đặt lịch hẹn hoặc khách vãn lai)
- Supervisor: Giám sát công việc
- Accountant: Kế toán
- Makeup: Trang điểm
- Tailor: May đo, sửa váy

### Quản lý Khách hàng
1. Thông tin khách hàng
   - Thông tin cơ bản (họ tên, SĐT)
   - Nguồn khách (Facebook, TikTok, điện thoại, khách vãn lai)
   - Lịch sử chăm sóc
   - Trạng thái khách hàng

2. Phân công chăm sóc
   - Phân chia khách cho telesale/fanpage
   - Chuyển giao khách giữa nhân viên
   - Theo dõi hiệu quả chăm sóc
   - Khách hàng có lịch hẹn đến cửa hàng thì nhân viên sale tự gán khách cho mình 
   - Sale có thể nhập thêm khách hàng vào dữ liệu nếu đó là khách vãn lai

3. Lịch hẹn
   - Đặt lịch hẹn khách
   - Thông báo lịch hẹn
   - Theo dõi trạng thái cuộc hẹn

### Quản lý sản phẩm
1. Váy cưới
   - Thông tin váy (mã, tên, hình ảnh)
   - Lịch thuê váy
   - Trạng thái váy

2. Lịch đặt váy
   - Xem lịch trống
   - Đặt lịch thuê
   - Kiểm tra trùng lịch

### Quản lý Nhân viên
1. Thông tin nhân viên
   - Quản lý tài khoản
     + Phân quyền truy cập
     + Cấp phát tài khoản
     + Reset mật khẩu

2. Chấm công
   - Check-in/check-out
     + QR code check-in
     + Xác thực WiFi
   - Theo dõi công
     + Calendar view theo tháng
     + Thống kê ngày công
     + Xuất báo cáo

3. Phân công công việc
   - Quản lý task
     + Tạo task mới
     + Phân công người thực hiện
     + Theo dõi tiến độ
   - Kanban board
     + Phân loại theo trạng thái
     + Timeline view
   - Báo cáo công việc
     + Đánh giá hoàn thành
     + Thống kê hiệu suất
     + Nhận xét task

4. Thưởng phạt
   - Ghi nhận thưởng phạt
     + Lý do thưởng/phạt
     + Số tiền
   - Phê duyệt
     + Quy trình duyệt
     + Thông báo tự động
     + Tích hợp tính lương
   - Báo cáo
     + Thống kê theo nhân viên
     + Thống kê theo thời gian
     + Xuất báo cáo

### Quản lý Hợp đồng
1. Tạo hợp đồng
   - Chọn loại hợp đồng
     + Hợp đồng thuê đồ cưới
     + Hợp đồng quay chụp pre wedding
     + Hợp đồng quay chụp ngày cưới
   - Liên kết thông tin
     + Chọn khách hàng
     + Chọn sản phẩm váy cưới
     + Kiểm tra trùng lịch tự động
     + Thêm thông tin thuê váy cưới vào sản phẩm theo hợp đồng
   - Xác nhận trùng lịch
     + Hiển thị cảnh báo nếu trùng
     + Cho phép xác nhận tiếp tục
     + Ghi chú lý do đặc biệt

2. Quản lý ghi chú
   - Thêm/sửa ghi chú
     + Nội dung yêu cầu của khách
     + Ghi chú nội bộ
     + Ghi chú sau khi ký hợp đồng chỉ là bản nháp, cần kế toán phê duyệt mới thành bản chính thức
   - Phân loại ghi chú
     + Theo mức độ ưu tiên
     + Theo bộ phận xử lý
   - Lịch sử cập nhật
     + Timeline các thay đổi
     + Người thực hiện
     + Thời gian cập nhật

3. Cập nhật hợp đồng
   - Quy trình phê duyệt
     + Tạo bản nháp
     + Gửi yêu cầu phê duyệt
     + Kế toán xác nhận
   - Theo dõi trạng thái
     + Chờ duyệt
     + Đã duyệt
     + Từ chối
   - Lưu trữ phiên bản
     + Bản nháp
     + Bản chính
     + Lịch sử thay đổi

4. Quản lý trả đồ
   - Kiểm tra hiện trạng
     + Form báo cáo tình trạng
     + Ghi chú chi tiết
   - Thông báo vi phạm
     + Tự động gửi đến quản lý
     + Đánh giá mức độ hư hỏng
     + Đề xuất xử lý
   - Timeline theo dõi
     + Lịch sử sử dụng
     + Các lần báo hỏng
     + Quá trình xử lý

5. Báo cáo quản lý
   - Báo cáo hiện trạng
     + Form ghi nhận tình trạng
     + Đề xuất thay thế/mua mới
     + Ước tính chi phí
   - Quy trình phê duyệt
     + Gửi đến admin
     + Kế toán xác nhận
     + Theo dõi trạng thái
   - Thống kê báo cáo
     + Theo loại sản phẩm
     + Theo thời gian
     + Chi phí phát sinh

6. Kiểm tra tình trạng
   - Tìm kiếm nâng cao
     + Theo mã sản phẩm
     + Theo khoảng thời gian
     + Theo trạng thái
   - Hiển thị kết quả
     + Lịch sử đặt/thuê
     + Trạng thái hiện tại
     + Dự kiến có thể thuê
   - Calendar view
     + Hiển thị lịch đặt
     + Đánh dấu ngày bận
     + Quick view chi tiết

### Báo cáo thống kê
1. Báo cáo doanh thu
   - Theo thời gian (ngày/tuần/tháng/năm)
   - Theo loại hợp đồng
   - Theo sản phẩm
   - So sánh các giai đoạn

2. Báo cáo khách hàng
   - Thống kê nguồn khách
   - Tỷ lệ chuyển đổi
   - Hiệu quả chăm sóc
   - Phân tích feedback

3. Báo cáo nhân sự
   - Thống kê chấm công
   - Đánh giá hiệu suất
   - Báo cáo thưởng phạt
   - KPIs theo nhân viên

4. Báo cáo sản phẩm
   - Tần suất cho thuê
   - Doanh thu theo mẫu
   - Chi phí bảo trì
   - Đánh giá hiệu quả

### Thông báo realtime
- Notification trong app
- Email thông báo
- Push notification trên mobile

## Cấu trúc trang

### 1. Dashboard (/)
- Thống kê tổng quan
  - Số lượng khách hàng mới trong ngày/tuần/tháng
  - Doanh thu theo ngày/tuần/tháng
  - Số lịch hẹn trong ngày
  - Số hợp đồng đã ký trong tháng
- Table view cho lịch hẹn
- Danh sách công việc cần làm
- Thông báo mới

### 2. Quản lý Khách hàng (/customers)
- Danh sách khách hàng
  - Table view với các filter
  - Thông tin cơ bản: tên, SĐT, nguồn, trạng thái
  - Timeline theo dõi
  - Phân công nhân viên chăm sóc
- Tạo mới khách hàng
- Chi tiết khách hàng
  - Thông tin cá nhân
  - Lịch sử chăm sóc
  - Lịch hẹn
  - Ghi chú
- Báo cáo khách hàng
  - Thống kê theo nguồn
  - Tỷ lệ chuyển đổi
  - Hiệu quả chăm sóc

### 3. Quản lý Sản phẩm (/products)
- Danh sách váy cưới
  - Grid view với hình ảnh
  - Thông tin: mã, tên, trạng thái
  - Lịch thuê
- Thêm mới váy
  - Upload hình ảnh
  - Nhập thông tin cơ bản
- Chi tiết váy
  - Thông tin chi tiết
  - Lịch sử cho thuê
  - Calendar view đặt lịch
- Báo cáo sản phẩm
  - Thống kê lượt thuê
  - Doanh thu theo mẫu
  - Tần suất sử dụng

### 4. Quản lý Nhân viên (/staff)
- Danh sách nhân viên
  + Table view với filters và search
  + Thông tin cơ bản: tên, vị trí, phòng ban
  + Trạng thái làm việc
- Chấm công
  + Calendar view theo tháng
  + Check-in/check-out qua QR/WiFi
  + Báo cáo chấm công
- Phân công công việc
  + Kanban board
  + Timeline/Gantt chart
  + Task management
- Thưởng phạt
  + Danh sách thưởng phạt
  + Form tạo mới
  + Báo cáo tổng hợp
- Báo cáo nhân sự
  + Thống kê theo phòng ban
  + Biểu đồ nhân sự
  + Xuất báo cáo

### 5. Quản lý Hợp đồng (/contracts)
- Danh sách hợp đồng
  + Table view với filters
  + Phân loại theo trạng thái
  + Quick actions
- Tạo mới hợp đồng
  + Form theo loại hợp đồng
  + Validation rules
  + Preview trước khi lưu
- Chi tiết hợp đồng
  + Thông tin cơ bản
  + Timeline cập nhật
  + Danh sách ghi chú
- Quản lý trả đồ
  + Form kiểm tra
  + Upload hình ảnh
  + Báo cáo vi phạm
- Báo cáo quản lý
  + Form báo cáo
  + Danh sách đề xuất
  + Thống kê tổng hợp
- Kiểm tra tình trạng
  + Form tìm kiếm
  + Calendar view
  + Kết quả chi tiết

## Tech Stack
- Frontend: React 19
- Dev language: JavaScript
- UI Components: Shadcn UI
- Styling: TailwindCSS
- State Management: React Query
- Form Handling: React Hook Form
- Routing: React Router
- Date Handling: Day.js
- Calendar: React Big Schedule

## Tính năng chính
- Responsive design (Desktop & Mobile)
- Dark/Light mode
- Đa ngôn ngữ (Tiếng Việt)
- Role-based access control
- Real-time notifications
- Export báo cáo
- Upload/Preview hình ảnh
- Calendar integration

### Database Schema
Chi tiết cấu trúc database và mối quan hệ giữa các bảng được mô tả trong sơ đồ ERD:
[Database ERD Diagram](erd.plantuml)

### WordPress Database Extension
1. Core Tables
   - mb_contracts: Quản lý hợp đồng
   - mb_products: Quản lý sản phẩm váy cưới
   - mb_customers: Quản lý khách hàng

2. History & Tracking Tables
   - mb_product_history: Lịch sử sản phẩm
   - mb_customer_history: Lịch sử khách hàng
   - mb_contract_history: Lịch sử hợp đồng
   - mb_product_maintenance: Lịch sử bảo trì
   - mb_customer_interactions: Chi tiết tương tác

3. Staff Management Tables
   - mb_staff_attendance: Chấm công nhân viên
   - mb_staff_tasks: Quản lý công việc
   - mb_staff_rewards: Thưởng phạt
   - mb_staff_schedules: Lịch làm việc

4. Appointment & Schedule Tables
   - mb_appointments: Lịch hẹn
   - mb_product_bookings: Lịch đặt váy

5. Notification System
   - mb_notifications: Lưu trữ thông báo
   - mb_notification_settings: Cấu hình thông báo
   - mb_notification_templates: Mẫu thông báo

### API Endpoints

1. Authentication
   - POST /wp-json/mb/v1/auth/login
   - POST /wp-json/mb/v1/auth/logout
   - GET /wp-json/mb/v1/auth/me

2. Customer Management
   - GET /wp-json/mb/v1/customers
   - POST /wp-json/mb/v1/customers
   - GET /wp-json/mb/v1/customers/{id}
   - PUT /wp-json/mb/v1/customers/{id}
   - GET /wp-json/mb/v1/customers/{id}/history
   - GET /wp-json/mb/v1/customers/{id}/interactions

3. Product Management
   - GET /wp-json/mb/v1/products
   - POST /wp-json/mb/v1/products
   - GET /wp-json/mb/v1/products/{id}
   - PUT /wp-json/mb/v1/products/{id}
   - GET /wp-json/mb/v1/products/{id}/history
   - GET /wp-json/mb/v1/products/{id}/maintenance
   - GET /wp-json/mb/v1/products/{id}/bookings

4. Contract Management
   - GET /wp-json/mb/v1/contracts
   - POST /wp-json/mb/v1/contracts
   - GET /wp-json/mb/v1/contracts/{id}
   - PUT /wp-json/mb/v1/contracts/{id}
   - GET /wp-json/mb/v1/contracts/{id}/history
   - POST /wp-json/mb/v1/contracts/{id}/notes
   - PUT /wp-json/mb/v1/contracts/{id}/status

5. Staff Management
   - GET /wp-json/mb/v1/staff
   - POST /wp-json/mb/v1/staff
   - GET /wp-json/mb/v1/staff/{id}
   - PUT /wp-json/mb/v1/staff/{id}
   - POST /wp-json/mb/v1/staff/attendance
   - GET /wp-json/mb/v1/staff/tasks
   - POST /wp-json/mb/v1/staff/tasks
   - GET /wp-json/mb/v1/staff/rewards

6. Appointment Management
   - GET /wp-json/mb/v1/appointments
   - POST /wp-json/mb/v1/appointments
   - PUT /wp-json/mb/v1/appointments/{id}
   - GET /wp-json/mb/v1/schedules
   - POST /wp-json/mb/v1/schedules

7. Notification System
   - GET /wp-json/mb/v1/notifications
   - PUT /wp-json/mb/v1/notifications/{id}/read
   - GET /wp-json/mb/v1/notifications/settings
   - PUT /wp-json/mb/v1/notifications/settings

8. Reports
   - GET /wp-json/mb/v1/reports/revenue
   - GET /wp-json/mb/v1/reports/customers
   - GET /wp-json/mb/v1/reports/staff
   - GET /wp-json/mb/v1/reports/products