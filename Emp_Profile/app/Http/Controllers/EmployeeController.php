<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'gender'         => 'required|in:Male,Female,Other',
            'marital_status' => 'required|in:Single,Married,Divorced',
            'phone'          => 'required|regex:/^[0-9]{10,15}$/',
            'email'          => 'required|email',
            'address'        => 'required|string',
            'date_of_birth'  => 'required|date',
            'nationality'    => 'required|string|max:100',
            'hire_date'      => 'required|date',
            'department'     => 'required|string|max:100',
        ]);

        $file = storage_path('app/employees.json');

        try {
            // Ensure the storage/app directory exists
            $directory = dirname($file);
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0775, true)) {
                    throw new \Exception('Cannot create storage directory');
                }
            }

            // Check if directory is writable
            if (!is_writable($directory)) {
                throw new \Exception('Storage directory is not writable');
            }

            // Read existing employees or create empty array if file missing
            $employees = [];
            if (file_exists($file)) {
                $content = file_get_contents($file);
                if ($content === false) {
                    throw new \Exception('Cannot read existing employee file');
                }

                $employees = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // If JSON is corrupted, backup and start fresh
                    copy($file, $file . '.backup.' . date('Y-m-d-H-i-s'));
                    $employees = [];
                }
            }

            // Add new employee data
            $employees[] = $data;

            // Save back to file with pretty print
            $jsonData = json_encode($employees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            if ($jsonData === false) {
                throw new \Exception('Failed to encode employee data to JSON');
            }

            $result = file_put_contents($file, $jsonData, LOCK_EX);
            if ($result === false) {
                throw new \Exception('Failed to write employee data to file');
            }

            return response()->json([
                'message' => 'Employee saved successfully',
                'employee' => $data,
                'total_employees' => count($employees)
            ]);

        } catch (\Exception $e) {
            \Log::error('Employee save failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to save employee',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $file = storage_path('app/employees.json');

        try {
            if (!file_exists($file)) {
                return response()->json([]);
            }

            $content = file_get_contents($file);
            if ($content === false) {
                throw new \Exception('Cannot read employee file');
            }

            $employees = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON in employee file');
            }

            return response()->json($employees ?: []);

        } catch (\Exception $e) {
            \Log::error('Employee fetch failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to fetch employees',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        // Return the Blade view with your form
        return view('employees.create');
    }
}
