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

use OpenPGP\Enum\PacketTag;

/**
 * UserID packet class
 * 
 * Implementation of the User ID packet (Tag 13)
 * A User ID packet consists of UTF-8 text that is intended to represent
 * the name and email address of the key holder.
 * By convention, it includes an RFC2822 mail name-addr,
 * but there are no restrictions on its content.
 * The packet length in the header specifies the length of the User ID.
 * 
 * @package   OpenPGP
 * @category  Packet
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2023-present by Nguyen Van Nguyen.
 */
class UserID extends AbstractPacket implements \Stringable
{
    private string $name = '';

    private string $email = '';

    private string $comment = '';

    /**
     * Constructor
     *
     * @param string $userID
     * @return self
     */
    public function __construct(private string $userID)
    {
        parent::__construct(PacketTag::UserID);

        // User IDs of the form: "name (comment) <email>"
        if (preg_match('/^([^\(]+)\(([^\)]+)\)\s+<([^>]+)>$/', $userID, $matches)) {
            $this->name    = trim($matches[1]);
            $this->email   = trim($matches[3]);
            $this->comment = trim($matches[2]);
        }
        // User IDs of the form: "name <email>"
        elseif (preg_match('/^([^<]+)\s+<([^>]+)>$/', $this->data, $matches)) {
            $this->name  = trim($matches[1]);
            $this->email = trim($matches[2]);
        }
        // User IDs of the form: "name"
        elseif (preg_match('/^([^<]+)$/', $this->data, $matches)) {
            $this->name = trim($matches[1]);
        }
        // User IDs of the form: "<email>"
        elseif (preg_match('/^<([^>]+)>$/', $this->data, $matches)) {
            $this->email = trim($matches[2]);
        }
    }

    /**
     * Reads user ID from byte string
     *
     * @param string $bytes
     * @return UserID
     */
    public static function fromBytes(string $bytes): UserID
    {
        return new UserID($bytes);
    }

    /**
     * {@inheritdoc}
     */
    public function toBytes(): string
    {
        return $this->userID;
    }

    /**
     * Gets bytes for sign
     *
     * @return string
     */
    public function signBytes(): string
    {
        return implode([
            "\xb4",
            pack('N', strlen($this->userID)),
            $this->userID,
        ]);
    }

    /**
     * Gets a string representation of the user ID
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->userID;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Gets comment
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}