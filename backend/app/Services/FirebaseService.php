<?php 
 
namespace App\Services; 
 
use Kreait\Laravel\Firebase\Facades\Firebase; 
use Kreait\Firebase\Firestore; 
use Kreait\Firebase\Exception\FireStoreException; 
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request; 
 
class FirebaseService 
{ 
  
    protected Firestore $firestore; 
 
    public function __construct() 
    {         
        $this->firestore = Firebase::firestore(); 

        
    } 
 
     public function getAllTemplates() 
     { 
         try { 
             $collection = $this->firestore->database()->collection('templates'); 
             $documents = $collection->documents(); 
 
             $templates = []; 
             foreach ($documents as $document) { 
                 if ($document->exists()) { 
                     $templates[] = $document->data(); 
                 } 
             }  
             return $templates; 
         } catch (FirestoreException $e) { 
             Log::error('Firestore Error: ' . $e->getMessage()); 
             return []; // Or throw a custom exception 
         } 
     } 

    /**
     * Create a new game instance from a template and store assets
     */
    public function storeInstance(array $data)
    {
        try {
            $collection = $this->firestore->database()->collection('game_instances');
            $document = $collection->add($data);

            return $document->id();
        } catch (\Exception $e) {
            Log::error('Firestore Error: ' . $e->getMessage());
            return null;
        }
    
    }
  
    public function getClientInstances(string $clientId)
        {
            try {
                // Firestore collection reference
                $collection = $this->firestore->database()->collection('game_instances');

                // Query to get instances by client ID
                $query = $collection->where('client', '=', $clientId)->documents();

                $instances = [];
                foreach ($query as $document) {
                    if ($document->exists()) {
                        $instances[] = [
                            'id' => $document->id(),
                            'client' => $document->data()['client'],
                            'templateId' => $document->data()['templateId'],
                            'instanceName' => $document->data()['instanceName'],
                            'createdAt' => $document->data()['createdAt'],
                        ];
                    }
                }

                return $instances;

            } catch (\Exception $e) {
                Log::error('Error fetching game instances: ' . $e->getMessage());
                throw new \Exception('Error fetching instances');
            }
        }

        public function getAllClientInstances()
        {
            try {
                // Firestore collection reference
                $collection = $this->firestore->database()->collection('game_instances');

                // Query to get instances
                $query = $collection->documents();

                $instances = [];
                foreach ($query as $document) {
                    if ($document->exists()) {
                        $instances[] = [
                            'id' => $document->id(),
                            'client' => $document->data()['client'],
                            'templateId' => $document->data()['templateId'],
                            'instanceName' => $document->data()['instanceName'],
                            'createdAt' => $document->data()['createdAt'],
                        ];
                    }
                }

                return $instances;

            } catch (\Exception $e) {
                Log::error('Error fetching game instances: ' . $e->getMessage());
                throw new \Exception('Error fetching instances');
            }
        }

        public function updateInstance($instanceId, array $data)
        {
            try {
                $collection = $this->firestore->database()->collection('game_instances');
                $document = $collection->document($instanceId);
    
                $document->set($data, ['merge' => true]); // Merge with existing data
    
                return true;
            } catch (\Exception $e) {
                Log::error('Firestore Error: ' . $e->getMessage());
                return false;
            }
        }
    
}