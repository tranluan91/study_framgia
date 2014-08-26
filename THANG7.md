shopping_cart
===============
Nội dung tìm hiểu session trong phalcon.
Đây là một sản phẩm cá nhân rất nhỏ để tìm hiểu lý thuyết cũng như thực tế khi làm việc với Phalcon.
Rất cảm ơn!

1. Cài đặt môi trường
  - Xem chi tiết tại: http://docs.phalconphp.com/en/latest/reference/install.html
  - Deploy web url dạng: cart.localhost.com
    Add cart.localhost.com vào
      /etc/hosts

        127.0.0.1 cart.localhost.com

    Config apache tại:

        /etc/apache2/apache2.conf
    thêm vào:

        <VirtualHost *:80>
          DocumentRoot /var/www/phalcon
          ServerName cart.localhost.com
          <Directory /var/www/phalcon>
            AllowOverride all
          </Directory>
        </VirtualHost>


    Tạo một symbolic link trỏ đến thư mục code của mình

      phalcon  trong /var/www/

        ln -s /path_source_code/phalcon phalcon

    Restart apache để hoàn thành:
        sudo service apache2 restart

2. Bắt đầu nào
  - xem config database tại
      /path_source_code/app/config/config.php
  - Tạo một database như trong file config.php
  - Chạy migration trong thư mục source code:
      phalcon migration run --migrations=migrations/
  - Thêm dữ liệu cho bảng products trong db: sử dụng câu lệnh insert into
  - Truy cập
      cart.localhost.com
    để xem kết quả
3. Kiến thức liên quan
  - Session trong Phalcon: http://docs.phalconphp.com/en/latest/reference/session.html

END
