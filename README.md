API:
1. cài đặt library laravel: composer install
2. Tạo database và config database: 
- cp .env.example .env
  Cập nhật file env của bạn như sau:
  DB_CONNECTION=mysql          
  DB_HOST=127.0.0.1            
  DB_PORT=3306                 
  DB_DATABASE=scientists_research_project   
  DB_USERNAME=root             
  DB_PASSWORD=   
3. Tạo key: php artisan key:generate
4. tạo bảng và data:
   php artisan migrate
   php artisan db:seed
5. Storage:link: php artisan storage:link
=> start: php artisan serve

FE: 
1. Cài thư viện node, antd
- npm install --legacy-peer-deps
- npm i antd
- Thư viện cũ nếu lỗi install anh search stack overflow nha
2. - cp .env.example .env
Cập nhật file env của bạn như sau:
     REACT_APP_API_URL=http://127.0.0.1:8000/api/
     STORAGE_URL=http://127.0.0.1:8000/storage
=> start: npm start hoặc npm dev(nếu dev)
