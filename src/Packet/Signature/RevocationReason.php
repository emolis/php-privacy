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

use OpenPGP\Enum\KeyAlgorithm;
use OpenPGP\Enum\RevocationReasonTag;
use OpenPGP\Enum\SignatureSubpacketType;
use OpenPGP\Packet\SignatureSubpacket;

/**
 * RevocationReason sub-packet class
 * Represents revocation reason OpenPGP signature sub packet.
 * 
 * @package   OpenPGP
 * @category  Packet
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
class RevocationReason extends SignatureSubpacket
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
            SignatureSubpacketType::RevocationReason->value,
            $data,
            $critical,
            $isLong
        );
    }

    /**
     * From revocation
     *
     * @param RevocationReasonTag $reason
     * @param string $description
     * @param bool $critical
     * @return RevocationReason
     */
    public static function fromRevocation(
        RevocationReasonTag $reason,
        string $description,
        bool $critical = false
    ): RevocationReason
    {
        return RevocationReason($this->revocationToBytes($reason, $description), $critical);
    }

    /**
     * Gets reason
     *
     * @return RevocationReasonTag
     */
    public function getReason(): RevocationReasonTag
    {
        return RevocationReasonTag::from(ord($this->data[0]));
    }

    /**
     * Gets description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return substr($this->data, 1);
    }

    private function revocationToBytes(
        RevocationReasonTag $reason,
        string $description
    )
    {
        return implode([
            chr($reason->value),
            $description,
        ])
    }
}