<?php declare(strict_types=1);
/**
 * This file is part of the PHP PG library.
 *
 * © Nguyen Van Nguyen <nguyennv1981@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Enum;

/**
 * S2kType enum
 *
 * @package    OpenPGP
 * @category   Enum
 * @author     Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright  Copyright © 2023-present by Nguyen Van Nguyen.
 */
enum S2kType: int
{
    case Simple = 0;

    case Salted = 1;

    case Iterated = 2;

    case GNU = 101;

    public function packetLength(): int
    {
        return match($this) {
            S2kType::Simple => 2,
            S2kType::Salted => 10,
            S2kType::Iterated => 11,
            S2kType::GNU => 6,
        };
    }
}
