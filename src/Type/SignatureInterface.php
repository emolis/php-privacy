<?php declare(strict_types=1);
/**
 * This file is part of the PHP PG library.
 *
 * © Nguyen Van Nguyen <nguyennv1981@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Type;

use DateTime;

/**
 * Signature interface
 * 
 * @package   OpenPGP
 * @category  Type
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
interface SignatureInterface extends ArmorableInterface, PacketContainerInterface
{
    /**
     * Returns signature packets
     *
     * @return array
     */
    function getSignaturePackets(): array;

    /**
     * Returns signing key IDs
     *
     * @param bool $toHex
     * @return array
     */
    function getSigningKeyIDs(bool $toHex = false): array;

    /**
     * Verify signature with literal data
     * Return verification array
     *
     * @param array $verificationKeys
     * @param LiteralDataInterface $literalData
     * @param DateTime $time
     * @return array
     */
    function verify(
        array $verificationKeys,
        LiteralDataInterface $literalData,
        ?DateTime $time = null
    ): array;

    /**
     * Verify signature with cleartext
     * Return verification array
     *
     * @param array $verificationKeys
     * @param CleartextMessageInterface $cleartext
     * @param DateTime $time
     * @return array
     */
    function verifyCleartext(
        array $verificationKeys,
        CleartextMessageInterface $cleartext,
        ?DateTime $time = null
    ): array;
}
