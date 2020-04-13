<?php

function check_user_permision($request,$actionName = null, $id = null)
{
    $currentUser = $request->session()->get('userInfo');

    if(!$currentUser) return false;

    if($actionName){
        $currentActionName = $actionName;
    } else {
        $currentActionName = $request->route()->getActionName();
    }
    
    list($controller,$method) = explode('@', $currentActionName);
    $controller = str_replace(["App\\Http\\Controllers\\Admin\\", "Controller"], "", $controller);

    $crudPermisionMap = [
        'crud' => ['index','status','form','statuses','save','delete','deletes','ishome','ishomese','display','ordering']
    ];

    $classMap = [
        'Post' => 'post',
        'Category' => 'category',
        'Tag' => 'tag',
        'User' => 'user'
    ];
  
    foreach($crudPermisionMap as $permision => $methods) 
    {
        if(in_array($method,$methods) && isset($classMap[$controller]))
        {
            $className = $classMap[$controller];

            if($className == 'post' && in_array($method,['form','delete','status','statuses','deletes']))
            {
                $ids = !is_null($id) ? $id : array_wrap($request->id);
                foreach($ids as $id)
                {
                    if ( $id &&
                    (!in_array('update other post',$currentUser['permision-name']) || !in_array('delete other post',$currentUser['permision-name'])) )
                    {
                        $post = \App\Models\Post::find((int) $id);
                        if ($post->created_by !== $currentUser->username) {
                            return false;
                        }
                    }
                }
                
            } elseif(! in_array("{$permision} {$className}", $currentUser['permision-name'])) {
                return false;
            }

            break;
        }
    }
    return true;
}