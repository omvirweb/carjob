<?php

namespace App\Services;
use DB;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\ItemDetails;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;

class ItemDetailsService{

    protected $ItemDetailsService = null;
    const ELEMENTS_PER_PAGE = Controller::DEFAULT_ELEMENTS_PER_PAGE;

    public function getItemDetails(Request $request, $count = self::ELEMENTS_PER_PAGE)
    {
        $user = \Auth::user();
        $pageItemDetails = $request->get('page') ? $request->get('page') : 1;
        $q = trim($request->get('search'));
        $filter = (object)[];
        //DB::enableQueryLog();
        $data = ItemDetails::select(DB::raw('item_details.*, item.itemName,category.categoryName'))
            ->leftJoin('item', 'item.id', '=', 'item_details.itemid')
            ->leftJoin('category', 'category.id', '=', 'item_details.categoryid')
            ->when($q, function ($query) use ($q,$request) {
                return $query->where(function ($query) use ($q,$request) {
                    /** @var Builder $query */
                    $preparedQ = '%' .$q. '%';
                    $num = 0;
                    foreach (
                        [
                            'category.categoryName',
                            'item.itemName',
                            'item_details.weight',
                            'item_details.less',
                            'item_details.net_wt',
                            'item_details.purity',
                            'item_details.fine',
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

            $data->where(DB::raw('DATE(item_details.created_at)'),'<=',$request->get('toDate'));
        }
        if($request->get('fromDate') && $request->get('fromDate') != ""){

            $data->where(DB::raw('DATE(item_details.created_at)'),'>=',$request->get('fromDate'));
        }

        $ItemDetails = $data->orderBy('item_details.created_at','DESC')->paginate($count, ['*'], 'page', $pageItemDetails);
        $links = $ItemDetails->appends('page')->links();
        $filter->search = $request->get('search');
        $filter->created_at = $request->get('created_at');
        //dd(DB::getQueryLog());exit;
        return compact('ItemDetails', 'links', 'filter');
    }

}
