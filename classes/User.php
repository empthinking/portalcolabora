<?php
declare(strict_types = 1);
class User {
    private $id;
    private $username;
    private $password;
    private $email;
    private $number;

    function __construct(string $name, string $pwd, string $email, string $num, string $id = null) {
        if (empty($name) || empty($email) || empty($pwd) || empty($num)) {
            throw new Exception("Todos os campos devem ser preenchidos");
        }

        if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
            throw new Exception("Nome deve conter apenas letras, numeros ou sublinhado apenas");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email invalido");
        }

        if (strlen($password) < 8) {
            throw new Exception("Senha deve conter 8 ou mais caracteres");
        }

        if (!preg_match("/^\([0-9]?[0-9]?\)[0-9]{9}/", $num)) {
            throw new Exception("Número em formato invalido");
            if (isset($id) && !filter_var($id, FILTER_VALIDATE_INT)) {
                throw new Exception("ID em formato invalido");
            }

            $this->id = $id;
            $this->username = trim($name);
            $this->password = $pwd;
            $this->email = trim($email);
            $this->number = trim($num);
        }

        function getName(): string {
            return $this->username;
        }
        function getNum(): string {
            return $this->number;
        }
        function getEmail(): string {
            return $this->email;
        }
        function getPassword(): string {
            return $this->password;
        }
        function getPasswordHash(): string {
            return password_hash($this->password, PASSWORD_DEFAULT);
        }
        function setName($name): void {
            $this->name = $name;
        }
        function setNum($num): void {
            $this->num = $num;
        }
        function setPassword($pwd): void {
            $this->password = $pwd;
        }
        function setEmail($email): void {
            $this->email;
        }
    }
}

class UserTable {
    private $mysqli;
    function __construct(int $conn) {
        $this->mysqli = $conn;
    }
    function setUserData(User $user): void {
        $stmt = $this ->mysqli ->prepare("INSERT INTO usuarios (user_nome, user_email, user_senha, user_tel) VALUES(?, ?, ?, ?) WHERE user_id = ?");
        $stmt = bind_param("ssssi", $id);
        $stmt = execute();
        if ($this ->mysqli ->error) {
            throw new Exception($this ->mysqli ->error);
        }
    }

    function getUserData(int $id): User {
        $stmt = $this ->mysqli ->prepare("SELECT * FROM usuarios WHERE user_id = ?");
        $stmt = bind_param("i", $id);
        if ($stmt = execute()) {
            $result = $stmt = get_result();
            $row = $result->fetch_assoc();
            return new User($row["user_nome"], $row["user_senha"], $row["user_email"], $row["user_num"], $row["user_id"]);
        }
        else {
            throw new Exception($this ->mysqli ->error);
        }
    }
    function close(): void {
        $this - mysqli->close();
    }
}

?>
