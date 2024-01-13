<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Result;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\SaveResultRequest;
use App\Http\Requests\GetResultsRequest;

class ResultService
{
    public function save(SaveResultRequest $request): void
    {
        $memberId = isset($request->email) ? Member::getIdByEmail($request->email) : null;

        $result = new Result;

        $result->milliseconds = $request->milliseconds;
        $result->member_id = $memberId;

        $result->save();
    }
    
    public function get(GetResultsRequest $request): array
    {
        $top = DB::table('members')
            ->join('results', 'results.member_id', '=', 'members.id')
            ->selectRaw('MIN(results.milliseconds) AS milliseconds, members.email AS email')
            ->whereNotNull('results.member_id')
            ->groupBy('members.email')
            ->orderBy('milliseconds')
            ->limit(10)
            ->get()
            ->toArray();

        for ($i = 1; $i <= 10; $i++) {
            $top[$i - 1]->place = $i;
            $top[$i - 1]->email = $this->hideEmail($top[$i - 1]->email);
        }

        $response = [];
        $response['data'] = [
            'top' => $top
        ];

        if (isset($request->email)) {
            $selfRating = DB::table(DB::raw('(
                SELECT
                    members.email,
                    MIN(results.milliseconds) AS milliseconds,
                    ROW_NUMBER() OVER (ORDER BY MIN(results.milliseconds)) AS ranking
                FROM members
                JOIN results ON results.member_id = members.id
                WHERE results.member_id IS NOT NULL
                GROUP BY members.email
            ) as ranked_data'))
                ->where('email', $request->email)
                ->orderBy('milliseconds')
                ->select('email', 'milliseconds', 'ranking')
                ->get();

            $response['self'] = $selfRating[0];
        }

        return $response;
    }

    private function hideEmail(string $email)
    {
        [$localPart, $domain] = explode('@', $email);

        $hiddenCharacters = max(0, strlen($localPart) - 3);

        $hiddenPart = substr($localPart, 0, 3) . str_repeat('*', $hiddenCharacters);

        $hiddenEmail = $hiddenPart . '@' . $domain;

        return $hiddenEmail;
    }
}