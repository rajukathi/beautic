# AJAX CRUD for Laravel 

## Installation

Clone the repo
```
git clone https://github.com/jeanquark/ajax-crud.git
```

Move to the newly created folder and install all dependencies:
```
cd beautic
composer install
```

Create a new database, for example with phpMyAdmin. Then open the .env.example file, edit it to match your database name, username and password and save it as .env file. Once done, build tables with the following command:
```
php artisan migrate
```

Now fill the tables:
```
php artisan db:seed
```

Finally, generate the application key 
```
php artisan key:generate
```

npm install
```

npm run dev
```

Open your favorite browser and visit the newly created app.

## Features
1. List category - (Add, Delete)
2. List tag - (Add, Delete)
3. List product - (Add, Delete)
4. Delete a category will delete that product used this category.
5. Delete tab will remove tag from all product that uses this tag.

## Licence

Please refer to the [Laravel licence](https://opensource.org/licenses/MIT)
