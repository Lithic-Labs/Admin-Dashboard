<?php 
 
namespace App\Http\Controllers; 
 
use App\Http\Controllers\Controller; 
use App\Services\FirebaseService; 
use Illuminate\Http\Request; 
use Illuminate\Http\JsonResponse; 
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
 
class TemplateController extends Controller 
{ 
    protected $firebaseService; 
 
    public function __construct(FirebaseService $firebaseService) 
    { 
        $this->firebaseService = $firebaseService; 
    }     
 
    public function index(): JsonResponse 
    {       
        $templates = $this->firebaseService->getAllTemplates();        
        return response()->json($templates,200); 
    }  

    public function store(Request $request)
    {
        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'client' => 'required|string',
                'templateid' => 'required|string',               
            ]);
            $instanceName =  "instance_".$validatedData['client'] . "_" . now()->timestamp;
            // Prepare data for Firestore
            $gameInstanceData = [
                'client' => $validatedData['client'],
                'templateId' => $validatedData['templateid'],
                'createdAt' => now()->timestamp, // Add timestamp for sorting
                'instanceName' => $instanceName, // Add instance name
                'title' => null,
                'winText' => null,
                'loseText' => null,
                'color1' => null,
                'color2' => null,
                'color3' => null,
            ];
    
            // Store instance in Firestore
            $instanceId = $this->firebaseService->storeInstance($gameInstanceData);
    
            if ($instanceId) {
                return response()->json(['message' => 'Instance created', 'id' => $instanceId], 201);
            } else {
                return response()->json(['error' => 'Failed to create instance'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error storing game instance: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
       
   
    } 


public function getClientInstances($id)
{
    try {
        // Fetch instances from Firestore using service function
        $instances = $this->firebaseService->getClientInstances($id);

        if (empty($instances)) {
            return response()->json(['message' => 'No instances found for this client'], 404);
        }

        return response()->json(['instances' => $instances], 200);
    } catch (\Exception $e) {
        Log::error('Error fetching game instances: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}

public function getAllClientInstances()
{
    try {
        // Fetch instances from Firestore using service function
        $instances = $this->firebaseService->getAllClientInstances();

        if (empty($instances)) {
            return response()->json(['message' => 'No instances found for this client'], 404);
        }

        return response()->json(['instances' => $instances], 200);
    } catch (\Exception $e) {
        Log::error('Error fetching game instances: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}

public function updateInstance(Request $request)
{
    try {
        $validatedData = $request->validate([
            'instanceId' => 'required|string',
        ]);

        $instanceId = $validatedData['instanceId'];

        // Prepare update data
        $updateData = [
            'title' => $request->input('title', null),
            'winText' => $request->input('winText', null),
            'loseText' => $request->input('loseText', null),
            'color1' => $request->input('color1', null),
            'color2' => $request->input('color2', null),
            'color3' => $request->input('color3', null),
        ];

        // Store uploaded files if provided
        if ($request->hasFile('backgroundImage')) {
            $backgroundPath = $request->file('backgroundImage')->store('uploads');
            $updateData['backgroundImage'] = $backgroundPath;
        }

        if ($request->hasFile('player')) {
            $playerPath = $request->file('player')->store('uploads');
            $updateData['player'] = $playerPath;
        }

        if ($request->hasFile('button')) {
            $buttonPath = $request->file('button')->store('uploads');
            $updateData['button'] = $buttonPath;
        }

        // Update Firestore instance
        $updated = $this->firebaseService->updateInstance($instanceId, $updateData);

        if ($updated) {
            return response()->json(['message' => 'Instance updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to update instance'], 500);
        }
    } catch (\Exception $e) {
        Log::error('Error updating game instance: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}


}
