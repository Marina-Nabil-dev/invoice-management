# Invoice Management System

This is a Laravel-based Invoice Management System that allows users to manage invoices and customers with different levels of permissions for Admins and Employees. The system also includes a RESTful API for external integrations.

## Features

1. **Invoice Management**
- Create, view, update, and delete invoices.
- Assign invoices to customers.
- Search invoices by customer name, invoice date, amount, or payment status.

2. **Customer Management**
3. **User Roles and Permissions**
- Admin: Full access to create, update, and delete invoices. 
- Employee: Limited access to only update existing invoices.
- Role management is done using Spatie Roles and Permissions.

4. **Action Logbook**
 - Track all actions (create, update, delete) on invoices. 
 - Logs the user, user role, action performed, and timestamp. 
 - Uses Laravel Activity Log for tracking.

5. **RESTful API**
- API endpoints for managing invoices with authentication.

6. **Pagination**
- Pagination of invoice records (default 10 per page) with navigation options.
7. **Advanced Search**
- Search for invoices based on customer name, invoice date, amount, or payment status.
8. **Technologies Used**
- Laravel (PHP framework)
- Filament (Admin Panel)
- Spatie Roles and Permissions (Role management)
- Laravel Activity Log (Action tracking)
- Postman (API testing and documentation)

## Installation
1. Clone the repository:
- git clone https://github.com/Marina-Nabil-dev/invoice-management.git
- cd invoice-management
2. Install Dependencies
 - composer install
 - npm install && npm run dev
3. Environment Configuration
- Copy the .env.example file to .env
4. Generate Application Key
- php artisan key:generate
5. Database Configuration
 - php artisan migrate --seed
6. Start the Development Server
 - php artisan serve

## Usage Instructions

### Access the Admin Panel

1. URL: http://localhost:8000/admin

2. Login Credentials: Use the default admin credentials created via the database seeder.

### API Authentication

- Use an API token for employee and admin roles.

- Authentication: Bearer Token (Use Sanctum for API token-based authentication).
### Postman Documentation 
- https://documenter.getpostman.com/view/25039833/2sAYJ3DM3F
