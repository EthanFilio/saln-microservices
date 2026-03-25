<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait TracksFormChanges
{
    /**
     * Record a change to the form data
     *
     * @param array $newData The new form data
     * @param string|null $changeDescription Description of the change
     */
    public function recordChange(array $newData, ?string $changeDescription = null): void
    {
        $changeHistory = $this->change_history ?? [];
        
        $change = [
            'timestamp' => now()->toIso8601String(),
            'data' => $newData,
            'description' => $changeDescription,
            'previous_status' => $this->status,
        ];

        $changeHistory[] = $change;
        $this->change_history = $changeHistory;
        $this->save();
    }

    /**
     * Get all changes to this form
     */
    public function getChangeHistory(): array
    {
        return $this->change_history ?? [];
    }

    /**
     * Get the latest change
     */
    public function getLatestChange(): ?array
    {
        $history = $this->getChangeHistory();
        return Arr::last($history);
    }

    /**
     * Revert to a previous version (by timestamp)
     */
    public function revertToChange(string $timestamp): void
    {
        $history = $this->getChangeHistory();
        $targetChange = collect($history)->firstWhere('timestamp', $timestamp);

        if ($targetChange) {
            $this->form_data = $targetChange['data'];
            $this->recordChange($targetChange['data'], "Reverted to version from {$timestamp}");
        }
    }
}
