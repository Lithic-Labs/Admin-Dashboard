<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Reward_details;

class RewardDetailsImport implements ToModel,WithHeadingRow
{
    protected $rewardId;

    // Pass reward ID when importing
    public function __construct($rewardId)
    {
        $this->rewardId = $rewardId;
    }

    public function model(array $row)
    {
        return new Reward_Details([
            'reward_id' => $this->rewardId,
            'code'      => $row['code'] ?? null,   // Column names must match CSV headers
            'amount'    => $row['amount'] ?? null,
            'status'    => 1
        ]);
    }
}
