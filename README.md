
# Project Name

A brief description of your project, e.g., "An event management platform that supports event creation, registration, feedback, and real-time notifications."

## Table of Contents

- [Project Name](#project-name)
- [Setup](#setup)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Configuration](#configuration)
    - [Running the Application Locally](#running-the-application-locally)
- [Testing](#testing)
- [Deployment](#deployment)
    - [Server Requirements](#server-requirements)
    - [Steps for Deployment](#steps-for-deployment)
- [Features](#features)
- [Assumptions](#assumptions)
- [License](#license)

---

## Setup

### Prerequisites

- **PHP** ^8.0
- **Composer**
- **Node.js** and **npm**
- **Laravel** ^10
- **MySQL** or another supported database

### Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/syedahnb/event-management-platform.git
   cd event-management-platform
   ```

2. **Install Composer and NPM Dependencies**:
   ```bash
   composer install
   npm install
   npm run dev
   ```

3. **Set Up Environment File**:
   Copy the `.env.example` file and create a `.env` file with necessary configuration:
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

### Configuration

1. **Database Configuration**: Set your database credentials in the `.env` file:
   ```plaintext
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

2. **Broadcasting and Real-Time Notifications (Pusher)**: Set up broadcasting with Pusher (or another compatible provider) in your `.env` file:
   ```plaintext
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=your_pusher_app_id
   PUSHER_APP_KEY=your_pusher_app_key
   PUSHER_APP_SECRET=your_pusher_app_secret
   PUSHER_APP_CLUSTER=your_pusher_app_cluster
   ```

3. **Mail Configuration**: Set up mail configuration if notifications are enabled.
   ```plaintext
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mail_username
   MAIL_PASSWORD=your_mail_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your-email@example.com"
   MAIL_FROM_NAME="Your App Name"
   ```

4. **Queue Configuration**: Configure `QUEUE_CONNECTION` in `.env` for queued jobs:
   ```plaintext
   QUEUE_CONNECTION=database
   ```

### Running the Application Locally

1. **Run Migrations and Seed the Database**:
   ```bash
   php artisan migrate --seed
   ```

2. **Start the Local Development Server**:
   ```bash
   php artisan serve
   ```

3. **Queue Worker**: Start the queue worker if using queued jobs for notifications:
   ```bash
   php artisan queue:work
   ```

---

## Testing

To run tests using PHPUnit, execute:

```bash
php artisan test
```

---

## Deployment

### Server Requirements

- **PHP** ^8.0 or above
- **MySQL** or another supported database
- **Web Server** (Apache, Nginx, etc.)
- **Redis** (if used as cache or queue driver)
- **Supervisor** (recommended for running queue workers)

### Steps for Deployment

1. **Clone the Repository on the Server**:
   ```bash
   git clone https://github.com/syedahnb/event-management-platform.git
   cd event-management-platform
   ```

2. **Install Dependencies**:
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   ```

3. **Set Up Environment File**:
   Configure the `.env` file with the correct production settings, similar to the local setup but with production values.

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**:
   ```bash
   php artisan migrate --force
   ```

6. **Set Permissions**:
   Ensure that `storage` and `bootstrap/cache` directories are writable:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

7. **Queue Worker Setup (Using Supervisor)**:
   Configure Supervisor to manage queue workers for production. Example configuration:

   ```plaintext
   [program:your-app-queue-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /path-to-your-app/artisan queue:work --sleep=3 --tries=3
   autostart=true
   autorestart=true
   user=your-username
   numprocs=1
   redirect_stderr=true
   stdout_logfile
