<?php

namespace App\Models\Filterable;

enum FilterOperator: string
{
    case Equal = '=';
    case Like = 'like';
}
