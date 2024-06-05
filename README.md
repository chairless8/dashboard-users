### User Management System
## Objective
Develop a simple yet robust web application that allows for managing user accounts. This includes functionalities for user registration, login, viewing, editing, and deleting user profiles.

# Technical Specifications
Backend Framework: PHP/Laravel
Frontend Framework: Vue.js with Vuetify
Database: MySQL or SQLite (candidate's choice)
Authentication: JWT (JSON Web Tokens)
TDD Framework: PHPUnit or PEST for Laravel

## Requirements
# API Development:
Design and implement RESTful APIs for user management (Create, Read, Update, Delete).
Use Laravel to develop these APIs following the TDD approach.
Ensure API endpoints are secure and accessible only to authenticated users.

# Frontend Development:
Develop the frontend using Vue.js and Vuetify.
Implement a login page that authenticates users through the API.
Create a dashboard for viewing, creating, editing, and deleting users. This should be accessible only to authenticated users.
Implement form validations on both frontend and backend to ensure data integrity.

# Authentication:
Implement secure login functionality.
Use JWT to manage user sessions and protect API routes.

# Testing:
Write comprehensive unit and feature tests using PHPUnit.
Tests must cover API endpoints, authentication mechanisms, and front-end interactions.

## Setup Instructions
# Prerequisites
PHP >= 8.0
Composer
Node.js and npm
MySQL or SQLite

# Backend Setup
Clone the repository.
Install dependencies using composer install.
Set up the environment file by copying .env.example to .env.
Generate the application key using php artisan key:generate.
Configure your database in the .env file.
Run migrations using php artisan migrate.
Start the development server using php artisan serve.

# Frontend Setup
Navigate to the frontend directory.
Install dependencies using npm install.
Start the development server using npm run dev.

# Running Tests
To run the tests, execute the following command: php artisan test.

## Application Architecture
The application follows a typical MVC structure.
Controllers handle incoming requests and return responses.
Models interact with the database.
Views present data to the user.

## Key Decisions
JWT Authentication was chosen for stateless authentication.
Vuetify was selected for a consistent and modern UI framework.
TDD Implementation
Test-Driven Development was integrated by writing tests before implementing the actual functionalities.
Used PHPUnit for backend testing to ensure API endpoints and authentication mechanisms work correctly.

## Conclusion
I enjoyed developing this application and look forward to any feedback. Given more time, I would have liked to deploy the application using Firebase and Fly.io, add state management with Pinia, and enhance the UI further.

## Contact
For any questions or feedback, feel free to reach out to me.