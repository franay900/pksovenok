<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\StoreRequest;
use App\Http\Resources\Group\GroupResource;
use App\Models\User;
use App\Models\Group;
use App\Models\Organization;
use App\Models\Period;
use App\Models\PeriodType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $organizationId = $user->organization_id;
        $periodsAll = Period::where('organization_id', $organizationId)->get();
        $periods = [];
        $teachers = User::getTeachersByOrganization($organizationId);
        $groups = Group::where('organization_id', $organizationId)
                ->with('manager:id,surname,name,patronymic', 'periodType:id,name', 'bell:id,name')
                ->orderBy('number', 'asc')
                ->orderBy('letter', 'asc')
                ->get();
        $groups->transform(function ($group) {
            $group->manager_full_name = $group->manager ? 
                $group->manager->surname . ' ' . $group->manager->name . ' ' . $group->manager->patronymic : 
                null;
    
            return $group;
        });
        

        foreach ($periodsAll as $period) {
            $periodTypeId = $period['period_type_id'];
        
            // Проверка, есть ли уже тип периода в массиве (по индексу периода)
            if (!isset($periods[$periodTypeId])) {
                $periodType = PeriodType::find($periodTypeId);
                
                // Добавляем тип периода в массив как объект, используя ID как индекс
                $periods[$periodTypeId] = $periodType;
            }
        }
        return response()->json([
            'periods' => array_values($periods),
            'teachers' => $teachers,
            'groups' => $groups
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $organizationId = $user->organization_id;
        $yearId = Organization::find($organizationId) -> year_id;
        $data = $request->validated();

        Group::create([
            'number' => $data['number'],
            'letter' => $data['letter'],
            'organization_id' => $organizationId,
            'year_id' => $yearId,
            'manager_id' => $data['manager_id'],
            'period_type_id' => $data['period_type_id'],
            'bell_id' => $data['bell_id']

        ]);

        return response()->json(['ok']);


    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
