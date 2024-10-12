<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Subgroup;
use Illuminate\Http\Request;

class SubgroupController extends Controller
{
    
    public function show(string $group){
        return response()->json(
            Subgroup::where('group_id', $group)
            ->orderBy('subject_id')
            ->orderBy('name')
            ->with('subject') 
            ->get()
            ->map(function ($subgroup) {
            return [
                'id' => $subgroup->id,
                'group_id' => $subgroup->group_id,
                'subject_name' => $subgroup->subject->name, 
                'subgroup_name' => $subgroup->name, 
                
            ];
            })
        );
    }

    public function store(Request $request){

        $data = $request->validate([
            'name' => ['required'],
            'subject_id' => ['required'],
            'group_id' => ['required']
        ]);

        Subgroup::create($data);

        return response()->json(['ok']);
    }
}
