<?php declare(strict_types=1);

namespace OpenPGP\Tests\Packet;

use OpenPGP\Enum\CompressionAlgorithm;
use OpenPGP\Packet\CompressedData;
use OpenPGP\Packet\LiteralData;
use OpenPGP\Packet\PacketList;
use OpenPGP\Tests\OpenPGPTestCase;

/**
 * Testcase class for compression packet.
 */
class CompressionTest extends OpenPGPTestCase
{
    public function testZip()
    {
        $literalData = LiteralData::fromText($this->faker->sentence(100));
        $packets = new PacketList([$literalData]);
        $compressed = CompressedData::fromPacketList(
            $packets, CompressionAlgorithm::Zip
        );
        $this->assertSame($packets, $compressed->getPackets());

        $decompressed = CompressedData::fromBytes($compressed->toBytes());
        $this->assertSame(CompressionAlgorithm::Zip, $decompressed->getAlgorithm());
        $this->assertEquals($packets, $decompressed->getPackets());
    }

    public function testZlib()
    {
        $literalData = LiteralData::fromText($this->faker->sentence(100));
        $packets = new PacketList([$literalData]);
        $compressed = CompressedData::fromPacketList(
            $packets, CompressionAlgorithm::Zlib
        );
        $this->assertSame($packets, $compressed->getPackets());

        $decompressed = CompressedData::fromBytes($compressed->toBytes());
        $this->assertSame(CompressionAlgorithm::Zlib, $decompressed->getAlgorithm());
        $this->assertEquals($packets, $decompressed->getPackets());
    }

    public function testBZip2()
    {
        $literalData = LiteralData::fromText($this->faker->sentence(100));
        $packets = new PacketList([$literalData]);
        $compressed = CompressedData::fromPacketList(
            $packets, CompressionAlgorithm::BZip2
        );
        $this->assertSame($packets, $compressed->getPackets());

        $decompressed = CompressedData::fromBytes($compressed->toBytes());
        $this->assertSame(CompressionAlgorithm::BZip2, $decompressed->getAlgorithm());
        $this->assertEquals($packets, $decompressed->getPackets());
    }

    public function testZipDecompress()
    {
        $data = <<<EOT
jA0ECQMCRq12Ney7cav/0kIBVtvCp7e/6bftnl80wIN/ocPyTIoNgZUzAucL8Yxa
bZ7L0eBy4u8hgAVtrJCtETOLYeFMS51S/7ErdqyksWx9osw=
EOT;

        $packets = PacketList::decode(base64_decode($data));
        $skesk = $packets->getIterator()[0]->decrypt('password');
        $sessionKey = $skesk->getSessionKey();
        $seip = $packets->getIterator()[1]->decrypt(
            $sessionKey->getEncryptionKey(),
            $sessionKey->getSymmetric(),
        );

        $compressed = $seip->getPackets()->getIterator()[0];
        $this->assertSame(CompressionAlgorithm::Zip, $compressed->getAlgorithm());
        $literalData = $compressed->getPackets()->getIterator()[0];
        $this->assertSame('Hello PHP PG', trim($literalData->getData()));
    }

    public function testZlibDecompress()
    {
        $data = <<<EOT
jA0ECQMCLRbDkykeeZn/0kgBj3MScClX8/qZbP/HHT1XMXe8oc0FRSN8u6p+JbeC
cBZXWFgKE6GfHoK+8dlqnQYyPb9Xgh4MtFkw3OSFG9oO10Ggjuupq5Q=
EOT;

        $packets = PacketList::decode(base64_decode($data));
        $skesk = $packets->getIterator()[0]->decrypt('password');
        $sessionKey = $skesk->getSessionKey();
        $seip = $packets->getIterator()[1]->decrypt(
            $sessionKey->getEncryptionKey(),
            $sessionKey->getSymmetric(),
        );

        $compressed = $seip->getPackets()->getIterator()[0];
        $this->assertSame(CompressionAlgorithm::Zlib, $compressed->getAlgorithm());
        $literalData = $compressed->getPackets()->getIterator()[0];
        $this->assertSame('Hello PHP PG', trim($literalData->getData()));
    }

    public function testBZip2Decompress()
    {
        $data = <<<EOT
jA0ECQMCrf1YgAm7Evr/0m8BFPj2+nB5ipmTP0eWAAFxZCh4b7lTkE32a+nEABkg
kgYAl1ez6sJjNmyUYMzAWbfIEC0hoXioZKY6W/9KR7Ln0aK46/ZUGW3QKau7BwlY
64cgB5gvL4qH3TMmIaWMrJ+rr+zFD2RI+oakU2zAheg=
EOT;

        $packets = PacketList::decode(base64_decode($data));
        $skesk = $packets->getIterator()[0]->decrypt('password');
        $sessionKey = $skesk->getSessionKey();
        $seip = $packets->getIterator()[1]->decrypt(
            $sessionKey->getEncryptionKey(),
            $sessionKey->getSymmetric(),
        );

        $compressed = $seip->getPackets()->getIterator()[0];
        $this->assertSame(CompressionAlgorithm::BZip2, $compressed->getAlgorithm());
        $literalData = $compressed->getPackets()->getIterator()[0];
        $this->assertSame('Hello PHP PG', trim($literalData->getData()));
    }
}
