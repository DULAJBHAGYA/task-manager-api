# BW Media Task Management Platform

A comprehensive Laravel-based task management system designed for BW Media's digital marketing agency to streamline project management and team coordination.

## Features

- **Project Management**: Create, update, and track client projects
- **Task Management**: Full CRUD operations for tasks with status tracking
- **Real-time Visibility**: Track task progress and project status
- **Team Assignment**: Assign tasks to team members
- **Priority Management**: Set task priorities (low, medium, high, urgent)
- **Due Date Tracking**: Monitor deadlines and overdue tasks
- **Search & Filtering**: Advanced filtering and search capabilities
- **Statistics Dashboard**: Comprehensive project and task analytics
- **RESTful API**: Complete API endpoints for all operations
- **JSON Responses**: Clean, structured JSON API responses

## Technology Stack

- **Backend**: Laravel 11 (PHP 8.1+)
- **Database**: MySQL (production) / SQLite (development)
- **Authentication**: JWT (JSON Web Tokens)
- **API**: RESTful API with JSON responses
- **Type**: Pure API Backend (No Frontend)

## Prerequisites

- PHP 8.1 or higher
- Composer
- SQLite (included with PHP) or MySQL/PostgreSQL

## Installation

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

The API will be available at `http://localhost:8000/api` for all endpoints.

## Project & Task Statuses

### Project Statuses
- **`active`** - Project is currently in progress (default)
- **`completed`** - Project has been finished
- **`on_hold`** - Project is temporarily paused
- **`cancelled`** - Project has been cancelled/terminated

### Task Statuses
- **`pending`** - Task is created but not started (default)
- **`in_progress`** - Task is currently being worked on
- **`completed`** - Task has been finished

### Task Priorities
- **`low`** - Low priority tasks
- **`medium`** - Medium priority tasks (default)
- **`high`** - High priority tasks
- **`urgent`** - Urgent tasks requiring immediate attention

## Email Verification

The API requires **email verification** before users can login:

### Registration Process
1. **Register**: User provides name, email, and password
2. **Verification Required**: System sends verification email (logged to Laravel log)
3. **Verify Email**: User clicks verification link or uses API endpoint
4. **Login**: User can now login with verified email

### Verification Methods
- **Email Link**: Check `storage/logs/laravel.log` for verification URL
- **API Endpoint**: `GET /api/auth/verify-email?token={token}&email={email}`
- **Resend**: `POST /api/auth/resend-verification` if needed

### Security Features
- **24-hour token expiry** for verification links
- **One-time use tokens** (deleted after verification)
- **URL encoding support** for email addresses
- **Login blocked** until email is verified

## Task Types

The system supports **two types of task creation**:

### 1. Project Tasks
- **Purpose**: Tasks that belong to a specific project
- **Creation**: Include `project_id` in the request
- **Example**:
  ```json
  {
    "project_id": 1,
    "title": "Design homepage",
    "description": "Create wireframes for homepage",
    "priority": "high",
    "status": "pending"
  }
  ```

### 2. Standalone Tasks
- **Purpose**: Personal tasks or general todos not tied to any project
- **Creation**: Omit `project_id` from the request
- **Example**:
  ```json
  {
    "title": "Buy groceries",
    "description": "Get milk and bread",
    "priority": "medium",
    "status": "pending"
  }
  ```

### Task Filtering
- **All tasks**: `GET /api/tasks`
- **Project tasks only**: `GET /api/tasks?project_id=1`
- **Standalone tasks only**: `GET /api/tasks?project_id=standalone`

## API Endpoints

### Authentication
- `POST /api/auth/register` - Register a new user (requires email verification)
- `POST /api/auth/login` - Login user and get JWT token (requires verified email)
- `GET /api/auth/verify-email` - Verify email address with token
- `POST /api/auth/resend-verification` - Resend email verification
- `GET /api/user` - Get authenticated user (requires Bearer token)
- `POST /api/auth/logout` - Logout user (requires Bearer token)
- `POST /api/auth/refresh` - Refresh JWT token (requires Bearer token)

### Projects
- `GET /api/projects` - List all projects (requires Bearer token)
- `POST /api/projects` - Create a new project (requires Bearer token)
- `GET /api/projects/{id}` - Get a specific project (requires Bearer token)
- `PUT /api/projects/{id}` - Update a project (requires Bearer token)
- `DELETE /api/projects/{id}` - Delete a project (requires Bearer token)
- `GET /api/projects/statistics` - Get project statistics (requires Bearer token)

### Tasks
- `GET /api/tasks` - List all tasks (requires Bearer token)
- `POST /api/tasks` - Create a new task (requires Bearer token)
- `GET /api/tasks/{id}` - Get a specific task (requires Bearer token)
- `PUT /api/tasks/{id}` - Update a task (requires Bearer token)
- `DELETE /api/tasks/{id}` - Delete a task (requires Bearer token)
- `GET /api/tasks/statistics` - Get task statistics (requires Bearer token)

## API Usage Examples

### Authentication
```bash
# Register a new user (requires email verification)
POST /api/auth/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}

# Verify email address (check Laravel log for verification URL)
GET /api/auth/verify-email?token={verification_token}&email=john@example.com

# Resend verification email
POST /api/auth/resend-verification
{
    "email": "john@example.com"
}

# Login (requires verified email)
POST /api/auth/login
{
    "email": "john@example.com",
    "password": "password123"
}
```

### Project Management
```bash
# Create a project
POST /api/projects
{
    "name": "Website Redesign",
    "description": "Complete website overhaul",
    "client_name": "ABC Company",
    "status": "active",
    "start_date": "2024-01-01",
    "end_date": "2024-03-31"
}

# Get all projects
GET /api/projects

# Get project statistics
GET /api/projects/statistics
```

### Task Management
```bash
# Create a project task
POST /api/tasks
{
    "project_id": 1,
    "title": "Design homepage",
    "description": "Create wireframes and mockups",
    "priority": "high",
    "status": "pending",
    "due_date": "2024-02-15"
}

# Create a standalone task
POST /api/tasks
{
    "title": "Buy groceries",
    "description": "Get milk, bread, and eggs",
    "priority": "medium",
    "status": "pending"
}

# Get all tasks
GET /api/tasks

# Filter tasks
GET /api/tasks?project_id=1
GET /api/tasks?status=pending
GET /api/tasks?priority=high
GET /api/tasks?project_id=standalone
```

## Database Structure

### Tables
- **`users`** - User authentication and profile data
- **`projects`** - Project information with client details
- **`tasks`** - Task data with optional project association

### Key Features
- **Foreign Key Constraints**: Proper relationships between tables
- **Nullable Fields**: `project_id` in tasks table allows standalone tasks
- **Cascade Deletes**: Deleting a project removes all associated tasks
- **Timestamps**: Automatic created_at and updated_at tracking
- **Soft Deletes**: Safe deletion with data preservation

### Database Schema
```sql
-- Projects Table
projects: id, user_id, name, description, client_name, status, start_date, end_date, timestamps

-- Tasks Table  
tasks: id, user_id, project_id (nullable), title, description, status, priority, assigned_to, due_date, completed_at, timestamps

-- Users Table
users: id, name, email, email_verified_at, password, timestamps
```

## Testing the API

### Using cURL
```bash
# Test the API health
curl http://localhost:8000/api/projects

# Get task statistics
curl http://localhost:8000/api/tasks/statistics
```

### Using Postman
1. Import the API collection
2. Set base URL to `http://localhost:8000/api`
3. Test all endpoints with sample data

### Using API Testing Tools
- **Postman** - GUI-based API testing
- **Insomnia** - Lightweight API client
- **Thunder Client** - VS Code extension
- **curl** - Command line tool

## Sample Data

The application includes sample data:
- 5 sample projects with different statuses (active, completed, on_hold, cancelled)
- 15 sample tasks across all projects and standalone tasks
- Various priorities (low, medium, high, urgent) and statuses for testing
- Mix of project tasks and standalone tasks for comprehensive testing

## Testing

1. Start the development server: `php artisan serve`
2. Use API testing tools like Postman, Insomnia, or curl to test API endpoints
3. Test all CRUD operations for projects and tasks
4. Verify authentication and authorization
5. Check statistics endpoints for data validation

## License

This project is licensed under the MIT License.

---

**BW Media Task Management Platform** - Streamlining project management for digital marketing agencies.