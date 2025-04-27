<?php

function escape(string $data)
{
  htmlspecialchars(
    $data,
    ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
    'UTF-8'
  );
}
