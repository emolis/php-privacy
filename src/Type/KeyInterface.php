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

use OpenPGP\Packet\KeyPacketInterface;

/**
 * Key interface
 * 
 * @package   OpenPGP
 * @category  Type
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
interface KeyInterface extends ArmorableInterface
{
    /**
     * Returns key packet
     *
     * @return KeyPacketInterface
     */
    function getKeyPacket(): KeyPacketInterface;

    /**
     * Returns key as public key
     *
     * @return KeyInterface
     */
    function toPublic(): KeyInterface;

    /**
     * Is signing key
     *
     * @return bool
     */
    function isSigningKey(): bool;

    /**
     * Is encryption key
     *
     * @return bool
     */
    function isEncryptionKey(): bool;

    /**
     * Is revoked key
     *
     * @return bool
     */
    function isRevoked(): bool;
}
