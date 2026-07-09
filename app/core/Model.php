<?php

class Model
{
    /**
     * Đối tượng Database dùng chung
     */
    protected $db;

    /**
     * Constructor
     * Tự động khởi tạo Database
     */
    public function __construct()
    {
        $this->db = new Database();
    }
}