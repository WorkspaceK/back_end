1. Create project: composer create-project larvel/laravel name_project
2. Create module:
   install module: composer require nwidart/laravel-modules
   fix composer.json: "autoload": {
   "psr-4": {
   "App\\": "app/",
   "Modules\\": "Modules/",
   }
   composer dump-autoload
   php artisan module:make name_module
3. Create database:
   php artisan make:migration create_name_table
   php artisan migrate
   php artisan make:migration add_avatar_to_admin_table --table=admins
   factor
   php artisan make:factory PostFactory
4. Create seeder
   php artisan make:seeder NameSeeder
   php artisan db:seed
   php artisan db:seed --class=UserTableSeeder
5. Create controller: 
   - php artisan module:make-controller NameController name_module
   - php artisan make:controller NameController
6. Create request: php artisan module:make-request NameRequest name_module
7. Create middleware: php artisan make:middleware adminAuthenticate
7. Create model
   php artisan make:model Admin
8. php artisan make:provider RiakServiceProvider
9. Send email:
    - Config .env
        - MAIL_MAILER=smtp
          MAIL_HOST=smtp.gmail.com
          MAIL_PORT=587
          MAIL_USERNAME=doanhgminh@gmail.com
          MAIL_PASSWORD=ygvqujupseauvrof
          MAIL_ENCRYPTION=tls
          MAIL_FROM_ADDRESS="hello@example.com"
          MAIL_FROM_NAME="${APP_NAME}"
    - create folder app/Mail: php artisan make:mail NameMail
    - code file app/mail/NameMail
10. Migrate
    - Đổi install doctrine/dbal
    - php artisan make:migration change_column_type_in_your_table_name
12. php artisan make:import UsersImport --model=User
13. Reset routes
    php artisan optimize
14. php artisan route:list

git checkout -b dev
git add .
git status
git commit -m "demo-git"
git push origin dev
----
git checkout main
git pull origin main
git merge origin dev
----
git checkout -b feature/login
-----------
git clone http://git.trianh.dev/doanhm-tranning/be-mini-project.git
cd be-mini-project
git switch --create main
touch README.md
git add README.md
git commit -m "add README"
git push --set-upstream origin main
-----------------------------------
cd existing_folder
git init --initial-branch=main
git remote add origin http://git.trianh.dev/doanhm-tranning/be-mini-project.git
git add .
git commit -m "Initial commit"
git push --set-upstream origin main
-----------------------------------
cd existing_repo
git remote rename origin old-origin
git remote add origin http://git.trianh.dev/doanhm-tranning/be-mini-project.git
git push --set-upstream origin --all
git push --set-upstream origin --tags


