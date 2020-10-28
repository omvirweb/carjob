<?php

namespace App\Services;
use DB;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;

class ItemService{

    protected $ItemService = null;
    const ELEMENTS_PER_PAGE = Controller::DEFAULT_ELEMENTS_PER_PAGE;

    public function getItem(Request $request, $count = self::ELEMENTS_PER_PAGE)
    {
        $user = \Auth::user();
        $pageItem = $request->get('page') ? $request->get('page') : 1;
        $q = trim($request->get('search'));
        $filter = (object)[];
        //DB::enableQueryLog();
        $data = Item::select(DB::raw('item.*,category.categoryName'))
            ->leftJoin('category', 'category.id', '=', 'item.categoryId')
            ->when($q, function ($query) use ($q,$request) {
                return $query->where(function ($query) use ($q,$request) {
                    /** @var Builder $query */
                    $preparedQ = '%' .$q. '%';
                    $num = 0;
                    foreach (
                        [
                            'item.itemName',
                            'item.categoryId',
                            'item.status',
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

            $data->where(DB::raw('DATE(item.created_at)'),'<=',$request->get('toDate'));
        }
        if($request->get('fromDate') && $request->get('fromDate') != ""){

            $data->where(DB::raw('DATE(item.created_at)'),'>=',$request->get('fromDate'));
        }

        $Item = $data->orderBy('item.created_at','DESC')->paginate($count, ['*'], 'page', $pageItem);
        $links = $Item->appends('page')->links();
        $filter->search = $request->get('search');
        $filter->created_at = $request->get('created_at');
        //dd(DB::getQueryLog());exit;
        return compact('Item', 'links', 'filter');
    }

}
