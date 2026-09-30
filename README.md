Install PHP:

powershell -c "& ([ScriptBlock]::Create((irm 'https://www.php.net/include/download-instructions/windows.ps1'))) -Version 8.5"

git clone https://github.com/kdobro2/my-backend.git
cd my-backend

composer install

cp .env.example .env

In .env:

# DB_CONNECTION=sqlite

# DB_HOST=127.0.0.1

# DB_PORT=3306

# DB_DATABASE=laravel

# DB_USERNAME=root

# DB_PASSWORD=

SESSION_DRIVER=file

run:

in storage/app create file: places.json

storage/app/places.json

[
{
"id": 1,
"name": "Example Restaurant",
"category": "restaurant",
"cost": "$$",
"added": "2026-09-30",
"beenThere": false
},
{
"id": 2,
"name": "Example Museum",
"category": "museum",
"cost": "$",
"added": "2026-09-29",
"beenThere": true
}
]

php artisan serve

endpoints:

GET /api/places
GET /api/places/{id}
POST /api/places/{id}/edit
POST /api/places/{id}/been-there
DELETE /api/places/{id}
