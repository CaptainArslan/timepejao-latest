# TimePejao - Transportation Management System

A comprehensive Laravel-based transportation management system with Filament admin panel, API documentation, and multi-role user management.

## 🚀 Features

### Core Functionality
- **Multi-Organization Management**: Support for multiple transportation organizations
- **User Management**: Passengers, Drivers, and Managers with role-based access
- **Vehicle Management**: Complete vehicle tracking with types, capacity, and documentation
- **Route Management**: Transport routes with scheduling and tracking
- **Schedule Management**: Advanced scheduling with status tracking and delay management
- **Payment Methods**: Polymorphic payment method support for multiple entities
- **Address Management**: Flexible address system for all entities
- **Location Tracking**: Current location tracking for vehicles and users

### Admin Panel (Filament)
- **Modern UI**: Clean, responsive admin interface
- **Resource Management**: Full CRUD operations for all entities
- **Data Visualization**: Tables, forms, and info lists
- **User-Friendly**: Intuitive navigation and operations

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Laravel Herd (recommended) or XAMPP/WAMP

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd timepejao
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=timepejao
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed
```

### 6. Passport Setup (API Authentication)
```bash
# Install Passport
php artisan passport:install

# Create personal access client (optional)
php artisan passport:client --personal
```

### 7. Storage Setup
```bash
# Create storage link
php artisan storage:link
```

### 8. Build Assets
```bash
# Build for production
npm run build

# Or run in development mode
npm run dev
```

## 🗄️ Database Structure

### Core Tables
- **organizations**: Transportation companies
- **organization_types**: Types of organizations
- **users**: System users (default Laravel)
- **passengers**: Passenger information and preferences
- **drivers**: Driver profiles and credentials
- **managers**: Organization managers
- **vehicles**: Vehicle information and specifications
- **vehicle_types**: Vehicle categories
- **transport_routes**: Route definitions
- **schedules**: Trip scheduling with status management
- **addresses**: Polymorphic address system
- **currect_locations**: Current location tracking
- **payment_methods**: Polymorphic payment methods
- **deice_tokens**: Device tokens for notifications

### Key Relationships
- Organizations have many Drivers, Vehicles, Routes, and Schedules
- Passengers belong to Organizations
- Schedules link Routes, Vehicles, Drivers, and Passengers
- All entities can have multiple Addresses (polymorphic)
- Payment Methods can belong to any entity (polymorphic)

## 🎯 Usage

### Admin Panel Access
1. Start the development server:
```bash
php artisan serve
```

2. Access the admin panel at: `http://localhost:8000/admin`

3. Create an admin user:
```bash
php artisan make:filament-user
```

### API Documentation
1. Generate API documentation:
```bash
php artisan l5-swagger:generate
```

### Development Commands

#### Database Operations
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset database
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name

# Create model with migration
php artisan make:model ModelName -m
```

#### Seeding
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=PassengerSeeder

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

#### Filament Operations
```bash
# Create new Filament resource
php artisan make:filament-resource ResourceName

# Create Filament user
php artisan make:filament-user

# Upgrade Filament
php artisan filament:upgrade
```

#### API Documentation
```bash
# Generate Swagger documentation
php artisan l5-swagger:generate

# Clear documentation cache
php artisan l5-swagger:generate --force
```

#### Asset Management
```bash
# Development mode (watch for changes)
npm run dev

# Production build
npm run build

# Install new npm package
npm install package-name
```

## 🔧 Configuration

### Filament Configuration
The admin panel is configured in `app/Providers/Filament/AdminPanelProvider.php`. Key settings:
- Panel ID: `admin`
- Path: `/admin`
- Domain: `localhost` (development)

### API Documentation Configuration
Swagger configuration is in `config/l5-swagger.php`:
- API Documentation URL: `/api/documentation`
- Documentation storage: `storage/api-docs`
- Scan path: `app/` directory

### Passport Configuration
API authentication is configured in `config/passport.php`:
- Personal access tokens enabled
- Token expiration: 1 year
- Refresh token rotation enabled

## 📊 Models and Relationships

### Core Models
- **Organization**: Central entity managing transportation services
- **Passenger**: End users of transportation services
- **Driver**: Service providers driving vehicles
- **Manager**: Organization administrators
- **Vehicle**: Transportation vehicles with specifications
- **TransportRoute**: Defined routes between locations
- **Schedule**: Trip scheduling with comprehensive status management
- **PaymentMethod**: Polymorphic payment handling
- **Address**: Flexible address system for all entities

### Key Features by Model

#### Schedule Model
- **Status Management**: Draft, Published, Cancelled, Completed, Archived
- **Trip Status**: Scheduled, Boarding, Departed, In Transit, Arrived, Delayed, Cancelled, Completed
- **Delay Handling**: Comprehensive delay tracking with reasons and resolution
- **Notification System**: Driver and passenger notification flags
- **Time Management**: Scheduled vs actual departure/arrival times

#### PaymentMethod Model
- **Polymorphic**: Can belong to any entity
- **Multiple Types**: Card, Bank Transfer, PayPal, etc.
- **Security**: Sensitive data hidden, masked display
- **Status Tracking**: Active, Inactive, Expired, Failed
- **Verification**: Verification status and default payment methods

## 🚀 Deployment

### Production Setup
1. **Environment Configuration**:
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false
```

2. **Optimize Application**:
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

3. **Build Assets**:
```bash
npm run build
```

4. **Database Migration**:
```bash
php artisan migrate --force
```

### Server Requirements
- PHP 8.2+
- MySQL 8.0+ or PostgreSQL 13+
- Redis (for caching and queues)
- Nginx or Apache
- SSL Certificate (recommended)

## 📝 API Endpoints

### Authentication
- `POST /oauth/token` - Get access token
- `POST /oauth/refresh` - Refresh access token
- `GET /user` - Get authenticated user

### Core Resources
- `GET /api/organizations` - List organizations
- `GET /api/passengers` - List passengers
- `GET /api/drivers` - List drivers
- `GET /api/vehicles` - List vehicles
- `GET /api/routes` - List transport routes
- `GET /api/schedules` - List schedules

*Note: Full API documentation available at `/api/documentation`*

## 🔒 Security Features

- **Laravel Passport**: OAuth2 API authentication
- **CSRF Protection**: Built-in CSRF protection
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Input sanitization
- **Password Hashing**: Secure password storage
- **API Rate Limiting**: Built-in rate limiting

## 📱 Frontend Technologies

- **Tailwind CSS**: Utility-first CSS framework
- **Vite**: Fast build tool and dev server
- **Filament**: Modern admin panel framework
- **Alpine.js**: Lightweight JavaScript framework

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/new-feature`
3. Commit changes: `git commit -am 'Add new feature'`
4. Push to branch: `git push origin feature/new-feature`
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Check the [Laravel Documentation](https://laravel.com/docs)
- Review [Filament Documentation](https://filamentphp.com/docs)

## 🔄 Changelog

### Version 1.0.0
- Initial release with core transportation management features
- Filament admin panel implementation
- API documentation with Swagger
- Multi-role user management
- Comprehensive scheduling system
- Payment method integration
- Address and location management

---

**Built with ❤️ using Laravel, Filament, and modern web technologies.**
