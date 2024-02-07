
<?php

class DatabaseConnection
{
    private $server = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "pharma";
    private $con;

    public function __construct()
    {
        try {
            $this->con = new PDO("mysql:host=$this->server;dbname=$this->db;charset=UTF8", $this->user, $this->pass);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->handleConnectionError($e->getMessage());
        }
    }

    public function fetchDataById($id) {
        
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getMedicineNames()
    {
        $sql = "SELECT medicineName FROM products";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        
        $medicineNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $medicineNames;
    }

    public function getConnection()
    {
        return $this->con;
    }

    private function handleConnectionError($errorMessage)
    {

        echo (urlencode($errorMessage));
        die();
    }


    public function getUserInfo($username)
    {
        $sql = "SELECT * FROM user WHERE UserName = :username LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createUser($username, $fullname, $email, $password, $password_confirmed, $phone, $designation)
    {
        $insertionStatus = new stdClass();
        $insertionStatus->error = false;
        $insertionStatus->success = false;
        $insertionStatus->validation = true;
        $insertion_errors = "";

        if ($password_confirmed !== $password) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nPasswords do not match.";
        }
        if (empty(trim($username)) || strlen(trim($username)) < 5) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nUsername is invalid.";
        } else {
            $stmt = $this->getConnection()->prepare("SELECT COUNT(*) FROM user WHERE UserName = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $insertionStatus->validation = false;
                $insertion_errors = $insertion_errors . "\nUsername is already registered.";
            }
        }
        if ((empty(trim($fullname))) || strlen(trim($fullname)) < 5) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nFull name is invalid.";
        }
        if ((empty(trim($password))) || (empty(trim($password_confirmed)))) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nPasswords are invalid.";
        }
        if (empty(trim($designation)) || !in_array($designation, ['storekeeper', 'pharmacist', 'manager'])) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nDesignation is invalid.";
        }
        if (empty(trim($email)) || !preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$/", $email)) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nEmail is invalid.";
        } else {
            $stmt = $this->getConnection()->prepare("SELECT COUNT(*) FROM user WHERE Email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $insertionStatus->validation = false;
                $insertion_errors = $insertion_errors . "\nEmail address is already registered.";
            }
        }
        if (empty(trim($phone)) || !preg_match("/^\d{10}$/", $phone)) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nPhone is invalid.";
        }

        if ($insertionStatus->validation) {
            $insert_query = "INSERT INTO user (FullName, UserName, Email, Password, Phone, Designation) VALUES (:fullname, :username, :email, :password, :phone, :designation)";

            $stmt = $this->getConnection()->prepare($insert_query);

            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':designation', $designation, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $insertionStatus->success = true;
            } else {
                $insertionStatus->error = true;
            }
        } else {
            $insertionStatus->insertion_errors = $insertion_errors;
        }
        return $insertionStatus;
    }

    public function verifyUser($uID)
    {
        $sql = "SELECT Email FROM user WHERE UserID = :uID LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(':uID', $uID, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllOfAnEntiry($entity, $getInactive = true)
    {
        if ($getInactive) {
            $sql = "SELECT * FROM " . "`" . $entity . "`;";

            $stmt = $this->getConnection()->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            $sql = "SELECT * FROM " . "`" . $entity . "`" . " WHERE Activated = true;";

            $stmt = $this->getConnection()->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function searchAnEntity($entity, $searchAttribute, $searchValue)
    {
        $insertionStatus = new stdClass();
        $insertionStatus->error = false;
        $insertionStatus->success = false;
        $insertionStatus->validation = true;
        $insertion_errors = "";

        $stmt = $this->getConnection()->prepare("SELECT *  FROM " . "`" . $entity . "`" . " WHERE " . "`" . $searchAttribute . "`" . " LIKE :searchValue ;");
        $searchValueWithWildcard = '%' . $searchValue . '%';
        $stmt->bindParam(':searchValue', $searchValueWithWildcard, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (count($results) < 1) {
            $insertionStatus->validation = false;
            $insertionStatus->insertion_errors = $insertion_errors . "\n No results.";
        } else {
            $insertionStatus->success = true;
            $insertionStatus->results = $results;
        }
        return $insertionStatus;
    }

    public function getAllOfAnEntityColumnCondition($entity, $column, $value)
    {
        $sql = "SELECT * FROM " . "`" . $entity . "` WHERE " . "`" . $column . "` = :value ;";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMultipleColumnValsOfAnEntity($tableName, $columnDataArray)
    {
        $columns = array();
        $params = array();
        foreach ($columnDataArray as $columnData) {
            $columns[] = $columnData['columnName'];
            $params[':' . $columnData['columnName']] = $columnData['colValue'];
        }

        $columnsString = implode(', ', $columns);
        $query = "SELECT $columnsString FROM $tableName WHERE ";

        $conditions = array();
        foreach ($columns as $column) {
            $conditions[] = "$column = :" . $column;
        }
        $query .= implode(' AND ', $conditions);
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    public function createSupplier($supplierName, $contact, $email, $additionalInfo, $address)
    {
        $insertionStatus = new stdClass();
        $insertionStatus->error = false;
        $insertionStatus->success = false;
        $insertionStatus->validation = true;
        $insertion_errors = "";

        if (empty(trim($supplierName))) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\Suppliername is invalid.";
        } else {
            $stmt = $this->getConnection()->prepare("SELECT COUNT(*) FROM supplier WHERE SupplierName = :supplierName");
            $stmt->bindParam(':supplierName', $supplierName, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $insertionStatus->validation = false;
                $insertion_errors = $insertion_errors . "\nSupplier Name is already registered.";
            }
        }
        if ((empty(trim($contact))) || strlen(trim($contact)) < 1) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\n Contact name is invalid.";
        }
        if ((empty(trim($address))) || strlen(trim($address)) < 1) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nAddress is invalid.";
        }
        if ((empty(trim($additionalInfo))) || strlen(trim($additionalInfo)) < 1) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nAddress is invalid.";
        }

        if (empty(trim($email)) || !preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$/", $email)) {
            $insertionStatus->validation = false;
            $insertion_errors = $insertion_errors . "\nEmail is invalid.";
        } else {
            $stmt = $this->getConnection()->prepare("SELECT COUNT(*) FROM supplier WHERE E_mail = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $insertionStatus->validation = false;
                $insertion_errors = $insertion_errors . "\nEmail address is already registered.";
            }
        }

        if ($insertionStatus->validation) {
            $insert_query = "INSERT INTO supplier (SupplierName, Address, E_mail, Contact, AdditionalInfo) VALUES (:name, :address, :email, :contact, :additional)";

            $stmt = $this->getConnection()->prepare($insert_query);

            $stmt->bindParam(':name', $supplierName, PDO::PARAM_STR);
            $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':additional', $additionalInfo, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $insertionStatus->success = true;
            } else {
                $insertionStatus->error = true;
            }
        } else {
            $insertionStatus->insertion_errors = $insertion_errors;
        }
        return $insertionStatus;
    }
}
