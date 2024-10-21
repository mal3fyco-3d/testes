<?php

class Order{

    private $conn;
    public $order_id;
    public $username;
    public $total;
    public $state;
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Método para ler todos os elementos da tabela
     * @return PDOStatement Devolve PDOStatement com todos os elementos da tabela
     */
    function readO() {

        // Query SQL
        $query = "SELECT 
                order_id, username, state, total 
            FROM
                Orders
            
            ORDER BY
                order_id DESC";

        // Preparar query statement
        $stmt = $this->conn->prepare($query);

        // Executar query
        $stmt->execute();

        // Devolver PDOStatement
        return $stmt;
    }

    /**
     * Método para criar registo na Base de Dados
     * @return Boolean Devolve true quando insere na Base de Dados
     */
    function createO() {
        // Query de inserção
        $query = "INSERT INTO
                Orders
            SET
                username=:username, total=:total,
                state=:state";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        // Filtrar valores
        $this->username = filter_var($this->username,FILTER_SANITIZE_STRING);
        $this->total = filter_var($this->total, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $this->state = filter_var($this->state, FILTER_SANITIZE_STRING);
  

        // Associar valores
        $stmt->bindValue(":username", $this->username);
        $stmt->bindValue(":total", $this->total);
        $stmt->bindValue(":state", $this->state);
    
        // Executar query
        if ($stmt->execute()) {
            return true;
        }
          return false;
        
    }

    /**
     * Método para obter um registo da Base de Dados
     * @return None
     */
    function readOneO() {
        // Query SQL para ler apenas um registo
        
        $query = "SELECT
                order_id, username, state,  total
            FROM
                Orders
            WHERE
                order_id = :ID
            LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->order_id = $this->order_id;
        $stmt->bindValue(':ID', $this->order_id);

        // Executar query
        $stmt->execute();

        // Obter dados do registo e instanciar o objeto
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->username = $row['username'];
        $this->total = $row['total'];
        $this->state = $row['state'];
        
    }


/**
     * Método para atualizar um registo na Base de Dados
     * @return Boolean Devolve true quando atualiza na Base de Dados
     */
    function updateO() {

        // update query
        $query = "UPDATE
                Orders
            SET
                username = :username,               
                state = :state, 
                total = :total
            WHERE
                order_id = :ID";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        // Filtrar valores
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $this->total = filter_var($this->total, FILTER_SANITIZE_NUMBER_FLOAT);
        $this->state = filter_var($this->state, FILTER_SANITIZE_STRING);
        $this->order_id = filter_var($this->order_id, FILTER_SANITIZE_NUMBER_INT);
       

        // Associar valores
        $stmt->bindValue(":username", $this->username);
        $stmt->bindValue(":total", $this->total);
        $stmt->bindValue(":state", $this->state);
        $stmt->bindValue(":ID", $this->order_id);

        // Executar query
//        var_dump($stmt);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


     /**
     * Método para apagar um registo da Base de Dados
     * @return Boolean Devolve true quando remove da Base de Dados
     */
    function deleteO() {
        // Query SQL
        $query = "DELETE FROM " . 'Orders' . " WHERE order_id = :ID";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->order_id = filter_var($this->order_id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->order_id);

        // Executar query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
class User{

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Método para ler todos os elementos da tabela
     * @return PDOStatement Devolve PDOStatement com todos os elementos da tabela
     */
    function readu() {

        // Query SQL
        $query = "SELECT 
                username, email, id
            FROM
                User
            ";

        // Preparar query statement
        $stmt = $this->conn->prepare($query);

        // Executar query
        $stmt->execute();

        // Devolver PDOStatement
        return $stmt;
    }

     /**
     * Método para obter um registo da Base de Dados
     * @return None
     */
    function readOneU() {
        // Query SQL para ler apenas um registo
        
        $query = "SELECT
                username,email,id
            FROM
                User
            WHERE
                id = :ID
            LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->id);

        // Executar query
        $stmt->execute();

        // Obter dados do registo e instanciar o objeto
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->id = $row['id'];
 

    }

     /**
     * Método para apagar um registo da Base de Dados
     * @return Boolean Devolve true quando remove da Base de Dados
     */
    function deleteU() {
        // Query SQL
        $query = "DELETE FROM " . 'User' . " WHERE id = :ID";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->id);

        // Executar query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
class Product {

    // Ligação à Base de Dados e nome da tabela
    private $conn;
    private $table_name = "Products";
    // Propriedades
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_name;
    public $created;
    public $pictures;

    /**
     * Método construtor que instancia a ligação à Base de Dados
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Método para ler todos os elementos da tabela
     * @return PDOStatement Devolve PDOStatement com todos os elementos da tabela
     */
    function read() {

        // Query SQL
        $query = "SELECT 
                p.category_name as category_name, p.id, p.name, p.description, p.price, p.discount_id,  p.created, p.modified, p.pictures
            FROM
                ".$this->table_name . " p
            
            ORDER BY
                p.created DESC";

        // Preparar query statement
        $stmt = $this->conn->prepare($query);

        // Executar query
        $stmt->execute();

        // Devolver PDOStatement
        return $stmt;
    }


    /**
     * Método para criar registo na Base de Dados
     * @return Boolean Devolve true quando insere na Base de Dados
     */
    function create() {
        // Query de inserção
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description,
                category_name=:category_name, discount_id=:discount_id, created=:created, pictures=:pictures";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        // Filtrar valores
        $this->name = filter_var($this->name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->price = (float) filter_var($this->price,FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $this->description = filter_var($this->description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->category_name = filter_var($this->category_name, FILTER_SANITIZE_STRING);
        $this->discount_id = filter_var($this->discount_id, FILTER_SANITIZE_NUMBER_INT);
        $this->created = filter_var($this->created, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->pictures = filter_var($this->pictures);

        // Associar valores
        $stmt->bindValue(":name", $this->name);
        $stmt->bindValue(":price", $this->price);
        $stmt->bindValue(":description", $this->description);
        $stmt->bindValue(":category_name", $this->category_name);
        $stmt->bindValue(":discount_id", $this->discount_id);
        $stmt->bindValue(":created", $this->created);
        $stmt->bindValue(":pictures", $this->pictures);

        // Executar query
        if ($stmt->execute()) {
            return true;
        }
          return false;
        
    }

    /**
     * Método para obter um registo da Base de Dados
     * @return None
     */
    function readOne() {
        // Query SQL para ler apenas um registo
        
        $query = "SELECT
                p.category_name as category_name, p.id, p.name, p.description, p.price,
                p.discount_id, p.created, p.modified, p.pictures
            FROM
                " . $this->table_name . " p
            WHERE
                p.id = :ID
            LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->id);

        // Executar query
        $stmt->execute();

        // Obter dados do registo e instanciar o objeto
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category_name = $row['category_name'];
        $this->created = $row['created'];
        $this->modified = $row['modified'];
        $this->discount_id = $row['discount_id'];
        $this->pictures = $row['pictures'];

    }

    /**
     * Método para atualizar um registo na Base de Dados
     * @return Boolean Devolve true quando atualiza na Base de Dados
     */
    function update() {

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_name = :category_name,
                discount_id = :discount_id,
                created = :created,
                modified = :modified,
                pictures = :pictures
            WHERE
                id = :ID";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        // Filtrar valores
        $this->name = filter_var($this->name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->price = (float) filter_var($this->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $this->description = filter_var($this->description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->category_name = filter_var($this->category_name, FILTER_SANITIZE_STRING);
        $this->discount_id = filter_var($this->discount_id, FILTER_SANITIZE_NUMBER_INT);
        $this->created = filter_var($this->created, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->modified = filter_var($this->modified, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $this->pictures = filter_var($this->pictures);

        // Associar valores
        $stmt->bindValue(":name", $this->name);
        $stmt->bindValue(":price", $this->price);
        $stmt->bindValue(":description", $this->description);
        $stmt->bindValue(":category_name", $this->category_name);
        $stmt->bindValue(":discount_id", $this->discount_id);
        $stmt->bindValue(":created", $this->created);
        $stmt->bindValue(":modified", $this->modified);
        $stmt->bindValue(":pictures", $this->pictures);
        $stmt->bindValue(":ID", $this->id);

        // Executar query
//        var_dump($stmt);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Método para apagar um registo da Base de Dados
     * @return Boolean Devolve true quando remove da Base de Dados
     */
    function delete() {
        // Query SQL
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :ID";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->id);

        // Executar query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    // search products
    function search($keywords) {

        // select all query
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created, p.modified
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY
                p.created DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords = filter_var($keywords, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $keywords = "%{$keywords}%";

        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read products with pagination
    public function readPaging($from_record_num, $records_per_page) {

        // select query
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values from database
        return $stmt;
    }

    // used for paging products
    public function count() {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

}
