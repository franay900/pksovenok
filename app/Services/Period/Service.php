<?php


namespace App\Services\Period;

use DateTime;
use DateTimeZone;
use App\Models\Period;
use App\Models\PeriodType;
use Tymon\JWTAuth\Facades\JWTAuth;

class Service {

    public function store($data){
        $periodsTypes = $data['periods'];
        $user = JWTAuth::parseToken()->authenticate();
        $organizationId = $user->organization_id;
        $yearId = 1;
        foreach($periodsTypes as $periodType){
            $name = $periodType['name'];
            $periodTypeId = PeriodType::where('name', $name)->first()->id;
            $periods = $periodType['periods'];
            $number = 1;
            foreach($periods as $period){
                
               if(!isset($period['begin'])){
                    break;
               }
               $begin =  (new DateTime($period['begin'], new DateTimeZone('UTC')))
                    ->setTimezone(new DateTimeZone('Europe/Moscow'))
                    ->format('d.m.Y');; 
               $end =  (new DateTime($period['end'], new DateTimeZone('UTC')))
                    ->setTimezone(new DateTimeZone('Europe/Moscow'))
                    ->format('d.m.Y');; 
               $existingPeriod = Period::where('organization_id', $organizationId)
                    ->where('number', $number)
                    ->where('period_type_id', $periodTypeId)
                    ->first();

                if ($existingPeriod) {
                    
                    $existingPeriod->update([
                        'begin' => $begin,
                        'end' => $end,
                    ]);
                } else {
                    Period::create([
                        'begin' => $begin,
                        'end' => $end,
                        'year_id' => $yearId,
                        'organization_id' => $organizationId,
                        'period_type_id' => $periodTypeId,
                        'number' => $number,
                    ]);
                }
                $number += 1;
            }
        }


    }
    

}