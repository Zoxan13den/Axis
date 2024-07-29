# Laravel Project Management

This is a Laravel project management application.

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/Zoxan13den/Axis.git
    cd laravel-project-management
    ```

2. Install the dependencies:

    ```bash
    composer install
    npm install
    ```

3. Copy the `.env.example` file to `.env` and configure your environment variables:

    ```bash
    cp .env.example .env
    ```

4. Generate the application key:

    ```bash
    php artisan key:generate
    ```

5. Set up the database:

    - Configure your database settings in the `.env` file.

6. Run the migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

7. Install and compile the front-end assets:

    ```bash
    npm run dev
    ```

## Features

- Create, update, and delete projects.
- Create, update, and delete tasks within projects.
- Assign priorities and statuses to tasks.
- User authentication and authorization.

## Usage

1. Register a new user or log in with an existing account.
2. Create a new project.
3. Add tasks to the project.
4. Edit or delete tasks and projects.
