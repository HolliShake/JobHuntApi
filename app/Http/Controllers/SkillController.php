<?php

namespace App\Http\Controllers;

use App\Services\skill\ISkillService;
use Illuminate\Support\Facades\Validator;


class SkillController extends ControllerBase
{
    function __construct(protected readonly ISkillService $skillService) {
    }

    function all()
    {
        return response()->json($this->skillService->all(), 200);
    }

    function createSkill()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }



        return;
    }
}
