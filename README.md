# BW Media Task Management Platform

A comprehensive Laravel-based task management system designed for BW Media's digital marketing agency to streamline project management and team coordination.

## 🚀 Features

- **Project Management**: Create, update, and track client projects
- **Task Management**: Full CRUD operations for tasks with status tracking
- **Real-time Visibility**: Track task progress and project status
- **Team Assignment**: Assign tasks to team members
- **Priority Management**: Set task priorities (low, medium, high, urgent)
- **Due Date Tracking**: Monitor deadlines and overdue tasks
- **Search & Filtering**: Advanced filtering and search capabilities
- **Statistics Dashboard**: Comprehensive project and task analytics
- **RESTful API**: Complete API endpoints for all operations
- **Frontend Interface**: Modern, responsive web interface

## 🛠️ Technology Stack

- **Backend**: Laravel 12 (PHP 8.4+)
- **Database**: SQLite (development)
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)

## 📋 Prerequisites

- PHP 8.4 or higher
- Composer

## 🚀 Installation

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Start Server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to access the application.

## 📚 API Endpoints

### Projects
- `GET /api/projects` - List all projects
- `POST /api/projects` - Create a new project
- `GET /api/projects/{id}` - Get a specific project
- `PUT /api/projects/{id}` - Update a project
- `DELETE /api/projects/{id}` - Delete a project
- `GET /api/projects/statistics` - Get project statistics

### Tasks
- `GET /api/tasks` - List all tasks
- `POST /api/tasks` - Create a new task
- `GET /api/tasks/{id}` - Get a specific task
- `PUT /api/tasks/{id}` - Update a task
- `DELETE /api/tasks/{id}` - Delete a task
- `GET /api/tasks/statistics` - Get task statistics

## 🎨 Frontend Interface

A modern, responsive web interface is available at `http://localhost:8000` that provides:
- Dashboard with project and task statistics
- Project management interface
- Task management interface
- Real-time updates and dynamic content

## 📊 Sample Data

The application includes sample data:
- 5 sample projects with different statuses
- 15 sample tasks across all projects
- Various priorities and statuses for testing

## 🧪 Testing

1. Start the development server: `php artisan serve`
2. Open `http://localhost:8000` in your browser
3. Use the web interface to test all functionality
4. Use API testing tools like Postman or curl to test API endpoints

## 📄 License

This project is licensed under the MIT License.

---

**BW Media Task Management Platform** - Streamlining project management for digital marketing agencies.