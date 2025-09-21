<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/resend-verification', [AuthController::class, 'resendVerification']);
});

// Protected Routes (require JWT authentication)
Route::middleware('auth:api')->group(function () {
    // User routes
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    // Project Routes
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::post('/', [ProjectController::class, 'store']);
        Route::get('/statistics', [ProjectController::class, 'statistics']);
        Route::get('/{id}', [ProjectController::class, 'show']);
        Route::put('/{id}', [ProjectController::class, 'update']);
        Route::delete('/{id}', [ProjectController::class, 'destroy']);
    });

    // Task Routes
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('/statistics', [TaskController::class, 'statistics']);
        Route::get('/{id}', [TaskController::class, 'show']);
        Route::put('/{id}', [TaskController::class, 'update']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);
    });
});

// Dashboard/Overview Routes
Route::get('/dashboard', function () {
    return response()->json([
        'success' => true,
        'message' => 'BW Media Task Management Platform API with JWT Authentication',
        'version' => '2.0.0',
        'authentication' => [
            'POST /api/auth/register' => 'Register a new user (requires email verification)',
            'POST /api/auth/login' => 'Login user and get JWT token (requires verified email)',
            'GET /api/auth/verify-email' => 'Verify email address with token',
            'POST /api/auth/resend-verification' => 'Resend email verification',
            'GET /api/user' => 'Get authenticated user (requires Bearer token)',
            'POST /api/auth/logout' => 'Logout user (requires Bearer token)',
            'POST /api/auth/refresh' => 'Refresh JWT token (requires Bearer token)',
        ],
        'protected_endpoints' => [
            'projects' => [
                'GET /api/projects' => 'List all projects (requires Bearer token)',
                'POST /api/projects' => 'Create a new project (requires Bearer token)',
                'GET /api/projects/{id}' => 'Get a specific project (requires Bearer token)',
                'PUT /api/projects/{id}' => 'Update a project (requires Bearer token)',
                'DELETE /api/projects/{id}' => 'Delete a project (requires Bearer token)',
                'GET /api/projects/statistics' => 'Get project statistics (requires Bearer token)',
            ],
            'tasks' => [
                'GET /api/tasks' => 'List all tasks (requires Bearer token)',
                'POST /api/tasks' => 'Create a new task (requires Bearer token)',
                'GET /api/tasks/{id}' => 'Get a specific task (requires Bearer token)',
                'PUT /api/tasks/{id}' => 'Update a task (requires Bearer token)',
                'DELETE /api/tasks/{id}' => 'Delete a task (requires Bearer token)',
                'GET /api/tasks/statistics' => 'Get task statistics (requires Bearer token)',
            ]
        ],
        'note' => 'All protected endpoints require Authorization header with Bearer token'
    ]);
});
