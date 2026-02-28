<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserFilters
{
    public function apply(Request $request, Builder $query) : Builder
    {
        //в поле name ищем вхождение текста, пришедшего в ключе name
        if($request->has('name') && $request->get('name') != null){
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }
        //в поле email ищем полное совпадение с ключём email
        if($request->has('email') && $request->get('email') != null){
            $query->where('email', '=', $request->get('email'));
        }
        //в поле is_admin ищем полное совпадение с ключём active
        if($request->has('active') && $request->get('active') != null){
            $query->where('is_admin', '=', $request->get('active'));
        }
        //поле is_admin сравниваем с ключём active
        if($request->has('active') && $request->get('active') != null){
            $query->where('is_admin', '=', $request->get('active'));
        }
        //поле created_at сравниваем с ключём date_from
        if($request->has('date_from') && $request->get('date_from') != null){
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }
        //поле created_at сравниваем с ключём date_to
        if($request->has('date_to') && $request->get('date_to') != null){
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }
        //$query->whereBetween('created_at',[$request->get('date_from'), $request->get('date_to')]);
        return $query;
    }
}
