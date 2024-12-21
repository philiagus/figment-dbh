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

enum FetchMode: int {
    case NUM = \PDO::FETCH_NUM;
    case ASSOC = \PDO::FETCH_ASSOC;
    case NUM_ASSOC = \PDO::FETCH_BOTH;
    case NAMED = \PDO::FETCH_NAMED;
}
