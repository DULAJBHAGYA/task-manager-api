# 🚀 Task Manager API Testing Guide

## 📋 Overview
This document provides comprehensive testing instructions for the Task Manager API with JWT authentication and user data isolation.

**Base URL:** `http://localhost:8000/api`  
**Authentication:** Bearer Token (JWT)

---

## 🔐 Authentication Endpoints

### 1. Register New User
**POST** `/auth/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2025-09-21T03:00:00.000000Z",
            "updated_at": "2025-09-21T03:00:00.000000Z"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

### 2. Login User
**POST** `/auth/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

### 3. Get Authenticated User
**GET** `/user`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "message": "User data retrieved successfully"
}
```

### 4. Logout User
**POST** `/auth/logout`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Successfully logged out"
}
```

### 5. Refresh Token
**POST** `/auth/refresh`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Token refreshed successfully",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

---

## 📁 Project Management Endpoints

### 1. List All Projects
**GET** `/projects`  
**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `status` (optional): `active`, `completed`, `on_hold`, `cancelled`
- `client_name` (optional): Filter by client name
- `search` (optional): Search in name, description, or client name
- `page` (optional): Page number for pagination

**Example:** `GET /projects?status=active&search=website&page=1`

**Response (200):**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "user_id": 1,
                "name": "E-commerce Website",
                "description": "Complete e-commerce platform development",
                "client_name": "TechCorp Solutions",
                "status": "active",
                "start_date": "2024-01-15T00:00:00.000000Z",
                "end_date": "2024-03-30T00:00:00.000000Z",
                "created_at": "2025-09-21T03:00:00.000000Z",
                "updated_at": "2025-09-21T03:00:00.000000Z",
                "tasks_count": 3
            }
        ],
        "first_page_url": "http://localhost:8000/api/projects?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/projects?page=1",
        "next_page_url": null,
        "path": "http://localhost:8000/api/projects",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    },
    "message": "Projects retrieved successfully"
}
```

### 2. Create New Project
**POST** `/projects`  
**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Mobile App Development",
    "description": "iOS and Android mobile application",
    "client_name": "StartupXYZ",
    "status": "active",
    "start_date": "2024-02-01",
    "end_date": "2024-06-30"
}
```

**Response (201):**
```json
{
    "success": true,
    "data": {
        "id": 2,
        "user_id": 1,
        "name": "Mobile App Development",
        "description": "iOS and Android mobile application",
        "client_name": "StartupXYZ",
        "status": "active",
        "start_date": "2024-02-01T00:00:00.000000Z",
        "end_date": "2024-06-30T00:00:00.000000Z",
        "created_at": "2025-09-21T03:00:00.000000Z",
        "updated_at": "2025-09-21T03:00:00.000000Z"
    },
    "message": "Project created successfully"
}
```

### 3. Get Single Project
**GET** `/projects/{id}`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "user_id": 1,
        "name": "E-commerce Website",
        "description": "Complete e-commerce platform development",
        "client_name": "TechCorp Solutions",
        "status": "active",
        "start_date": "2024-01-15T00:00:00.000000Z",
        "end_date": "2024-03-30T00:00:00.000000Z",
        "created_at": "2025-09-21T03:00:00.000000Z",
        "updated_at": "2025-09-21T03:00:00.000000Z",
        "tasks": [
            {
                "id": 1,
                "project_id": 1,
                "title": "Design Homepage",
                "description": "Create responsive homepage design",
                "status": "pending",
                "priority": "high",
                "assigned_to": 1,
                "due_date": "2024-02-15T00:00:00.000000Z",
                "completed_at": null,
                "created_at": "2025-09-21T03:00:00.000000Z",
                "updated_at": "2025-09-21T03:00:00.000000Z",
                "assigned_user": {
                    "id": 1,
                    "name": "John Doe",
                    "email": "john@example.com"
                }
            }
        ]
    },
    "message": "Project retrieved successfully"
}
```

### 4. Update Project
**PUT** `/projects/{id}`  
**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Updated Project Name",
    "description": "Updated description",
    "client_name": "Updated Client",
    "status": "completed",
    "start_date": "2024-01-01",
    "end_date": "2024-12-31"
}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "user_id": 1,
        "name": "Updated Project Name",
        "description": "Updated description",
        "client_name": "Updated Client",
        "status": "completed",
        "start_date": "2024-01-01T00:00:00.000000Z",
        "end_date": "2024-12-31T00:00:00.000000Z",
        "created_at": "2025-09-21T03:00:00.000000Z",
        "updated_at": "2025-09-21T03:00:00.000000Z"
    },
    "message": "Project updated successfully"
}
```

### 5. Delete Project
**DELETE** `/projects/{id}`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Project deleted successfully"
}
```

**Error Response (422) - If project has tasks:**
```json
{
    "success": false,
    "message": "Cannot delete project with existing tasks. Please delete all tasks first."
}
```

### 6. Get Project Statistics
**GET** `/projects/statistics`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "data": {
        "total_projects": 5,
        "active_projects": 3,
        "completed_projects": 1,
        "on_hold_projects": 1,
        "cancelled_projects": 0
    },
    "message": "Project statistics retrieved successfully"
}
```

---

## ✅ Task Management Endpoints

### 1. List All Tasks
**GET** `/tasks`  
**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `project_id` (optional): Filter by project ID
- `status` (optional): `pending`, `in_progress`, `completed`
- `assigned_to` (optional): Filter by assigned user ID
- `priority` (optional): `low`, `medium`, `high`, `urgent`
- `search` (optional): Search in title or description
- `page` (optional): Page number for pagination

**Example:** `GET /tasks?status=pending&priority=high&page=1`

**Response (200):**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "project_id": 1,
                "title": "Design Homepage",
                "description": "Create responsive homepage design",
                "status": "pending",
                "priority": "high",
                "assigned_to": 1,
                "due_date": "2024-02-15T00:00:00.000000Z",
                "completed_at": null,
                "created_at": "2025-09-21T03:00:00.000000Z",
                "updated_at": "2025-09-21T03:00:00.000000Z",
                "project": {
                    "id": 1,
                    "name": "E-commerce Website",
                    "client_name": "TechCorp Solutions"
                },
                "assigned_user": {
                    "id": 1,
                    "name": "John Doe",
                    "email": "john@example.com"
                }
            }
        ],
        "first_page_url": "http://localhost:8000/api/tasks?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/tasks?page=1",
        "next_page_url": null,
        "path": "http://localhost:8000/api/tasks",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    },
    "message": "Tasks retrieved successfully"
}
```

### 2. Create New Task
**POST** `/tasks`  
**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "project_id": 1,
    "title": "Implement User Authentication",
    "description": "Create login and registration system",
    "status": "pending",
    "priority": "high",
    "assigned_to": 1,
    "due_date": "2024-03-01"
}
```

**Response (201):**
```json
{
    "success": true,
    "data": {
        "id": 2,
        "project_id": 1,
        "title": "Implement User Authentication",
        "description": "Create login and registration system",
        "status": "pending",
        "priority": "high",
        "assigned_to": 1,
        "due_date": "2024-03-01T00:00:00.000000Z",
        "completed_at": null,
        "created_at": "2025-09-21T03:00:00.000000Z",
        "updated_at": "2025-09-21T03:00:00.000000Z",
        "project": {
            "id": 1,
            "name": "E-commerce Website",
            "client_name": "TechCorp Solutions"
        },
        "assigned_user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        }
    },
    "message": "Task created successfully"
}
```

### 3. Get Single Task
**GET** `/tasks/{id}`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "project_id": 1,
        "title": "Design Homepage",
        "description": "Create responsive homepage design",
        "status": "pending",
        "priority": "high",
        "assigned_to": 1,
        "due_date": "2024-02-15T00:00:00.000000Z",
        "completed_at": null,
        "created_at": "2025-09-21T03:00:00.000000Z",
        "updated_at": "2025-09-21T03:00:00.000000Z",
        "project": {
            "id": 1,
            "name": "E-commerce Website",
            "client_name": "TechCorp Solutions"
        },
        "assigned_user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        }
    },
    "message": "Task retrieved successfully"
}
```

### 4. Update Task
**PUT** `/tasks/{id}`  
**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "title": "Updated Task Title",
    "description": "Updated task description",
    "status": "in_progress",
    "priority": "medium",
    "assigned_to": 1,
    "due_date": "2024-03-15"
}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "project_id": 1,
        "title": "Updated Task Title",
        "description": "Updated task description",
        "status": "in_progress",
        "priority": "medium",
        "assigned_to": 1,
        "due_date": "2024-03-15T00:00:00.000000Z",
        "completed_at": null,
        "created_at": "2025-09-21T03:00:00.000000Z",
        "updated_at": "2025-09-21T03:00:00.000000Z"
    },
    "message": "Task updated successfully"
}
```

### 5. Delete Task
**DELETE** `/tasks/{id}`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Task deleted successfully"
}
```

### 6. Get Task Statistics
**GET** `/tasks/statistics`  
**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "data": {
        "total_tasks": 10,
        "pending_tasks": 5,
        "in_progress_tasks": 3,
        "completed_tasks": 2,
        "overdue_tasks": 1
    },
    "message": "Task statistics retrieved successfully"
}
```

---

## 🏠 Dashboard Endpoint

### Get API Overview
**GET** `/dashboard`

**Response (200):**
```json
{
    "success": true,
    "message": "BW Media Task Management Platform API with JWT Authentication",
    "version": "2.0.0",
    "authentication": {
        "POST /api/auth/register": "Register a new user",
        "POST /api/auth/login": "Login user and get JWT token",
        "GET /api/user": "Get authenticated user (requires Bearer token)",
        "POST /api/auth/logout": "Logout user (requires Bearer token)",
        "POST /api/auth/refresh": "Refresh JWT token (requires Bearer token)"
    },
    "protected_endpoints": {
        "projects": {
            "GET /api/projects": "List all projects (requires Bearer token)",
            "POST /api/projects": "Create a new project (requires Bearer token)",
            "GET /api/projects/{id}": "Get a specific project (requires Bearer token)",
            "PUT /api/projects/{id}": "Update a project (requires Bearer token)",
            "DELETE /api/projects/{id}": "Delete a project (requires Bearer token)",
            "GET /api/projects/statistics": "Get project statistics (requires Bearer token)"
        },
        "tasks": {
            "GET /api/tasks": "List all tasks (requires Bearer token)",
            "POST /api/tasks": "Create a new task (requires Bearer token)",
            "GET /api/tasks/{id}": "Get a specific task (requires Bearer token)",
            "PUT /api/tasks/{id}": "Update a task (requires Bearer token)",
            "DELETE /api/tasks/{id}": "Delete a task (requires Bearer token)",
            "GET /api/tasks/statistics": "Get task statistics (requires Bearer token)"
        }
    },
    "note": "All protected endpoints require Authorization header with Bearer token"
}
```

---

## 🚨 Error Responses

### 401 Unauthorized
```json
{
    "success": false,
    "message": "Unauthorized"
}
```

### 422 Validation Error
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

### 404 Not Found
```json
{
    "success": false,
    "message": "Project not found",
    "error": "No query results for model [App\\Models\\Project] 999"
}
```

### 500 Server Error
```json
{
    "success": false,
    "message": "Failed to create project",
    "error": "Database connection failed"
}
```

---

## 🧪 Testing Workflow

### Step 1: Setup
1. Start the server: `php artisan serve`
2. Open Postman or similar API testing tool
3. Set base URL: `http://localhost:8000/api`

### Step 2: User Registration & Authentication
1. **Register User 1**
   - POST `/auth/register`
   - Save the token from response
   
2. **Register User 2**
   - POST `/auth/register` with different email
   - Save the token from response

### Step 3: Test User Isolation
1. **Login as User 1**
   - POST `/auth/login`
   - Use token for User 1 requests
   
2. **Create Project as User 1**
   - POST `/projects`
   - Note the project ID
   
3. **Login as User 2**
   - POST `/auth/login`
   - Use token for User 2 requests
   
4. **Verify User 2 cannot see User 1's project**
   - GET `/projects` (should return empty array)
   
5. **Create Project as User 2**
   - POST `/projects`
   - Note the project ID

### Step 4: Test Task Management
1. **Create Task as User 1**
   - POST `/tasks` with User 1's project ID
   
2. **Verify User 2 cannot see User 1's task**
   - GET `/tasks` (should return empty array)
   
3. **Try to create task with User 2 using User 1's project ID**
   - Should return 404 error

### Step 5: Test All CRUD Operations
1. **Projects**: Create, Read, Update, Delete
2. **Tasks**: Create, Read, Update, Delete
3. **Statistics**: Test both project and task statistics
4. **Search & Filter**: Test all query parameters

---

## 📝 Sample Data for Testing

### User Registration Data
```json
{
    "name": "Alice Johnson",
    "email": "alice@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Project Creation Data
```json
{
    "name": "E-commerce Platform",
    "description": "Full-stack e-commerce solution with payment integration",
    "client_name": "RetailCorp Inc",
    "status": "active",
    "start_date": "2024-01-01",
    "end_date": "2024-06-30"
}
```

### Task Creation Data
```json
{
    "project_id": 1,
    "title": "Setup Database Schema",
    "description": "Create all necessary database tables and relationships",
    "status": "pending",
    "priority": "high",
    "assigned_to": 1,
    "due_date": "2024-02-15"
}
```

---

## 🔧 Postman Collection Setup

### Environment Variables
Create a Postman environment with:
- `base_url`: `http://localhost:8000/api`
- `token`: (will be set after login)
- `user_id`: (will be set after login)

### Pre-request Scripts
For protected endpoints, add this to Pre-request Script:
```javascript
pm.request.headers.add({
    key: 'Authorization',
    value: 'Bearer ' + pm.environment.get('token')
});
```

### Test Scripts
Add this to Tests tab for login/register:
```javascript
if (pm.response.code === 200 || pm.response.code === 201) {
    const response = pm.response.json();
    if (response.data && response.data.token) {
        pm.environment.set('token', response.data.token);
        pm.environment.set('user_id', response.data.user.id);
    }
}
```

---

## ✅ Success Criteria

- [ ] User can register and login
- [ ] JWT token is properly generated and validated
- [ ] User can only see their own projects and tasks
- [ ] All CRUD operations work for projects
- [ ] All CRUD operations work for tasks
- [ ] Search and filtering work correctly
- [ ] Statistics show only user's data
- [ ] Error handling works properly
- [ ] Data validation works correctly
- [ ] User isolation is maintained across all operations

---

## 🚀 Ready to Test!

Your Task Manager API is now ready for comprehensive testing with complete user data isolation and JWT authentication!
