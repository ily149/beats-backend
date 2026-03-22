<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProducerController extends Controller
{
    public function index()
    {
        return User::query()
            ->where('role', User::ROLE_PRODUCER)
            ->latest()
            ->paginate(16);
    }
}
