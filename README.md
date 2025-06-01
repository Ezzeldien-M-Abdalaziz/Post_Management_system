# PostHub - Post Management Platform


PostHub is a modern post management platform designed for content creators and teams to create, manage, and organize their posts efficiently.

## Features

- **User Authentication**
  - Secure login/logout functionality
  - Protected routes for authenticated users

- **Post Management**
  - Create, edit, and delete posts
  - Set post visibility (Public/Private)
  - View creation timestamps

- **Dashboard**
  - Clean, responsive interface
  - Paginated post listing
  - Quick action buttons for each post

- **Modern UI**
  - Built with Tailwind CSS for responsive design
  - Interactive modals for post creation/editing
  - Lucide icons for better visual cues

## Technologies Used

- **Frontend**
  - HTML5, CSS3, JavaScript
  - [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
  - [jQuery](https://jquery.com/) - JavaScript library
  - [Lucide](https://lucide.dev/) - Beautiful & consistent icons

- **Backend**
  - [Laravel](https://laravel.com/) - PHP framework
  - MySQL - Database system

## Installation

### Prerequisites
- PHP 8.0+
- Composer
- Node.js 14+
- MySQL 5.7+

### Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/Ezzeldien-M-Abdalaziz/Post_Management_system.git
   cd posthub
   cp .env.example .env
   php artisan key:generate    
   php artisan migrate
   php artisan db:seed

2. user Credentials
    user@example.com
    123

3. admin Credentials
    admin@example.com
    123

### postman link
https://www.postman.com/angular-nodejs/workspace/posthub

