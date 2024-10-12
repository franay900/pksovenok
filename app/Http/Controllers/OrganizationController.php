<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\StoreRequest;
use App\Http\Requests\Organization\UpdateRequest;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function index() {
        $organizations = Organization::all();
        return view('organizations.index', compact('organizations'));
    }

    public function create() {
        return view('organizations.create');
    }

    public function store(StoreRequest $request) {

        $data = $request->validated();


        $organization = Organization::create([
            'name' => $data['name'],
            'short_name' => $data['short_name'],
        ]);
        $name = $data['user_name'];
        $surname = $data['user_surname'];
        $password = Str::random(8);
        $username = $name.$surname.rand(1,999999);
        $user = User::create([
            'organization_id' => $organization->id,
            'name' => $data['user_name'],
            'username' => $username,
            'password' => bcrypt($password)
        ]);

        return redirect()->route('organization.index')->with('login_credentials', [
            'username' => $user->username,
            'password' => $password
        ]);
    }

    public function show(Organization $organization) {

    }
    public function edit(Organization $organization) {
        return view('organizations.edit', compact('organization'));
    }
    public function update(UpdateRequest $request, Organization $organization) {
        $data = $request->validated();
        $organization->update($data);
        return redirect()->route('organization.index');
    }
    public function destroy(Organization $organization) {
        $users = User::where('organization_id', $organization->id)->delete();

        $organization->delete();
        return redirect()->route('organization.index');
    }

}
