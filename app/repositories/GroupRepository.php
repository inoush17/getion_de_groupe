<?php

namespace App\repositories;

use App\Interfaces\GroupInterface;
use App\Models\Group;

class GroupRepository implements GroupInterface
{
    /**
     * Create a new class instance.
     */
    public function group(array $data)
    {
        $groups = Group::create($data);

        return $groups;
    }
}
