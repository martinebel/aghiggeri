<?php
if (!is_writable(session_save_path())) {
    echo 'Session path "'.session_save_path().'" is not writable for PHP!';
}
else {
  echo 'Session path "'.session_save_path().'" is writable for PHP!';
}
 ?>
