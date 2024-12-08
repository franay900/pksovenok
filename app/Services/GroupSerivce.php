<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Organization;
use App\Models\Period;
use App\Models\PeriodType;
use App\Models\User;

class GroupSerivce
{

    public function index($user)
    {
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
        return [
            'periods' => array_values($periods),
            'teachers' => $teachers,
            'groups' => $groups
        ];
    }


    public function store($user, $request)
    {
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
    }

}
