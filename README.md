Порт: 8084

есть postman_collection.json

комманды
  php artisan migrate
  php artisan db:seed
  php artisan optimize
  
  

API

[POST] /login
  - Авторизация.
  body:
    username: "test"
    password: "123456"
  URL: 
    localhost:8084/api/login
    

[GET] /logout
  - Выход.
  URL:
    localhost:8084/api/logout
    
    
[GET] /refresh-token
  - Обновление токена.
  URL:
    localhost:8084/api/refresh-token
    
    
[POST] /create-link
  - Создание ссылки.
  body:
{
    "link": "https://google.com",
    "token": "goo",
    "private_status": false
}
  URL:
    localhost:8084/api/create-link
    
    
[GET] /my-links
  - Получение своих ссылок.
  URL:
    localhost:8084/api/my-links
    
    
[GET] /{username}/{token}
  - Переход по ссылке
  URL:
    localhost:8084/api/test/goo


