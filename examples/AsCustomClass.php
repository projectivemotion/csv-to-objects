<?php
/**
 * Project: CsvToObjects
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */


require_once __DIR__ . '/../src/Csv.php';

assert_options(ASSERT_BAIL, 0);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_CALLBACK, function (){
    print_r(func_get_args());
    exit(1);
});

class User
{
    protected $Password =   '';
    protected $Username =   '';

    public function __construct($data)
    {
        $this->Password =   $data['Password'];
        $this->Username =   $data['Username'];
    }

    public function CheckPassword($pass)
    {
        $check  =   password_verify($pass, $this->Password);
        if($check)
            echo "Password is $pass!\n";
        else
            echo "Incorrect password!\n";

        return $check;
    }
}

/** @var User[] $users */
$users  =   \projectivemotion\Csv\Csv::StringToObjects(<<<'ND'
Username,Password
amado,$2y$10$EncFfzZYNSnswCKCNGmfTuICpGXaWthOd3BnZPYL.N8L0SH64VTF6
ND
    ,
    ['User']
);

assert($users[0]->CheckPassword('safepassword') === false);
assert($users[0]->CheckPassword('abc123') === true);