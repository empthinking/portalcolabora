<?php
#require_once 'Table.php';

class UserTable{

    private $table_name;

    //Colunas
    private $user_id;
    private $username;
    private $email;
    private $password;
    private $number;

    function __construct(
        mysqli $db,
        string $table_name = U_TABLE,
        string $id         = U_ID,
        string $username   = U_N,
        string $email      = U_E,
        string $password   = U_P,
        string $number     = U_NUM
    ) {
        #parent::__construct($db);
	$this->table_name = $table_name;
        $this->user_id    = $id;
        $this->username   = $username;
        $this->email      = $email;
        $this->password   = $password;
        $this->number     = $number;
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
        if (!$row = $this->secureSqlQuery($sql_prep, array($email), TRUE))
            return FALSE;

        $user = new User();

        $user->setId($row[$this->user_id]);
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
        $row      = $this->secureSqlQuery($sql_prep, $email, TRUE);

        if(!password_verify($row[$this->password], $password)) {
            $this->error = 'Email ou Senha inálido';
            return FALSE;
        }

        $_SESSION[$this->user_id]  = $row[$this->user_id];
        $_SESSION[$this->username] = $row[$this->username];
        $_SESSION[$this->email]    = $row[$this->email];
        $_SESSION[$this->number]   = $row[$this->number];
    }

    public function register(User $user) : bool {
        $username = $user->getUserName();
        $email    = $user->getEmail();
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $number   = $user->getNumber();

        if($this->emailVerify($email)) {
            $this->error = 'Email já registrado';
            return FALSE;
        }

        $sql = "INSERT INTO $this->table_name($this->username, $this->email, $this->password, $this->number) VALUES (?, ?, ?, ?)"; 
        return $this->secureSqlQuery($sql, array($username, $email, $password, $number));
    }

    public function update(User $user) : bool {

        $user_id = $user->getId();

        $dataToUpdate = array(
            $this->username => $user->getUserName(),
            $this->email    => $user->getEmail(),
            $this->password => $user->getPassword(),
            $this->number   => $user->getNumber()
        );

        foreach($dataToUpdate as $column => $value) {
            if(!$value || empty($value))
                continue;

            $sql_prep = "UPDATE $this->table_name SET $column = ? WHERE $this->user_id = ?";

            if(!$this->secureSqlQuery($sql_prep, array($value, $user_id)))
                return FALSE;

        }

        return TRUE;
    }

    public function deleteUser(int $id) : bool {
        $sql_prep = "DELETE FROM $this->table_name WHERE $this->user_id = ?";
        return $this->secureSqlQuery($sql_prep, array($id));
    }
}
