<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\TestRepository;

class TestService
{
    public function index(TestRepository $filter ,Request $request)
    {
        $user = User::filter($filter)->paginate(40 , 'page', $request['page'])->getSql();
        dd($user);
    }
}
