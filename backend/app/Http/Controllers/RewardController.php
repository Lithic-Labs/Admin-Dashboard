<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Http\Requests\StoreRewardRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Services\RewardService;
use Illuminate\Http\Request;
use RewardService as GlobalRewardService;

class RewardController extends Controller
{
    protected RewardService $rewardService;

    public function __construct(RewardService $rewardService){
        $this->rewardService = $rewardService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('api')->user();
        $user_id = $user->id;

        $data['user_id']=$user_id;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
        
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreRewardRequest $request)
    // {   
    //    list($type, $msg) = $this->rewardService->storeReward(
    //         rewards: $request['rewards'],
    //         instance_id: $request['instanceId'],
    //         user_id: $request['userId'],
    //         csv_file: $request->file('csvFile')
    //     );

    //     return response()->json($msg, $type);
    // }

    /**
     * Display the specified resource.
     */
    public function show(Reward $reward)
    {
        //
    }

 
    public function edit(Reward $reward,$id)
    {        
        $reward = Reward::with([
            'rewardDetails' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Sorting reward details by latest created_at
            }
        ])->where('instance_id', $id)->first();

        if (!$reward) {
            return response()->json(['message' => 'Reward not found'], 404);
        }

        return response()->json([
            'reward' => $reward,
            'reward_details' => $reward->rewardDetails // No need for `toArray()`, Laravel handles it
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRewardRequest $request, $instanceId)
    {
        list($type, $msg) = $this->rewardService->updateReward(
            rewards: $request['rewards'],
            instance_id: $request['instanceId'],
            user_id: $request['userId'],
            csv_file: $request->file('csvFile')
          
        );

        return response()->json($msg, $type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reward $reward)
    {
        //
    }
}
