<?php

namespace App\OnlineStore\Models;

use App\OnlineStore\Services\Db;
use PDO;

class Articles {


    const TABLENAME = 'articles';
//    /**
//     * @var Db
//     */
//    private $db;
//
//    public function __construct(Db $db)
//    {
//        $this->db = $db;
//    }

    public function getAll() {
        $db = new Db();

        $result = $this->db->getAll(self::TABLENAME);

        return $result;
    }
}