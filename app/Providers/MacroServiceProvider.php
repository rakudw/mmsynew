<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\Support\Str;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        ComponentAttributeBag::macro('build', function(object $attributes) {
            $attrs = (array)$attributes;
            unset($attrs['class']);
            if (isset($attrs['name'])) {
                $attrs['id'] = $attrs['name'] . '_element';
            }
            return (new ComponentAttributeBag($attrs))->__toString();
        });

        ComponentAttributeBag::macro('buildOptions', function(object $element, $model = null) {
            $options = explode(':', $element->attributes->{'data-options'}, 2);
            switch($options[0]) {
                case 'csv':
                    $csv = str_getcsv($options[1]);
                    return array_combine($csv, $csv);
                    break;
                case 'dbase':
                    $columns = Str::betweenFirst($options[1], '(', ')');
                    $conditions = Str::betweenFirst($options[1], '[', ']');
                    $table = str_replace(["($columns)", "[$conditions]"], '', $options[1]);

                    return MacroServiceProvider::query(ucfirst($table), str_getcsv($columns), explode(',', $conditions), $model);
                    break;
                default:
                    return [];
            }
        });
    }

    public static function evaluate($code, $model = null) {
        $result = null;
        eval('$result = ' . $code . ';');
        return $result;
    }

    public static function query(string $table, array $columns, array $conditionStrs, $model = null) {
        $conditions = [];
        foreach($conditionStrs as $part) {
            $condition = explode(':', $part, 2);
            if (count($condition) == 2) {
                if(substr($condition[1], 0, 1) == '.') {
                    $result = MacroServiceProvider::evaluate(substr($condition[1], 1), $model);
                    if($result) {
                        $conditions[$condition[0]] = $result;
                    }
                } else {
                    $conditions[$condition[0]] = substr($condition[1], 0, 1) == '$' ? old(substr($condition[1], 1)) : $condition[1];
                }
            }
        }
        if (class_exists("\\App\\Models\\$table")) {
            return call_user_func_array(["\\App\\Models\\$table", 'select'], [$columns])->where($conditions)->orderBy($columns[1])->get()->keyBy($columns[0])->map(function ($o) use ($columns) {
                return $o->{$columns[1]};
            })->toArray();
        } else {
            return [];
        }
    }
}
