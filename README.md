
## Stickee Developer challenge
### Requirement
Wally’s Widget Company is a widget wholesaler. They sell widgets in a variety of pack sizes:

- 250 widgets
- 500 widgets
- 1,000 widgets
- 2,000 widgets
- 5,000 widgets

Their customers can order any number of widgets, but they will always be given complete packs.
The company wants to be able to fulfil all orders according to the following rules:
1. Only whole packs can be sent. Packs cannot be broken open.
2. Within the constraints of Rule 1 above, send out no more widgets than necessary to fulfil
   the order.
3. Within the constraints of Rules 1 & 2 above, send out as few packs as possible to fulfil each
   order.

> **Note:** I have a query on what to put in UI side to show the result. I haven't done it on front end side. Output from the route returns the array.

### Solution
For this problem, we can use below solutions
1. A brute force approach using recursion
2. An efficient approach using the bottom-up approach of Dynamic Programming.

I have choosen the second way. In bottom-up approach, I have calculated the solution of smaller problems in an iterative way and store their result in array. Compare the solution with other sub solutions to find the optimal solution.

### Routes
In ```routes/web.php``` file, contain task related routes.
``` 
Route::get('/min-widgets-packs', WidgetController::class);
```

### Folders
Path to the code related files
- `app/Http/Controllers/WidgetController.php`
- `app/Action/WidgetPacks.php`
- `app/Models/MinimumWidgetsPacks.php`

### Installation
To install with Docker, run following commands:

```
git clone git@github.com:pranayBaddam/stickee-test.git
cd stickee-test
cp .env.example .env
```
Change following database credentials in .env file
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=stickee_test
DB_USERNAME=sail
DB_PASSWORD=password
```

Installing Composer Dependencies For Existing Applications
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
Configuring A Bash Alias
``` 
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

``` 
To start all of the Docker containers in the background, you may start Sail in "detached" mode:
``` 
sail up -d
``` 

Generate a new application key and database migration, data seeding
``` 
sail php artisan key:generate
sail php artisan migrate:fresh --seed
```
You can access the server at [http://localhost](http://localhost).
