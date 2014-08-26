Login with facebook account
============================
Sử dụng Facebook Api để login.

1. Tạo facebook Apps
  - Hướng dẫn tại: http://www.sanwebe.com/2011/11/creating-facebook-application-for-your-site
  - Tham khảo thêm https://developers.facebook.com/apps
2. Config
  - Sử dụng composer tải bộ PHP-SDK hỗ trợ facebook api với PHP
    + Composer: https://getcomposer.org/
    + Tạo file ```composer.json``` để cài đặt một package:
    ```
    {
      "require": {
      "facebook/php-sdk" : "*"
    }
    ```
    + Thêm config appId và secret cho facebook apps access token tại ```app/config/config.php```
    
    ```php
    'facebook'  => array(
      'appId' => '1519901488224583',
      'secret' => '966dbe45921a76e7424db5389da2840f',
      'scope'  => 'public_profile,email'
    ),
    ```
  - Config ```public/index.php``` để sử dụng facebook api PHP-sdk
  ```php
  require_once __DIR__ . "/vendor/autoload.php";
  ```
  - Trong ```config/service.php``` set facebook cho ```$di```

    ```php
    $di->setShared('facebook', function() use ($config) {
      return new \Facebook([
        'appId'     => $config->facebook->appId,
        'secret'    => $config->facebook->secret
      ]);
    });
    ```
3. Tạo bảng ```users``` lưu lại những user đã đăng nhập
  - Chạy migration:
  ```phalcon migration run --migrations=migration```
4. Bắt tay vào code nào
5. Tài liệu tham khảo
  - http://forum.phalconphp.com/discussion/1481/phalcon-facebook-login
  - Project HKT https://github.com/framgia/hkt

END
