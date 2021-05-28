

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

## Hour selection

In front-end hours already taken time spans are removed from hours selection further more after selecting start hour, hours which are below start and above initialy remove hours, are removed from end selection (there is known issue where for some reason user can select end hours as 0, i suspect this has to do with fact that time picker module is not fully transfered to vue 3)
