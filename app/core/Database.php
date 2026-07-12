<?php

class Database
{
    // Đối tượng kết nối PDO
    private $dbh;

    // Đối tượng Statement
    private $stmt;

    /**
     * Constructor
     * Tự động kết nối CSDL khi tạo đối tượng Database
     */
    public function __construct()
    {
        $dsn = "mysql:host=" . DB_HOST .
               ";dbname=" . DB_NAME .
               ";charset=" . DB_CHARSET;

        try
        {
            $this->dbh = new PDO(
                $dsn,
                DB_USER,
                DB_PASS
            );

            // Báo Exception khi có lỗi SQL
            $this->dbh->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            // Mặc định trả về mảng kết hợp
            $this->dbh->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

        }
        catch(PDOException $e)
        {
            die("Lỗi kết nối CSDL : " . $e->getMessage());
        }
    }

    /**
     * Chuẩn bị câu SQL
     *
     * Ví dụ:
     * $this->db->query("SELECT * FROM Thuoc");
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind dữ liệu
     *
     * Ví dụ:
     * $this->db->bind(":id",5);
     */
    public function bind($param, $value, $type = null)
    {
        if ($type == null)
        {
            if (is_int($value))
            {
                $type = PDO::PARAM_INT;
            }
            elseif (is_bool($value))
            {
                $type = PDO::PARAM_BOOL;
            }
            elseif (is_null($value))
            {
                $type = PDO::PARAM_NULL;
            }
            else
            {
                $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue(
            $param,
            $value,
            $type
        );
    }

    /**
     * Thực thi SQL
     */
    public function execute()
    {
        $result = $this->stmt->execute();

        if (!$result)
        {
            echo "<pre>";
            print_r($this->stmt->errorInfo());
            exit();
        }

        return true;
    }

    /**
     * Lấy nhiều dòng dữ liệu
     *
     * return array
     */
    public function resultSet()
    {
        $this->execute();

        return $this->stmt->fetchAll();
    }

    /**
     * Lấy một dòng dữ liệu
     *
     * return array
     */
    public function single()
    {
        $this->execute();

        return $this->stmt->fetch();
    }

    /**
     * Đếm số dòng
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Lấy ID vừa INSERT
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     * Bắt đầu Transaction
     */
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    /**
     * Commit Transaction
     */
    public function commit()
    {
        return $this->dbh->commit();
    }

    /**
     * Rollback Transaction
     */
    public function rollback()
    {
        return $this->dbh->rollBack();
    }

    /**
     * Hiển thị thông tin câu SQL
     * Dùng khi Debug
     */
    public function debug()
    {
        $this->stmt->debugDumpParams();
    }

    /**
     * Đóng kết nối
     */
    public function close()
    {
        $this->stmt = null;
        $this->dbh = null;
    }
}