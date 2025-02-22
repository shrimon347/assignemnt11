# Laravel Installation Guide with Breeze & Yajra DataTables

## Prerequisites

Make sure you have the following installed on your system:

- PHP (>=8.0)
- Composer
- MySQL or SQLite
- Node.js & NPM (for frontend assets)
- Docker (if using a containerized setup)

---

## Step 1: Install Laravel

```sh
composer create-project --prefer-dist laravel/laravel myapp
cd myapp
```

Setup your `.env` file:

```sh
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_database
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```sh
php artisan migrate
```

---

## Step 2: Install Laravel Breeze (Authentication System)

```sh
composer require laravel/breeze --dev
php artisan breeze:install
```

For **Blade authentication scaffolding**:

```sh
php artisan breeze:install blade
```

For **Vue/React authentication scaffolding**:

```sh
php artisan breeze:install vue
# or
php artisan breeze:install react
```

Install dependencies and build assets:

```sh
npm install
npm run dev
```

Run migrations:

```sh
php artisan migrate
```

Now, you can register and log in using Breeze authentication.

---

## Step 3: Install Yajra DataTables (Server-Side Processing)

```sh
composer require yajra/laravel-datatables-oracle
```

Publish configuration:

```sh
php artisan vendor:publish --tag=datatables
```

Add `DataTables` Service Provider (if not auto-discovered) in `config/app.php`:

```php
'providers' => [
    Yajra\DataTables\DataTablesServiceProvider::class,
],
```

---

## Step 4: Use Yajra DataTables in a Controller

Example of using DataTables in a controller (`ProductController.php`):

```php
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

public function index(Request $request) {
    if ($request->ajax()) {
        $products = Product::select(['id', 'name', 'category', 'price', 'stock']);
        return DataTables::of($products)
            ->addColumn('actions', function ($product) {
                return '<a href="'.route('products.edit', $product->id).'" class="btn btn-warning">Edit</a>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    return view('products.index');
}
```

---

## Step 5: Frontend DataTables Setup

Include DataTables CSS and JS in `resources/views/layouts/app.blade.php`:

```html
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
```

Initialize DataTables in `resources/views/products/index.blade.php`:

```html
<script>
$(document).ready(function() {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("products.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category' },
            { data: 'price', name: 'price' },
            { data: 'stock', name: 'stock' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
```

---

## Step 6: Run the Application

Start the Laravel development server:

```sh
php artisan serve
```

Access your application at `http://127.0.0.1:8000` 🚀

---

## Step 7: (Optional) Running Laravel in Docker

If using Docker, create a `docker-compose.yml`:

```yaml
version: '3.8'
services:
  app:
    image: php:8.0-fpm
    container_name: laravel_app
    working_dir: /var/www
    volumes:
      - .:/var/www
  webserver:
    image: nginx:alpine
    container_name: nginx_server
    volumes:
      - .:/var/www
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
    ports:
      - "8000:80"
  db:
    image: mysql:5.7
    container_name: mysql_db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: laravel
    ports:
      - "3306:3306"
```

Run the containers:

```sh
docker-compose up -d
```

Now, your Laravel app is running inside Docker! 🚀

---

## Conclusion

You've now successfully set up Laravel, added Breeze authentication, and integrated Yajra DataTables. Let me know if you need further improvements! 🎯
