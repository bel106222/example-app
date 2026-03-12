<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index() : View
    {
        $organizations = Organization::query()->paginate(10);
        $trashedOrganizations = Organization::onlyTrashed()->paginate(10);
        return view('organizations.index',[
            'organizations' => $organizations,
            'trashedOrganizations' => $trashedOrganizations
        ]);
    }
}
