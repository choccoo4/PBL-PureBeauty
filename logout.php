<?php
session_start();
session_destroy();
header("Location: login.php");
exit();

/*
1. Mulai
2. Mulai session dan hancurkan session untuk logout
3. Arahkan pengguna ke halaman login.php
4. Akhiri
*/
