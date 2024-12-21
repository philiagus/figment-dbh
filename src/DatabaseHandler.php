<?php
/*
 * This file is part of philiagus/figment-dbh
 *
 * (c) Andreas Eicher <philiagus@philiagus.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Philiagus\Figment\DBH;

use Philiagus\Figment\Container\Attribute\Inject;
use Philiagus\PDOStatementBuilder\Statement;

readonly class DatabaseHandler implements Contract\DatabaseHandler
{

    public function __construct(
        #[Inject('figment.dbh.pdo')]
        public \PDO $pdo
    )
    {
    }

    public function query(string|Statement $statement): Contract\QueryResult
    {
        if($statement instanceof Statement) {
            $pdoStatement = $statement->prepare($this->pdo);
        } else {
            $pdoStatement = $this->pdo->prepare($statement);
        }

        $pdoStatement->execute();
        return new QueryResult($pdoStatement);
    }

    public function execute(string|Statement $statement): Contract\ExecuteResult
    {
        if($statement instanceof Statement) {
            $pdoStatement = $statement->prepare($this->pdo);
        } else {
            $pdoStatement = $this->pdo->prepare($statement);
        }
        $pdoStatement->execute();
        return new ExecuteResult($pdoStatement);
    }
}
