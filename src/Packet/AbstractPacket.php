<?php declare(strict_types=1);
/**
 * This file is part of the PHP Privacy project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Packet;

use OpenPGP\Enum\{
    HashAlgorithm,
    PacketTag,
    SymmetricAlgorithm,
};
use OpenPGP\Common\Config;
use OpenPGP\Type\PacketInterface;
use Psr\Log\{
    LoggerAwareInterface,
    LoggerAwareTrait,
    LoggerInterface,
};

/**
 * Abstract packet class
 * 
 * @package  OpenPGP
 * @category Packet
 * @author   Nguyen Van Nguyen - nguyennv1981@gmail.com
 */
abstract class AbstractPacket implements LoggerAwareInterface, PacketInterface, \Stringable
{
    use LoggerAwareTrait;

    /**
     * Packet tag support partial body length
     */
    const PARTIAL_SUPPORTING = [
        PacketTag::AeadEncryptedData,
        PacketTag::CompressedData,
        PacketTag::LiteralData,
        PacketTag::SymEncryptedData,
        PacketTag::SymEncryptedIntegrityProtectedData,
    ];

    const PARTIAL_CHUNK_SIZE = 1024;
    const PARTIAL_MIN_SIZE   = 512;

    /**
     * Constructor
     *
     * @param PacketTag $tag
     * @return self
     */
    protected function __construct(private readonly PacketTag $tag)
    {
        $this->setLogger(Config::getLogger());
    }

    /**
     * {@inheritdoc}
     */
    public function getTag(): PacketTag
    {
        return $this->tag;
    }

    /**
     * {@inheritdoc}
     */
    public function encode(): string
    {
        if (in_array($this->tag, self::PARTIAL_SUPPORTING, true)) {
            return $this->partialEncode();
        }
        else {
            $bytes = $this->toBytes();
            return implode([
                chr(0xc0 | $this->tag->value),
                self::bodyLength(strlen($bytes)),
                $bytes,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger ?? Config::getLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->encode();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function toBytes(): string;

    /**
     * Validate hash algorithm
     *
     * @param HashAlgorithm $hash
     * @return void
     */
    protected static function validateHash(HashAlgorithm $hash): void
    {
        switch ($hash) {
            case HashAlgorithm::Unknown:
            case HashAlgorithm::Md5:
            case HashAlgorithm::Sha1:
            case HashAlgorithm::Ripemd160:
                throw new \UnexpectedValueException(
                    "Hash {$hash->name} is unsupported.",
                );
                break;
        }
    }

    /**
     * Validate symmetric algorithm
     *
     * @param HashAlgorithm $symmetric
     * @return void
     */
    protected static function validateSymmetric(SymmetricAlgorithm $symmetric): void
    {
        switch ($symmetric) {
            case SymmetricAlgorithm::Plaintext:
            case SymmetricAlgorithm::Idea:
            case SymmetricAlgorithm::TripleDes:
            case SymmetricAlgorithm::Cast5:
                throw new \UnexpectedValueException(
                    "Symmetric {$symmetric->name} is unsupported.",
                );
                break;
        }
    }

    /**
     * Encode package to the openpgp partial body specifier
     *
     * @return string
     */
    private function partialEncode(): string
    {
        $buffer = '';
        $partialData = [];
        $chunks = str_split($this->toBytes(), self::PARTIAL_CHUNK_SIZE);
        foreach ($chunks as $chunk) {
            $buffer .= $chunk;
            $bufferLength = strlen($buffer);
            if ($bufferLength >= self::PARTIAL_MIN_SIZE) {
                $powerOf2 = min(log($bufferLength) / M_LN2 | 0, 30);
                $chunkSize = 1 << $powerOf2;
                $partialData[] = implode([
                    self::partialBodyLength($powerOf2),
                    substr($buffer, 0, $chunkSize),
                ]);
                $buffer = substr($buffer, $chunkSize);
            }
        }
        if (!empty($buffer)) {
            $partialData[] = implode([
                self::bodyLength(strlen($buffer)),
                $buffer,
            ]);
        }

        return implode([
            chr(0xc0 | $this->tag->value),
            ...$partialData,
        ]);
    }

    /**
     * Encode a given integer of length to the openpgp body length specifier
     *
     * @param int $length
     * @return string
     */
    private static function bodyLength(int $length): string
    {
        if ($length < 192) {
            return chr($length);
        }
        elseif ($length > 191 && $length < 8384) {
            return implode([
              chr(((($length - 192) >> 8) & 0xff) + 192),
              chr(($length - 192) & 0xff),
            ]);
        }
        else {
            return implode(["\xff", pack('N', $length)]);
        }
    }

    /**
     * Encode a given integer of length power to the openpgp partial body length specifier
     *
     * @param int $power
     * @return string
     */
    private static function partialBodyLength(int $power): string
    {
        if ($power < 0 || $power > 30) {
            throw new \UnexpectedValueException(
                'Partial length power must be between 1 and 30'
            );
        }
        return chr(224 + $power);
    }
}
