<?php

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Products table handling model class
 */
class Page extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Provide Product Manufacturer using belongs to relationship.
     *
     * @return App\Modules\Product\Models\Manufacturer
     */
   
    public static function getPagesForAdminList($paginate=false, $params=[]) {
        $query = Page::selectRaw('*');

        if(isset($params['sort'])) {
            $sort = explode('-', $params['sort']);
            $col = $sort[0] ?? '';
            $direction = $sort[1] ?? '';
            if($col!='' && $direction!='') {
                if($col=='link_page') $col = 'link_name_pag';
                $query->orderBy($col, $direction);
            }
        } else {
            $query->orderBy('id', 'Desc');
        }

        if(count($params)>0 && isset($params['search'])) {
            if($params['id']) {
                $query->where('id', 'Like', '%'.$params['id']."%");
            }
           
            if($params['name']) {
                $query->where('name', 'Like', '%'.$params['name']."%");
            }

            if($params['comments']) {
                $query->where('comments', 'Like', '%'.$params['comments']."%");
            }

            // if($params['link_name_pag']) {
            //     $query->where('link_name_pag', 'Like', '%'.$params['link_name_pag']."%");
            // }

            if($params['updated_at']) {
                $query->where('updated_at', 'Like', '%'.date('Y-m-d', strtotime($params['updated_at']))."%");
            }
            
        }
        if($paginate) {
            return $query->paginate(20);
        } else {
            return $query->get();
        }
    }

    /**
     * Return Manufacturer validation rules.
     *
     * @return array
     */
    public static function getValidationRules() {
        return [
            'page.name' => 'required|max:100|unique:pages,name',
            'page.comments' => 'required|max:100|unique:pages,name',
            // 'page.link_name_pag' => 'required|max:100',
            'page.content' => 'required',
            // 'page.order_page' => 'nullable|numeric|max:1000'
        ];
    }

    /**
     * Return dynamic page links for footer.
     *
     * @return array
     */
    public static function getDynamicPageLink($id, $onlyURL = false) {
        $page = Page::find($id);
        if($page) {
            if($onlyURL)
                return url($page->link_name_pag);
            else
                return '<a href="'.url($page->link_name_pag).'">'.$page->name.'</a>';
        } else
            return false;
    }


    public static function getPageContent($id) {
        $page = Page::find($id);
        if($page) {
            return str_replace('{SITE_NAME}', 'Test site',$page->content);
        } else
            return false;
    }

    public static function getDBADiffYears() {
        $date1 = new \DateTime("1982-03-01");
        $date2 = new \DateTime("now");
        $interval = $date1->diff($date2);
        return $interval->y;
    }

}