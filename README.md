# Food Ordering Application

A simple food ordering application built with Laravel 11, featuring role-based access control for admins and customers.

## Features

-   User authentication (login/register)
-   Role-based access (Admin & Customer)
-   Food menu management (Admin)
-   Order management system
-   Order item tracking
-   Responsive UI with Tailwind CSS

## Requirements

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL or other database system
-   Laravel 11

## Installation

Follow these steps to set up the project locally:

### 1. Clone the repository

```bash
git clone https://github.com/inii-man/food-app-sederhana.git
cd food-app-sederhana
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JavaScript dependencies

```bash
npm install
```

### 4. Create environment file

```bash
cp .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Configure database

Edit the `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 7. Run database migrations

```bash
php artisan migrate
```

### 8. (Optional) Seed the database

```bash
php artisan db:seed
```

### 9. Create storage symbolic link

```bash
php artisan storage:link
```

### 10. Build assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 11. Start the development server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default User Roles

After seeding, you can use the following default accounts:

-   **Admin**: Access to manage food menus and view all orders
-   **Customer**: Can browse menu and place orders

Check `database/seeders/UserSeeder.php` for default credentials.

## Project Structure

-   `app/Models/` - Eloquent models (User, FoodMenu, Order, OrderItem)
-   `app/Http/Controllers/` - Application controllers
-   `database/migrations/` - Database migration files
-   `resources/views/` - Blade templates
-   `routes/web.php` - Web routes

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
