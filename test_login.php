<?php
function isUserLoggedIn(): bool {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

if(isUserLoggedIn())
  echo 'success';
else
  echo 'failed';
