<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveResultRequest;
use App\Http\Requests\GetResultsRequest;

use App\Services\ResultService;

class ResultController extends Controller
{
    public function __construct(
        private ResultService $resultService,
    ) {}

    public function saveResults(SaveResultRequest $request)
    {
        $this->resultService->save($request);
    }

    public function getResults(GetResultsRequest $request)
    {
        $bestResults = $this->resultService->get($request);

        return response()->json($bestResults);
    }
}
