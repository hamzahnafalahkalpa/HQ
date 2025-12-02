<?php

namespace Projects\Hq\Controllers\API\Unicode\Autolist;

use Hanafalah\LaravelHasProps\Models\Scopes\HasCurrentScope;
use Hanafalah\LaravelSupport\Concerns\Support\HasCache;
use Illuminate\Http\Request;
use Projects\Hq\Controllers\API\ApiController;
use Illuminate\Support\Str;
use Hanafalah\ModuleMedicService\Enums\Label as MedicServiceLabel;

class AutolistController extends ApiController{
    use HasCache;

    protected $__onlies = [
    ];

    protected $__stores = [
        'ItemStuff',
    ];

    public function index(Request $request){
        request()->merge([ 
            'search_name'  => request()->search_name ?? request()->search_value,
            'search_value' => null
        ]);

        $morph = Str::studly(request()->morph);
        switch ($morph) {
            case 'MedicService':
                $schema = app(config('app.contracts.'.$morph));
                $is_for_registration = isset(request()->is_for_registration) && request()->is_for_registration;
                if ($is_for_registration) $schema->setIsParentOnly(false);
                return $schema->autolist(request()->type,function($query) use ($is_for_registration){
                    $query->when($is_for_registration,function($query){
                        $query->whereIn('label',[
                            MedicServiceLabel::INPATIENT->value,
                            MedicServiceLabel::MCU->value,
                            MedicServiceLabel::RADIOLOGY->value,
                            MedicServiceLabel::VERLOS_KAMER->value,
                            MedicServiceLabel::EMERGENCY_UNIT->value,
                            // MedicServiceLabel::TREATMENT_ROOM->value,
                            'UMUM', 'ORTHOPEDI', 'SUNAT', 'KECANTIKAN', 'MATA', 'THT', 'INTERNIS', 'GIGI & MULUT', 'KIA'
                        ]);
                    })->when(isset(request()->exclude_id),function($query){
                        $ids = $this->mustArray(request()->exclude_id);
                        $query->whereNotIn('id',$ids);
                    });
                });
            break;
            case 'Unicode':
                $datas = $this->cacheWhen(true,[
                    'name'     => 'unicode',
                    'tags'     => ['unicode', 'unicode-index'],
                    'forever' => true
                ], function() use ($morph){
                    $unicodes = $this->callAutolist($morph,function($query){
                        $query->withoutGlobalScope('flag');
                    });
                    $grouped = [];
                    foreach ($unicodes as $unicode) {
                        $flag = $unicode['flag'];
                        $grouped[$flag] ??= [];
                        $grouped[$flag][] = $unicode;
                    }
                    return $grouped;
                });

                return (isset(request()->search_flag)) ? [request()->search_flag => $datas[request()->search_flag]] : $datas;
            break;
            case 'Subdistrict':
            case 'Village':
                return $this->callAutolist($morph,function($query) use ($morph){
                    $query->join('provinces','provinces.id','province_id')
                          ->join('districts',function($join){
                            $join->on('districts.id','district_id')
                                 ->on('districts.province_id','provinces.id');
                          });
                    if ($morph == 'Village'){
                        $query->select('villages.*','villages.name as name')->join('subdistricts',function($join){
                            $join->on('subdistricts.id','subdistrict_id')
                                ->on('subdistricts.district_id','districts.id');
                        });
                    }else{
                        $query->select('subdistricts.*','subdistricts.name as name');
                    }
                    if (isset(request()->search_name)) {
                        $search = strtolower(request()->search_name);

                        $query->where(function ($query) use ($morph, $search) {
                            $query->whereRaw('LOWER(provinces.name) LIKE ?', ["%{$search}%"])
                                ->orWhereRaw('LOWER(districts.name) LIKE ?', ["%{$search}%"])
                                ->orWhereRaw('LOWER(subdistricts.name) LIKE ?', ["%{$search}%"]);

                            if ($morph === 'Village') {
                                $query->orWhereRaw('LOWER(villages.name) LIKE ?', ["%{$search}%"]);
                            }
                        });
                    }
                });
            break;
            default:
                return $this->callAutolist($morph);
            break;
        }
    }

    private function callAutolist(string $morph,?callable $callback = null){
        return app(config('app.contracts.'.$morph))->autolist(request()->type,$callback);
    }
}