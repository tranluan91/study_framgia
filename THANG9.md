Shopping cart using Redis (no-sql)
============================
Sử dụng Redis thay session cho shopping cart.
Nội dung project đặt trọng tâm vào việc tự học của tác giả. Nên bài viết chỉ mang tính hướng dần cơ bản, các chú ý và ưu nhược điểm khi sử dụng Redis với Phalcon.

1. Cài đặt Redis
  - Hướng dẫn tại:
    + http://redis.io/topics/quickstart
  - Cài đặt thêm Redis-commander giúp cho thao tác với redis dễ dàng hơn bằng GUI:
    + https://github.com/joeferner/redis-commander
2. Config
  - Configuration để sử dụng redis database ```config/config.php```:

  ```php
  'database_redis' => array(
        'host' => 'localhost',
        'port' => '6379',
        'database_number' => 1,
    ),
  ```
  - Config service để thao tác với redis ```config/service.php```:

  ```php
  $di['redis'] = function() use ($config) {
    $host = $config->database_redis->host;
    $port = $config->database_redis->port;
    $database_number = $config->database_redis->database_number;
    return compact("host", "port", "database_number");
  };
  ```
3. Tạo bảng ```carts``` lưu lại những item user đã chọn lưu trong redis
  - Vì carts được lưu tại redis nên chỉ cẩn tạo Model như sau: ```models/Carts.php```
  - Với key pattern dạng: ```cart:%s``` ```%s``` là ```user_id```, dữ liệu lưu trong redis sẽ có key như sau: ```cart:1```.

4. Chú ý
  - Các file ```libs/Model/``` được viết nhằm đơn giản hóa việc thao tác dữ liệu với Redis.
  - Các hàm được sử dụng nhiều:
    + ```find()```: tìm kiếm dữ liệu Redis theo key.
    + ```create()```: tạo bảng và ghi dữ liệu vào redis theo key.
    + ```get()```: get records trong bảng theo key, ranger.
    + ```delete()```: xóa tất cả records trong redis theo key.
    + ```count()```: đếm số lượng records trong redis theo key.
    + ```remove()```: xóa một record trong bảng theo key và index.
    + Ngoài ra còn một số hàm khác giúp cho việc thao tác dễ dàng hơn
5. Ưu nhược điểm
  - Ưu điểm:
    + Sử dụng redis giúp cho performance thao tác với dữ liệu rất nhanh.
    + Cú pháp đơn giản, tường minh.
    + Việc lưu trữ tốn ít bộ nhớ hơn.
  - Nhược điểm:
    + Vẫn chưa hỗ trợ các câu lệnh truy vấn đầy đủ như ở Mysql, tuy nhiên hoàn toàn có thể thao tác đầy đủ các chức năng khi hiểu rõ cấu trúc dữ liệu trên Redis.
  - Ví dụ: Redis không hỗ trợ xóa record theo index trong list. Tuy nhiên có thể lấy giá trị theo index trong list sử dụng ```LINDEX($key, $index)``` sau đó xóa record đó theo key và giá trị vừa lấy được ```LREM($key, $element)``` (tham khaorm hàm ```remove()``` trong ```libs/Model/RedisListModel.php```).
6. Tài liệu tham khảo
  - Redis.io : http://redis.io/
  - Techblog Framgia, tác giả Đinh Hoàng Long:
    + http://tech.blog.framgia.com/vn/?p=3365
    + http://tech.blog.framgia.com/vn/?p=4903

END
