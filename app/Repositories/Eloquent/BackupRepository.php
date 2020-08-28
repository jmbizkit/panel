<?php

namespace Pterodactyl\Repositories\Eloquent;

use Carbon\Carbon;
use Pterodactyl\Models\Backup;

class BackupRepository extends EloquentRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Backup::class;
    }

    /**
     * Determines if too many backups have been generated by the server.
     *
     * @param int $server
     * @param int $minutes
     * @return \Pterodactyl\Models\Backup[]|\Illuminate\Support\Collection
     */
    public function getBackupsGeneratedDuringTimespan(int $server, int $minutes = 10)
    {
        return $this->getBuilder()
            ->withTrashed()
            ->where('server_id', $server)
            ->where('is_successful', true)
            ->where('created_at', '>=', Carbon::now()->subMinutes($minutes)->toDateTimeString())
            ->get()
            ->toBase();
    }
}