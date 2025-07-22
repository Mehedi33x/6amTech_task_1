## Installation
After cloning the project successfully ,install composer and node (node version: '^20.19.0)

for composer-----
```bash
composer install 
```
for node
```bash
npm install 
```
generate .env and declare the db configaration in .env
```bash
cp .env.example .env
```
generate app key
```bash
php artisan key:generate 
```
set jwt secret code for token verify
```bash
php artisan jwt:secret
```
run seeder to seed the user data (admin@test.com--123456,developer@test.com--123456)
```bash
php artisan migrate:fresh --seed
```
now if all those set , run this command to start the app and hit http://127.0.0.1:8000/
```bash
npm run dev
```

## Contributing

In this application, I have implemented authentication using JWT for a Laravel and Vue.js project. I have also added a role and permission system to ensure that access to specific routes, components, and features is properly restricted based on the user's assigned role.

For task management I use api authentication and based on that user can create,view,edit-update and destroy task(tested by POSTMAN).

I have inclueded the POSTMAN json inside the public directory
