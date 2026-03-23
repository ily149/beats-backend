<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Beat;

class ProducerController extends Controller
{
    public function index()
    {
        $producers = User::where('role', User::ROLE_PRODUCER)
            ->paginate(20);

        return response()->json($producers);
    }

    public function show(int $id)
    {
        $producer = User::where('role', User::ROLE_PRODUCER)->findOrFail($id);

        $beats = Beat::where('user_id', $producer->id)
            ->with(['genre', 'user', 'licenses.assets'])
            ->latest()
            ->get();

        return response()->json([
            'producer' => $producer,
            'beats' => $beats,
        ]);
    }
}
