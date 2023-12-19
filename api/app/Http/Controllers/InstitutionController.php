<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstitutionResource;
use App\Models\Institution;

class InstitutionController extends Controller
{
    public function listInstitution()
    {

        $query = Institution::where('is_del', '0');

        $institutions = $query->latest()->get();

        return successResponse('Successful', InstitutionResource::collection($institutions));

    }
}
