<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(int $groupId)
    {
        $students = Student::where('group_id', $groupId)->get();
        return StudentResource::collection($students);
    }
}
