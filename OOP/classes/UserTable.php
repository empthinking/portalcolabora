<?php
require_once 'Table.php';
require_once 'User.php';

class UserTable extends Table {

    private table_name;

    //Colunas
    private id;
    private username;
    private email;
    private password;
    private number;

    function __construct(
        mysqli $db,
        string $table_name = U_TABLE,
        int    $id         = U_ID,
        string $username   = U_N,
        string $email      = U_E,
        string $password   = U_P,
        string $number     = U_NUM
    ) {
        parent::__construct($db, $table_name);
        $this->id       = $id;
        $this->username = $username;
        $this->email    = $email;
        $this->password = $password;
        $this->number   = $number;
    }

    private function emailVerify(string $email) : bool{
        $sql_prep = "SELECT $this->email FROM $this->table_name WHERE $this->email = ? LIMIT 1";
        $stmt = $this->db->prepare($sql_prep);
        $stmt->execute([$email]);
        $result = $stmt->get_result();
        $stmt->close();
        $isEmailRegistered = $result->num_rows > 0;
        $result->close();
        return $isEmailRegistered;
    }

    public function getUserByEmail(string $email) : bool | User {
        $sql_prep = "SELECT * FROM $this->table_name where $this->email = ? LIMIT 1";
        if (!$row = $this->secureGetOneRow($sql_prep, $email))
            return FALSE;

        $user = new User();

        $user->setId($row[(string)$this->id]);
        $user->setUsername($row[$this->username]);
        $user->setEmail($row[$this->email]);
        $user->setPassword($row[$this->password]);
        $user->setNumber($row[$this->number]);

        return $user;

    }

    public function login(User $user) : bool {
        $email    = $user->getEmail();
        $password = $user->getPassword();

        if(!$email || !$password) {
            $this->error = 'Email ou senha não inseridos';
            return FALSE;
        } 

        $sql_prep = "SELECT * FROM $this->table_name WHERE $this->email = ?";
        $row      = $this->secureGetOneRow($sql_prep, $email);

        if(!password_verify($row[$this->password], $password) {
            $error = 'Email ou Senha inálido';
            return FALSE;
        }

        $_SESSION[(string)$this->id] = $row[(string)$this->id];
        $_SESSION[$this->username]   = $row[$this->username];
        $_SESSION[$this->email]      = $row[$this->email];
        $_SESSION[$this->number]     = $row[$this->number];
    }

    public function register(User $user) : bool {
        $username = $user->getUserName();
        $email    = $user->getEmail();
        $password = $user->getPassword();
        $number   = $user->getNumber();

        if($this->emailVerify($email)) {
            $this->error = 'Email já registrado';
            return FALSE;
        }

        $sql = "INSERT INTO $this->table_name($this->username, $this->email, $this->password, $this->number) VALUES (?, ?, ?, ?)"; 
        return $this->secureSqlQuery($sql, $username, $email, $password, $number);
    }

    public function update(User $user) : bool {

        $user_id = $user->getId();

        $dataToUpdate = array(
            $this->username => $user->getUserName(),
            $this->email    => $user->getEmail(),
            $this->password => $user->getPassword(),
            $this->number   => $user->getNumber()
        );

        foreach($dataToUpdate as $table => $data) {
            if(!$data || empty($data))
                continue;

            $sql = "UPDATE FROM $this->table_name SET $table = ? WHERE $this->id = ?";

            if(!$this->secureSqlQuery($sql, $data, $id))
                return FALSE;

        }

        return TRUE;
    }

    public function deleteUser(int $id) : bool {
        $sql_prep = "DELETE FROM $this->table_name WHERE $this->id = ?";
        return = $this->secureSqlQuery($sql_prep, $id);
    }
}
