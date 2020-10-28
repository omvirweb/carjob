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

class CategoriesService{

    protected $CategoriesService = null;
    const ELEMENTS_PER_PAGE = Controller::DEFAULT_ELEMENTS_PER_PAGE;

    public function getCategories(Request $request, $count = self::ELEMENTS_PER_PAGE)
    {
        $user = \Auth::user();
        $pageCategories = $request->get('page') ? $request->get('page') : 1;
        $q = trim($request->get('search'));
        $filter = (object)[];
        //DB::enableQueryLog();
        $data = Category::select(DB::raw('category.*'))

            ->when($q, function ($query) use ($q,$request) {
                return $query->where(function ($query) use ($q,$request) {
                    /** @var Builder $query */
                    $preparedQ = '%' .$q. '%';
                    $num = 0;
                    foreach (
                        [
                            'category.categoryName',
                            'category.status',
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

            $data->where(DB::raw('DATE(category.created_at)'),'<=',$request->get('toDate'));
        }
        if($request->get('fromDate') && $request->get('fromDate') != ""){

            $data->where(DB::raw('DATE(category.created_at)'),'>=',$request->get('fromDate'));
        }

        $Categories = $data->orderBy('category.created_at','DESC')->paginate($count, ['*'], 'page', $pageCategories);
        $links = $Categories->appends('page')->links();
        $filter->search = $request->get('search');
        $filter->created_at = $request->get('created_at');
        //dd(DB::getQueryLog());exit;
        return compact('Categories', 'links', 'filter');
    }

}
