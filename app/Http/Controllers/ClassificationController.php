<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ClassificationController extends Controller
{
    public function index()
    {
        return Classification::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB max
            'note' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('classifications', 'public');
            $fullPath = storage_path('app/public/' . $path);

            // Call Python API
            try {
                $response = Http::attach(
                    'image', file_get_contents($fullPath), $file->getClientOriginalName()
                )->post('http://127.0.0.1:5000/predict');

                if ($response->successful()) {
                    $data = $response->json();
                    
                    $classification = Classification::create([
                        'name' => $request->name,
                        'image_path' => '/storage/' . $path,
                        'result' => $data['result'] ?? 'Unknown',
                        'confidence' => $data['confidence'] ?? 0,
                        'note' => $request->note
                    ]);

                    return response()->json([
                        'success' => true,
                        'data' => $classification
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => 'API Error: ' . $response->body()], 500);
                }

            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Connection Error: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'No image uploaded'], 400);
    }
}
