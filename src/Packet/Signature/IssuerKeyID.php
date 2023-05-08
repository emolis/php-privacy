<?php declare(strict_types=1);
/**
 * This file is part of the PHP PG library.
 *
 * © Nguyen Van Nguyen <nguyennv1981@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Packet\Signature;

use OpenPGP\Enum\SignatureSubpacketType;
use OpenPGP\Packet\SignatureSubpacket;

/**
 * IssuerKeyID sub-packet class
 * Giving the issuer key ID.
 * 
 * @package   OpenPGP
 * @category  Packet
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
class IssuerKeyID extends SignatureSubpacket
{
    /**
     * Constructor
     *
     * @param string $data
     * @param bool $critical
     * @param bool $isLong
     * @return self
     */
    public function __construct(
        string $data,
        bool $critical = false,
        bool $isLong = false
    )
    {
        parent::__construct(
            SignatureSubpacketType::IssuerKeyID->value,
            $data,
            $critical,
            $isLong
        );
    }

    /**
     * From key ID
     *
     * @param string $keyID
     * @param bool $critical
     * @return IssuerKeyID
     */
    public static function fromKeyID(
        string $keyID, bool $critical = false
    ): IssuerKeyID
    {
        return IssuerKeyID($keyID, $critical);
    }

    /**
     * From wildcard
     *
     * @param bool $critical
     * @return IssuerKeyID
     */
    public static function wildcard(
        bool $critical = false
    ): IssuerKeyID
    {
        return IssuerKeyID(str_repeat("\0", 8), $critical);
    }

    /**
     * Gets key ID
     * 
     * @return string
     */
    public function getKeyID(): string
    {
        return $this->data;
    }
}