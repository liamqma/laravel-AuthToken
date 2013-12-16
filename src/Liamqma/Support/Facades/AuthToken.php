<?php

namespace Liamqma\Support\Facades;

use Illuminate\Support\Facades\Facade;

class AuthToken extends Facade {

  protected static function getFacadeAccessor() { return 'liamqma.auth.token'; }
}