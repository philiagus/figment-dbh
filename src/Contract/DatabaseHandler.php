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

namespace Philiagus\Figment\DBH\Contract;

use Philiagus\Figment\DBH\FetchMode;
use Philiagus\PDOStatementBuilder\Statement;

interface DatabaseHandler {

    public function execute(string|Statement $statement): ExecuteResult;

    public function query(string|Statement $statement): QueryResult;


}
