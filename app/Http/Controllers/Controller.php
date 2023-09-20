<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use NumberFormatter;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $_title = '';

    protected $_vars = [];

    private $_assets = [
        'css' => [],
        'js' => [],
    ];

    public function __construct()
    {

        // Set a callback for view composer along with the data required for layout
        view()->composer('*', function ($view) {
            $formatter = new NumberFormatter('en-IN', NumberFormatter::CURRENCY);
            $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);

            $view->with('pageVars', ['title' => $this->_title, 'assets' => $this->_assets, 'formatter' => $formatter, ...$this->_vars]);
        });
    }

    protected function user(): User|null
    {
        return auth()->user();
    }

    public function setTitle(string $title)
    {
        $this->_title = $title;
        return $this;
    }

    public function addAssets(array $assets = null)
    {
        if (!is_null($assets)) {
            if (isset($assets['js'])) {
                array_map(function ($url) {
                    call_user_func_array([$this, 'addJs'], [$url]);
                }, is_array($assets['js']) ? $assets['js'] : [$assets['js']]);
            }
            if (isset($assets['css'])) {
                array_map(function ($url) {
                    call_user_func_array([$this, 'addCss'], [$url]);
                }, is_array($assets['css']) ? $assets['css'] : [$assets['css']]);
            }
        }
        return $this;
    }

    public function addCss(string $uri)
    {
        if (array_search($uri, $this->_assets['css']) === false) {
            $this->_assets['css'][] = $uri;
        }
        return $this;
    }

    public function addJs(string $uri)
    {
        if (array_search($uri, $this->_assets['js']) === false) {
            $this->_assets['js'][] = $uri;
        }
        return $this;
    }
}
