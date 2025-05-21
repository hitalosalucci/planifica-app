<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
  public function register()
  {
      $this->renderable(function (Throwable $e, $request) {
          if ($request->expectsJson() || $request->is('api/*')) {
              return response()->json([
                  'message' => $e->getMessage(),
                  'code' => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500
              ], 500);
          }

          // Permite que o Vue.js trate erros em rotas frontend
          if ($request->is('/*')) {
              return response()->view('app'); // Retorna o HTML base do Vue
          }
      });
  }

}