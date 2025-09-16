 <?php

    use APP\Settings;
    use TOOL\Security\Auth;

    /*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);
// header("Content-Type: application/json");
// echo "{
//     text: 'hello'
// }";
Settings::getCaissier()->print();
