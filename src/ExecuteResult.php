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

class ExecuteResult implements Contract\ExecuteResult
{

    public int $numberOfAffectedRows {
        get {
            return $this->numberOfAffectedRows ??= $this->pdoStatement->rowCount();
        }
    }

    /**
     * @param \PDOStatement $pdoStatement
     */
    public function __construct(private readonly \PDOStatement $pdoStatement)
    {

    }


}
