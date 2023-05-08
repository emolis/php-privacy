<?php declare(strict_types=1);
/**
 * This file is part of the PHP PG library.
 *
 * © Nguyen Van Nguyen <nguyennv1981@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenPGP\Packet;

/**
 * Signature sub-packet class
 * 
 * @package   OpenPGP
 * @category  Packet
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
class SignatureSubpacket implements SubpacketInterface
{
    /**
     * Constructor
     *
     * @param int $type
     * @param string $data
     * @param bool $critical
     * @param bool $isLong
     * @return self
     */
    public function __construct(
        private int $type,
        private string $data,
        private bool $critical = false,
        private bool $isLong = false
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function isLong(): bool
    {
        return $this->isLong;
    }

    /**
     * Returns is critical
     * 
     * @return bool
     */
    public function isCritical(): bool
    {
        return $this->critical;
    }

    /**
     * {@inheritdoc}
     */
    public function encode(): string
    {
        $header = '';
        $bodyLen = strlen($this->data) + 1;
        if ($this->isLong) {
            $header = implode([chr(0xff), pack('N', $bodyLen)]);
        }
        else {
            if ($bodyLen < 192) {
                $header = chr($bodyLen);
            } else if ($bodyLen <= 8383) {
                $header = implode([
                    chr(((($bodyLen - 192) >> 8) & 0xff) + 192),
                    chr($bodyLen - 192),
                ]);
            } else {
                $header = implode([chr(0xff), pack('N', $bodyLen)]);
          }
        }
        
        return implode([
            $header,
            $this->critical ? chr($this->type | 0x80) : chr($this->type),
            $this->data,
        ]);
    }
}