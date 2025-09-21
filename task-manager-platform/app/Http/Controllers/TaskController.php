<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $query = Task::with(['project', 'assignedUser'])
            ->whereHas('project', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });

        // Filter by project if provided
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assigned user if provided
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by priority if provided
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Search by title or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $tasks,
            'message' => 'Tasks retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'in:pending,in_progress,completed',
                'priority' => 'in:low,medium,high,urgent',
                'assigned_to' => 'nullable|exists:users,id',
                'due_date' => 'nullable|date|after_or_equal:today',
            ]);

            // Verify project belongs to authenticated user
            $userId = auth()->id();
            $project = Project::where('id', $validated['project_id'])
                ->where('user_id', $userId)
                ->first();
            
            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found or access denied'
                ], 404);
            }

            $task = Task::create($validated);

            return response()->json([
                'success' => true,
                'data' => $task->load(['project', 'assignedUser']),
                'message' => 'Task created successfully'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $userId = auth()->id();
            $task = Task::with(['project', 'assignedUser'])
                ->whereHas('project', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $task,
                'message' => 'Task retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $userId = auth()->id();
            $task = Task::whereHas('project', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->findOrFail($id);

            $validated = $request->validate([
                'project_id' => 'sometimes|exists:projects,id',
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'status' => 'sometimes|in:pending,in_progress,completed',
                'priority' => 'sometimes|in:low,medium,high,urgent',
                'assigned_to' => 'nullable|exists:users,id',
                'due_date' => 'nullable|date',
            ]);

            // Set completed_at when status is changed to completed
            if (isset($validated['status']) && $validated['status'] === 'completed' && $task->status !== 'completed') {
                $validated['completed_at'] = now();
            }

            $task->update($validated);

            return response()->json([
                'success' => true,
                'data' => $task->load(['project', 'assignedUser']),
                'message' => 'Task updated successfully'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $userId = auth()->id();
            $task = Task::whereHas('project', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->findOrFail($id);
            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get task statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $userId = auth()->id();
            $stats = [
                'total_tasks' => Task::whereHas('project', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->count(),
                'pending_tasks' => Task::whereHas('project', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('status', 'pending')->count(),
                'in_progress_tasks' => Task::whereHas('project', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('status', 'in_progress')->count(),
                'completed_tasks' => Task::whereHas('project', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('status', 'completed')->count(),
                'overdue_tasks' => Task::whereHas('project', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('due_date', '<', now()->toDateString())
                    ->where('status', '!=', 'completed')
                    ->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Task statistics retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
