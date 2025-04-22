<?php
namespace App\Services;

use App\Models\Reward;
use App\Models\Reward_details;
use Illuminate\Support\Facades\Log;
use App\Imports\RewardDetailsImport;
use Maatwebsite\Excel\Facades\Excel;

class RewardService{
    // store user
    // public function storeReward(
    //     string $rewards,       
    //     string $instance_id,
    //     string $user_id,
    //     $csv_file,
    // ){       
    //     try {        
    //         // Step 1: Create the reward
    //         $reward = Reward::create([
    //             'user_id'      => $user_id,
    //             'instance_id'  => $instance_id,
    //             'rewards_type' => $rewards
    //         ]);               
    //         // Step 2: Process the CSV file using Laravel Excel
    //          if ($csv_file) {
    //             Excel::import(new RewardDetailsImport($reward->id), $csv_file);
    //         }   
    //         return [200, "Reward and reward details inserted"];
    //     } catch (\Throwable $th) {
    //         Log::error($th->getMessage());
    //         return [400, "Insert task failed"];
    //     }
    //     return [$type,$msg];       
    // }
    public function updateReward(
        string $rewards,
        string $instance_id,
        string $user_id,
        $csv_file
    ) {
        try {
            // Step 1: Find the reward by instance_id
            $reward = Reward::where('instance_id', $instance_id)->first();

            if (!$reward) {
                return [404, "Reward not found"];
            }

            //  Update reward type and user (if needed)
            $reward->update([
                'user_id' => $user_id,
                'rewards_type' => $rewards
            ]);

            // Process CSV (optional: delete old details before importing)
            if ($csv_file) {
                // Delete old reward details if necessary
                Reward_details::where('reward_id', $reward->id)->delete();

                // Import new reward details using Excel
                Excel::import(new RewardDetailsImport($reward->id), $csv_file);
            }

            return [200, "Reward and reward details updated successfully"];
        } catch (\Throwable $th) {
            Log::error("Update Reward Failed", [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                
            ]);
            return [400, "Update task failed"];
        }
    }
  
}