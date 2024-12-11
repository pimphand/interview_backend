```markdown
git clone 
cd interview_backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan test
```

```
### API Endpoints

### GET request to example server
GET http://interview_backend.test/api/employees
Content-Type: application/json
Authorization: "Bearer 7|5kyeEyiyFNW4l6wJzQMwCk3dfH93exF0UbD3Mh3K8dacb9f0"

### POST request to example server
POST http://interview_backend.test/api/employees
Content-Type: application/json
Accept: application/json
Authorization: "Bearer 1|PLxsnrW1BGrQz86a3YrD5fBdGceIV2ZHZJmr7i8t4cc6a4ca"

{
"name": "John Doe",
"email": "email@gmail.com",
"dob": "11-11-2011",
"city": "Lagos"
}

### PUT request to example server
PUT http://interview_backend.test/api/employees/9db31141-8ed5-4b05-8d01-a5c07c927c9c
Content-Type: application/json
Authorization: "Bearer 7|5kyeEyiyFNW4l6wJzQMwCk3dfH93exF0UbD3Mh3K8dacb9f0"


{
"name": "John Doe",
"email": "email@gmail.com",
"dob": "11-11-2041",
"city": "Lagos"
}

### DELETE request to example server
DELETE http://interview_backend.test/api/employees/9db31141-8ed5-4b05-8d01-a5c07c927c9c
Content-Type: application/json
Authorization: "Bearer 7|5kyeEyiyFNW4l6wJzQMwCk3dfH93exF0UbD3Mh3K8dacb9f0"


### PUT request to example server

PUT http://interview_backend.test/api/employees/activate/9db31208-0507-48f6-ba62-1534cc83b618
Content-Type: application/json
Authorization: "Bearer 7|5kyeEyiyFNW4l6wJzQMwCk3dfH93exF0UbD3Mh3K8dacb9f0"


{
"is_active": 0
}


### Login
POST http://interview_backend.test/api/login
Content-Type: application/json

{
"email": "test@gmai.com",
"password": "password"
}

### Logout
POST http://interview_backend.test/api/logout
Accept: application/json
Content-Type: application/json
Authorization: "Bearer 7|5kyeEyiyFNW4l6wJzQMwCk3dfH93exF0UbD3Mh3K8dacb9f0"

### User update status
PUT http://interview_backend.test/api/employees/activate/9db31208-0507-48f6-ba62-1534cc83b618
Content-Type: application/json
Authorization: "Bearer 7|5kyeEyiyFNW4l6wJzQMwCk3dfH93exF0UbD3Mh3K8dacb9f0"

{
"is_active": 0
}
```
