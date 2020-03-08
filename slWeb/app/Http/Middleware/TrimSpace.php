<?php

namespace App\Http\Middleware;

use Closure;

/**
 * フォームから入力された文字の前後から空白を取り除く
 *
 * Class TrimSpace
 * @package App\Http\Middleware
 */
class TrimSpace
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        $request->merge($this->trim($input));

        return $next($request);
    }

    private function trim($value)
    {
        if (is_array($value))
        {
            $value = array_map(['self', 'trim'], $value);
        }
        elseif (is_string($value))
        {
            $value = preg_replace('/(^\s+)|(\s+$)/u', '', $value);
        }

        return $value;
    }
}
