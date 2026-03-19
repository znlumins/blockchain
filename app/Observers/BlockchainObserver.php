<?php


namespace App\Observers;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class BlockchainObserver {
    public function created($model) { $this->recordBlock('CREATED', $model); }
    public function updated($model) { $this->recordBlock('UPDATED', $model); }

    private function recordBlock($action, $model) {
        $lastBlock = AuditLog::latest('id')->first();
        $previousHash = $lastBlock ? $lastBlock->hash : '00000000000000000000000000000000';
        
        $data = json_encode($model->toArray());
        // Konsep Blockchain: Hash data saat ini + hash sebelumnya
        $hash = hash('sha256', $previousHash . $data . time());

        AuditLog::create([
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'data' => $model->toArray(),
            'previous_hash' => $previousHash,
            'hash' => $hash,
            'created_by' => Auth::user() ? Auth::user()->username : 'system',
        ]);
    }
}