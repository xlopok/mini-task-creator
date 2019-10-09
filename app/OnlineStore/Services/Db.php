<?php

namespace App\OnlineStore\Services;

use App\OnlineStore\Exceptions\InvalidArgumentException;
use Aura\SqlQuery\QueryFactory;

use PDO;

class Db {

    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var QueryFactory
     */
    private $queryFactory;

    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $queryFactory;
    }


    public function getAll(string $table) {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table) ;

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());
        // bind the values and execute
        $sth->execute($select->getBindValues());
        // get the results back as an associative array
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function add($table, $data) {

        if (empty($data['title'])) {
            throw new InvalidArgumentException('Не передано название статьи');

        }

        if (empty($data['content'])) {
            throw new InvalidArgumentException('Не передан текст');
        }

        $insert =  $this->queryFactory->newInsert();
        $insert
            ->into($table)                   // INTO this table
            ->cols([                        // bind values as "(col) VALUES (:col)"
                'article_name',
                'article_text',
            ])
            ->bindValues([                  // bind these values
                'article_name' => $data['title'],
                'article_text' => $data['content'],
            ]);

            // prepare the statment
            $sth = $this->pdo->prepare($insert->getStatement());
            // bind the values and execute
            $sth->execute($insert->getBindValues());
//            // get the results back as an associative array
//            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
//            return $result;

    }

    public function delete($table, $id) {
        $delete = $this->queryFactory->newDelete();
        $delete
            ->from($table)                   // FROM this table
            ->where('id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);  // bind one value to a placeholder
        // prepare the statement
        $sth = $this->pdo->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues());

    }

    public function getById($table, $id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());
        // bind the values and execute
        $sth->execute($select->getBindValues());
        // get the results back as an associative array
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update($table, $id, $data)
    {
        if (empty($data['title'])) {
            throw new InvalidArgumentException('Не передано название статьи');

        }

        if (empty($data['content'])) {
            throw new InvalidArgumentException('Не передан текст');
        }

        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols([                        // bind values as "SET bar = :bar"
                'article_name',
                'article_text',
            ])
            ->where('id = :id')           // AND WHERE these conditions
            ->bindValues([                  // bind these values to the query
                'article_name' => $data['title'],
                'article_text' => $data['content'],
                'id' => $id,
            ]);

        // prepare the statement
        $sth = $this->pdo->prepare($update->getStatement());

        // execute with bound values
        $sth->execute($update->getBindValues());
    }
}