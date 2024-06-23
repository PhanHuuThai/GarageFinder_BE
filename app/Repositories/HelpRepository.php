<?php

namespace App\Repositories;

use App\Models\Help;
use App\Repositories\BaseRepository;

class HelpRepository extends BaseRepository
{
    public function getModel()
    {
        return Help::class;
    }

}