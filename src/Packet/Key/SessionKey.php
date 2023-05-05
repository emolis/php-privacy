<?php declare(strict_types=1);
/**
 * This file is part of the PHP PG library.
 *
 * © Nguyen Van Nguyen <nguyennv1981@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Packet\Key;

use OpenPGP\Enum\SymmetricAlgorithm;

/**
 * Session key class
 * 
 * @package   OpenPGP
 * @category  Packet
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
class SessionKey
{
    /**
     * Constructor
     *
     * @param string $encryptionKey
     * @param SymmetricAlgorithm $symmetric
     * @return self
     */
    public function __construct(
        private string $encryptionKey,
        private SymmetricAlgorithm $symmetric = SymmetricAlgorithm::Aes256
    )
    {
    }

    /**
     * Reads session key from binary string
     *
     * @param string $bytes
     * @return SessionKey
     */
    public static function fromBytes(string $bytes): SessionKey
    {
        $sessionKey = new SessionKey(
            substr($bytes, 1, strlen($bytes) - 2),
            SymmetricAlgorithm::from(ord($bytes[0]))
        );

        $checksum = substr($bytes, strlen($bytes) - 2);
        $computedChecksum = $sessionKey->computeChecksum();
        if ($computedChecksum !== $checksum) {
            throw new \RuntimeException('Session key decryption error');
        }

        return $sessionKey;
    }

    /**
     * Gets encryption key
     *
     * @return string
     */
    public function getEncryptionKey(): string
    {
        return $this->encryptionKey;
    }

    /**
     * Get algorithm to encrypt the message with
     *
     * @return SymmetricAlgorithm
     */
    public function getSymmetric(): SymmetricAlgorithm
    {
        return $this->symmetric;
    }

    /**
     * Serializes session key to bytes
     * 
     * @return string
     */
    public function encode(): string
    {
        return implode([
            chr($this->symmetric->value),
            $this->encryptionKey,
        ]);
    }

    /**
     * Compute checksum
     * 
     * @return string
     */
    public function computeChecksum(): string
    {
        $sum = 0;
        $keyLen = strlen($this->encryptionKey)
        for ($i = 0; $i < $keyLen; $i++) {
          $sum = ($sum + ord($this->encryptionKey[$i])) & 0xffff;
        }
        return pack('n', $sum);
    }
}
