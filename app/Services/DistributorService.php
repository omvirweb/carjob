<?php

namespace App\Services;
use DB;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;

class DistributorService{

    protected $DistributorService = null;
    const ELEMENTS_PER_PAGE = Controller::DEFAULT_ELEMENTS_PER_PAGE;

    public function getDistributors(Request $request, $count = self::ELEMENTS_PER_PAGE)
    {
        $user = \Auth::user();
        $pageDistributors = $request->get('page') ? $request->get('page') : 1;
        $q = trim($request->get('search'));
        $filter = (object)[];
        //DB::enableQueryLog();
        $data = User::select(DB::raw('users.*'))
            ->where('users.role',User::ROLE_DISTRIBUTOR)
            ->when($q, function ($query) use ($q,$request) {
                return $query->where(function ($query) use ($q,$request) {
                    /** @var Builder $query */
                    $preparedQ = '%' .$q. '%';
                    $num = 0;
                    foreach (
                        [
                            'users.first_name',
                            'users.last_name',
                            'users.email',
                            'users.mobile_number',
                            'users.isActive',
                        ] AS $field
                    ) {
                        if ($num) {
                            $query = $query->orWhere($field, 'LIKE', $preparedQ);
                        } else {
                            $query = $query->where($field, 'LIKE', $preparedQ);
                        }
                        $num++;
                    }

                    return $query;
                });
            });


        if($request->get('toDate') && $request->get('toDate') != ""){

            $data->where(DB::raw('DATE(users.created_at)'),'<=',$request->get('toDate'));
        }
        if($request->get('fromDate') && $request->get('fromDate') != ""){

            $data->where(DB::raw('DATE(users.created_at)'),'>=',$request->get('fromDate'));
        }

        $Distributors = $data->orderBy('users.created_at','DESC')->paginate($count, ['*'], 'page', $pageDistributors);
        $links = $Distributors->appends('page')->links();
        $filter->search = $request->get('search');
        $filter->created_at = $request->get('created_at');
        //dd(DB::getQueryLog());exit;
        return compact('Distributors', 'links', 'filter');
    }

}
