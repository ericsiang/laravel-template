<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Builders\RecordBuilder;
use Illuminate\Support\Facades\DB;
use App\Repositories\TestRepository;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private RecordBuilder $record;
    private TestRepository $repository;


    public function __construct(RecordBuilder $record, TestRepository $repository)
    {
        $this->record = $record;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        // Gate::authorize('early check in');
        $this->authorize('early check in');
        $this->record->setLogName('first_log')
            ->setEvent('first_event')
            ->setDescription('first_description')
            ->record();
        return response()->json([], Response::HTTP_OK);
    }

    public function show(Request $request, string $id)
    {
        return response()->json([], Response::HTTP_OK);
    }

    public function filter(Request $request, TestRepository $filter)
    {
        DB::enableQueryLog();
        $user = User::filter($filter)->get();
        dd(DB::getQueryLog());
        dd($user);
        return response()->json([], Response::HTTP_OK);
    }
}
