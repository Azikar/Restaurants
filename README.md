

## Setup

docker-compose up

In new terminal

docker-compose exec laravel.test composer install
docker-compose exec laravel.test npm install
docker-compose exec laravel.test php artisan migrate
docker-compose exec laravel.test npm run watch-poll  or docker-compose exec laravel.test npm run dev



## Routes

To use admin panel you need to register first:
localhost:9000/registration

To log in
localhost:9000/login

Restaurants list is displayed in:
localhost:9000/restaurants

Restaurant creation is done in:
localhost:9000/createRestaurant

Reservation form is located in:
localhost:9000/

time selector is still a bit bugged since i did not have enough time to rewrite it :)
