<?php
namespace App\Helper;
use Config;
class Template {

    public static function showImage($controllerName,$thumbName,$thumbAlt) {
        if($thumbName == null || $thumbName == '') return '<img src="/admin/assets/image/avatar/profile-pic.jpg" alt="'.$thumbAlt.'" width="80px" class="hgcms_admin_list_post_thumb">';

        $html = sprintf('<img src="%s" alt="%s" width="80px" class="hgcms_admin_list_post_thumb">',asset("images/$thumbName"), $thumbAlt);

        return $html;
    }

    public static function showTaxonomies($taxonomyController,$taxonomies) {
        $html = '';
        $htmlArr = [];

        if(count($taxonomies) > 0) {
            //route($taxonomyController.'/'.$tax['id'])
            foreach($taxonomies as $tax) {
                $htmlArr[] = sprintf('<a href="%s" >%s</a>', '#',$tax['name']);
            }
            $html = implode(',',$htmlArr);
        } else {
            $html = '<a href="javascript:;">No Tag Found</a>';
        }

        return $html;
    }

    public static function showCategory($categoryController, $taxonomies)
    {
        $html = '';
        $htmlArr = [];

        if($taxonomies) {
            $html = sprintf('<a href="%s" >%s</a>', '#',$taxonomies['name']);
        } else {
            $html = '<a href="javascript:;">Uncategorized</a>';
        }

        return $html;
    }
    
    public static function showStatus($controllerName,$status,$id) {
        $link = route($controllerName.'/status',['status' => $status,'id'=>$id]);

        $classStatus = ($status == 'active')? 'btn-light-success btn-h-light-success btn-a-light-success': 'btn-light-warning btn-h-light-warning btn-a-light-warning';

        return '<a href="'.$link.'" class="btn btn-sm  '.$classStatus.' fs--outline">'.ucfirst($status).'</a>';
    }

    public static function showIsHome($controllerName,$ishome,$id) {
        $link = route($controllerName.'/ishome',['ishome' => $ishome,'id' => $id]);

        $classIsHome = ($ishome == 'yes')? 'btn-light-success btn-h-light-success btn-a-light-success': 'btn-light-warning btn-h-light-warning btn-a-light-warning';

        return '<a href="'.$link.'" class="btn btn-sm  '.$classIsHome.' fs--outline">'.ucfirst($ishome).'</a>';
    }

    public static function showDisplay($display,$id) {
        $templateDisplay = Config::get('hgcms.template.display');

        $html = '<select class="form-control select-display">';

        foreach($templateDisplay as $key => $value) {
            $selected = ($key == $display)? 'selected':'';

            $html.='<option value="'. $key .'" '. $selected .'>'. $value .'</option>';
        }
        $html.= '</select>';

        return $html;
    }

    public static function showStatusFilters($controllerName,$params,$statusFilters) {
        $html = '';

        $statusTemplate = Config::get('hgcms.template.status');

        if(count($statusFilters) > 0) {
            array_unshift($statusFilters,[
                'status' =>'all',
                'count' =>array_sum(array_column($statusFilters,'count'))
            ]);

            foreach($statusFilters as $item) {
                $link = route($controllerName).'?filter_status='.$item['status'];

                if($params['search']['value'] != '' && $params['search']['field'] != '') $link.= '&search_field='.$params['search']['field'].'&search_value='.$params['search']['value'];

                if(isset($params['filter']['category']) && $params['filter']['category'] != '') $link.='&filter_category='.$params['filter']['category'];

                if(isset($params['filter']['tag']) && $params['filter']['tag'] != '') $link.='&filter_tag='.$params['filter']['tag'];

                if(isset($params['filter']['ishome']) && $params['filter']['ishome'] != '') $link.='&filter_ishome='.$params['filter']['ishome'];

                if(isset($params['filter']['display']) && $params['filter']['display'] != '') $link.='&filter_display='.$params['filter']['display'];

                $statusValue = $item['status'];
                $statusValue = array_key_exists($statusValue,$statusTemplate)?  $statusValue: 'default';
                $statusName = $statusTemplate[$statusValue];
                $currentStatus = $params['filter']['status'];
                $classActive = $currentStatus == $statusValue? 'btn-success': 'btn-light';
                $html.= sprintf('<a href="%s" class="btn mr-2 %s">%s (%s)</a>',$link,$classActive, $statusName, $item['count']);
            }

        }

        return $html;
    }

    public static function showHistory($date,$user) {
        $timeFormat = Config::get('hgcms.format.short_time');

        $html = '';
        if($date != '' && $user != '') {
            $html.= sprintf('<p><i class="fa fa-clock mr-1"></i> %s</p>
            <p><i class="fa fa-user mr-1"></i>%s</p>',date($timeFormat,strtotime($date)),$user);
        }
        return $html;
    }

    public static function showAction($controllerName,$id) {
        $actions = Config::get('hgcms.template.action');
        
        $html = '<div class="d-none d-lg-flex text-muted">';

        foreach($actions as $ac) {
            $link = route($controllerName.'/' .$ac['route'],['id' =>$id]);
            $html .= sprintf('<a href="%s" class="btn btn-outline-danger btn-h-outline-danger btn-a-outline-danger btn-text-%s %s"><i class="%s"></i> %s</a>', $link, $ac['class'],$ac['route'].'-action',$ac['icon'],$ac['name']);
        }

        $html .= '</div>';

        return $html;
        
    }

    public static function showSearchFilters($controllerName,$params) {
        $fieldTemplate = Config::get('hgcms.template.search');

        $search_value = $params['search']['value'];
        $search_field = $params['search']['field'];
        $query = [];

        if($params['filter']['status'] !== '') $query[] = 'filter_status='.$params['filter']['status'];
        if($params['pagination']['page'] != '') $query[] = 'page='.$params['pagination']['page'];

        $query = implode('&',$query);

        $clear_link = route($controllerName).'?'.$query;

        $searchHtml = '<select name="search_field" id="search_field" class="form-control">';

        foreach($fieldTemplate as $key => $field) {
            $selected = ($search_field == $key)? 'selected' : '';
            $searchHtml.= '<option value="'.$key.'" '.$selected.'> '.$field.' </option>';
        }

        $searchHtml.='</select>';
        $html = '<div class="form-group form-inline" style="float:right;">
                    '.$searchHtml.'
                    <input type="text" class="form-control ml-2" value="'.$search_value.'" name="search_value" id="search_value" placeholder="Search...">
                    <button id="search_filter" class="btn btn-warning ml-2"><i class="fa fa-search mr-1"></i>Search</button>
                    <a href="'.$clear_link.'" id="clear_search" class="btn btn-success ml-2"><i class="fa fa-sync mr-1"></i>Clear</a>
                </div>';

        return $html;
    }

    public static function showTerms($controllerName,$params,$terms,$termName) {
        
        $firstquery = [];
        if($params['filter']['status'] != '') $firstquery[] = 'filter_status='.$params['filter']['status'];
        if($params['search']['value'] != '') $firstquery[] = 'search_field='.$params['search']['field'].'&search_value='.$params['search']['value'];

        $other = $termName == 'filter_category' ? 'filter_tag': 'filter_category';
        $otherTerms = explode('_',$other);
        if($params[$otherTerms[0]][$otherTerms[1]] != '') $firstquery[] = $other.'='.$params[$otherTerms[0]][$otherTerms[1]];
        $firstquery[] = $termName.'=0';
        $firstquery = implode('&',$firstquery);
        $firstLink = route($controllerName).'?'.$firstquery;
        
        $html = '<div class="form-group form-inline">
                    <select name="category" id="category" class="form-control">
                        <option value="'.$firstLink.'"> View All Categories </option>';
        
        if(count($terms) > 0) {

            foreach($terms as $term) {
                $link = route($controllerName);
                $query = [];

                if($params['filter']['status'] != '') $query[] = 'filter_status='.$params['filter']['status'];
                if($params['search']['value'] != '') $query[] = 'search_field='.$params['search']['field'].'&search_value='.$params['search']['value'];

                if($params[$otherTerms[0]][$otherTerms[1]] != '') $query[] = $other.'='.$params[$otherTerms[0]][$otherTerms[1]];

                $query[] = $termName.'='.$term['id'];
                $query = implode('&',$query);
                $link.= '?'.$query;
                $currentTerms = explode('_',$termName);

                $selected = ($term['id'] == (int) $params[$currentTerms[0]][$currentTerms[1]])? 'selected': '';
                $html.= '<option value="'.$link.'" '.$selected.'> '.$term['title'].' </option>';
            }
        }

        $html.='</select>
                    <button class="btn btn-primary mb-2px ml-2 filter-term">Filter</button>
                </div>';

        return $html;
    }

    public static function showTermsFilter($terms,$params,$termName) 
    {
        $termNameArr = explode('_', $termName);
        $name = ucfirst($termNameArr[1]);

        $html = '<select data-field="'.$termName.'" id="'.$termName.'" class="form-control ml-2">
                    <option value="0"> View All '.$name.' </option>';

        foreach($terms as $term) 
        {
            $selected = ($term['id'] == $params[$termNameArr[0]][$termNameArr[1]])? 'selected' : '';
            $html.= '<option value="'.$term['id'].'" '.$selected.'> '.$term['name'].' </option>';
        }
                  
        $html.='</select>';

        return $html;
    }

    public static function showHomeAndDisplay($params,$type) {
        $homeDisplayArr = explode('_',$type);
        $template = Config::get('hgcms.template.'.$homeDisplayArr[1]);
       
        $html = '<select data-field="'.$homeDisplayArr[1].'" id="'.$type.'" class="form-control ml-2">
        <option value="all"> View All '.$homeDisplayArr[1].' </option>';

        foreach($template as $key => $value) {
            $selected = ($key == $params[$homeDisplayArr[0]][$homeDisplayArr[1]])? 'selected' : '';
            $html.= '<option value="'.$key.'" '.$selected.'> '.$value.' </option>';
        }

        $html.='</select>';
        
        return $html;
    }

    public static function showBulkAction($controllerName) {
        $bulkTemplate = Config::get('hgcms.template.bulk.'.$controllerName);

        $html = '<select name="bulkaction" id="bulkaction" class="form-control">';
        foreach($bulkTemplate as $key=> $action) {
            $params = [];

            if($action['key'] != '') {
                $params = [$action['key'] => $key];
            }

            $link = ($action['route'] == '')? '': route($controllerName.'/'.$action['route'],$params);
            $html.= '<option value="'.$link.'"> '.$action["name"].' </option>';
        }

        $html.= '</select>';

        return $html;
    }

    public static function setActiveCategory($categories,$current_cat_id) {
        $html= '';

        if($categories)
        {
            foreach($categories as $key => $category) 
            {
                $selected = $category['id'] == $current_cat_id ? 'checked': '';
                $html.= sprintf('<div>
                            <label>
                                <input type="radio" name="category_id" value="%s" %s>
                                    %s
                            </label>
                        </div>', $category['id'],$selected,$category['name']);
            }

        } else {
            $html = '<div>
                        <label for="empty-cat">Pls Create Category</label>
                    </div>';
        }
        
        return $html;
    }

    public static function setActiveTag($tags) {
        if($tags) 
        {
            $tagArr = [];

            foreach($tags as $tag) 
            {
                $tagArr[] = "'".$tag['name']."'";
            }

            $tagStr = '['.implode(',',$tagArr).']';

            return '<script> var tagArr = '.$tagStr.';</script>';
        }

        return '<script>var tagArr = [];</script>';
    }

    public static function setTask($task) {

        return '<script>var task = "'.$task.'"</script>';
    }

    public static function setControllerVar($controllerName) {

        return '<script>var controllerName = "'.$controllerName.'"</script>';
    }

    public static function showSelectRow($roles,$currentRole) {
        $html = '';

        if($roles !== null && count($roles) > 0) {
            $html.= '<select name="level" class="form-control">';

            foreach($roles as $r) {
                $selected = $r['name'] == $currentRole ? 'selected' : '';
                $html.= '<option value="'. $r['id'] .'"  '. $selected .' >'. $r['name'].'</option>';
            }
            $html.= '</select>';
        }

        return $html;
    }
}