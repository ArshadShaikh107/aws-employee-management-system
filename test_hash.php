<?php

$hash = '$2y$10$k5OCpekAVWKR1SdIgua1GevleJlr76RycIjKPc4NfvLWc6RUvL47a';

echo "Hash Length: " . strlen($hash) . "<br><br>";

if(password_verify("Admin@123", $hash)){
    echo "Password Match";
}else{
    echo "Password Does NOT Match";
}