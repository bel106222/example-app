<?php

namespace App\Http\Controllers\Web;

use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Books;
use App\Models\Organization;
use App\Models\User;
use App\Repository\OrganizationRepository;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
    )
    {
    }
    public function index() : View
    {
        $organizations = Organization::query()->paginate(10);
        $trashedOrganizations = Organization::onlyTrashed()->paginate(10);
        return view('organizations.index',[
            'organizations' => $organizations,
            'trashedOrganizations' => $trashedOrganizations
        ]);
    }
    public function show(Organization $organization) //Display the specified resource.
    {
        return view('organizations.show', [
            'organization' => $organization
        ]);
    }
    public function create() //Show the form for creating a new resource.
    {
        return view('organizations.create');
    }
    public function store(Request $request)
    {
        return redirect()->route(
            'organizations.index',
            $this->organizationRepository->create($request)
        );
    }
    public function update(Request $request, Organization $organization) : RedirectResponse //Update the specified resource in storage.
    {
        return redirect()->route(
            'organizations.index',
            $this->organizationRepository->update($request, $organization) //из репозитория получаем пользователя
        )->with('success','Организация удачно обновлёна!') ;
    }
    public function destroy(Organization $organization) : RedirectResponse
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Организация удалена.');
    }
    public function restore(string $organizationId): RedirectResponse
    {
        Organization::withTrashed()->where('id', $organizationId)->firstOrFail()->restore();
        return redirect()->route('organizations.index')->with('success', 'Организация восстановлена.');
    }
}
