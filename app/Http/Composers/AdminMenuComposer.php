<?php

namespace Http\Composers;

use Illuminate\View\View;

class AdminMenuComposer
{
    public function compose(View $view)
    {
        $view->with();
    }
}
