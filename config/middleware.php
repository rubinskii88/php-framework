<?php

return [
  'trim' => \App\Middleware\ChangeRequest::class,
  'message' => \App\Middleware\ChangeResponse::class,
  'deny' => \App\Middleware\Redirect::class
];