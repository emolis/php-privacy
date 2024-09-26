<?php declare(strict_types=1);

require_once dirname(__DIR__) . "/vendor/autoload.php";

use OpenPGP\OpenPGP;

$passphase = "8pM1b;)|5;lD7/SM51o>p1Vp%F}u=AO7";

$keyData = <<<EOT
-----BEGIN PGP PRIVATE KEY BLOCK-----
Version: PHP Privacy v2
Comment: https://github.com/web-of-trust/php-privacy

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
JufkRd7zuLxBKQIPpDhrZEeGvClv
=B8qK
-----END PGP PRIVATE KEY BLOCK-----
EOT;
$rsaPrivateKey = OpenPGP::decryptPrivateKey($keyData, $passphase);

$keyData = <<<EOT
-----BEGIN PGP PRIVATE KEY BLOCK-----
Version: PHP Privacy v2
Comment: https://github.com/web-of-trust/php-privacy

xcBIBGbzgU4TBSuBBAAjBCMEAGIhXtcV0Xo0x84qunT4ndhgrlKZcXgXYB9dhoPpci/XSsAU2Y6Y
BXOtXZvtj82Ht1GNHa5QgYO85y556aue6rK3AWUkCOZoKvjQ1kNJZwqW7iaXaj1N/cfFn1WQf4+4
1/VGhGk9DZYLgjP4+qoueOvh4amSA0BxdeXUn48lpkz3pDaD/gcDCKVeda8lbRug4CIojtl/xX/F
quYyDLpETGfH0R6ChYEGXbhO7D8JFmliEtnHiWQXm3YS6cxLRqU+SeZ5OUeUCM6bcUbuKtNfR05W
/CAWG+HcQlN9H4bLni66wpPJq2v0rB3BoLo0B8FLGlyrJjMTV5dbzSpOZ3V5ZW4gVmFuIE5ndXll
biA8bmd1eWVubnYxOTgxQGdtYWlsLmNvbT7CwDgEEBMKAGcFAmbzgU4WIQSD6DIwfTk50CHc8qK6
ngqnSMkpzwkQup4Kp0jJKc8CGQE8FAAAAAAAEwAgc2FsdEB3ZWJvZnRydXN0Lm9yZzA4+yJiUZc7
29+BKN8fvsW3GxUlLYNJs0BIz5GjylVLAACwkgII00MsI2571U+ehyJVGJa45YLjsm9IYHJ/FQ/z
LzX76N+eYwmCAnEv282H+THUROP9MOKOYim+MmwbhXcoHnpFPbcCCQFtN55twaj2lIXMhHrUEgKb
numaRWOIRtVM6o56WHU64EeHkRybeAB5GLcVIoJ6C+p3wHuitcMm0Pco2yo6zkrPPs0sTmd1eWVu
IFZhbiBOZ3V5ZW4gPG5ndXllbm52QGl3YXl2aWV0bmFtLmNvbT7CwDUEEBMKAGQFAmbzgU4WIQSD
6DIwfTk50CHc8qK6ngqnSMkpzwkQup4Kp0jJKc88FAAAAAAAEwAgc2FsdEB3ZWJvZnRydXN0Lm9y
ZySIIyp6oeszYilCAQwdChVekXXbHe/dZokPrspS61CDAAB/GgIHbomkBPg4iTdzrmj2lVDLA51N
2sHGCQftbSgqvouyQd6fNOI1xuZXHkEJ8apAqACoPohxwWgmgL2NbfHkbU/jxXkCCQEnmnbo7IGq
NH0KPvIltCoh95kBVyE8nHKgdinRWznMZcyd2ejtAfQ9288/c3nq4pzMWkHqYLmu3MU19jiiScyr
dsfASwRm84FOEgUrgQQAIwQjBAB9absUVmtAo0ss7jsD2yjfVm/IWYA4Y1uTuAZT7fs0ySDe6QDH
d801vADFg5JjwdpdNBDuxb4ygXAC9tjFCAgLNAFcxU78aGu4R5Ft6zMRQqZLqAi1OZrb1Y92zzDB
INlgCZM/sUQAZGQW2XfW6HinCnl53FsV8zJuGjNeuYzH+NxAaQMACgn+BwMI2UR0zjh0xpTgwVA5
Ga8JTswAj158X/uhCxZaCnX2b2hZw1N34RMqm/ECZxNRCjDB4npSywiDibcmXjHWm5pTf/KBF9ME
bfVusQnp4LWUuG+1FhIKOFQDGNvdR7B0E++7k6yZr+AV09pkSFGnBKdiaMLAOQQYEwoAZwUCZvOB
ThYhBIPoMjB9OTnQIdzyorqeCqdIySnPCRC6ngqnSMkpzwIbDDwUAAAAAAATACBzYWx0QHdlYm9m
dHJ1c3Qub3Jn2faeyqSTJzwKaaVMli8w27FvgzAjc3557HTBqhms5E4AAHqoAgkB1df9SL5XlNfY
QdlLqnKilGjTsezV1oHwCETQfrS0J4OQjFWU2HjW/8ZCi9T2K/aLIGFUweXR7Rs4D//ipI5dHL8C
CQGuZEOaUiVUrykzCiGTJ8g+/RsZnmOSkAafZyFQfTWYnURRJ+xs0HWqVOQsDnuo94+sS9tEgzpi
ZgPDYnRLXCjPFA==
=42yk
-----END PGP PRIVATE KEY BLOCK-----
EOT;
$eccPrivateKey = OpenPGP::decryptPrivateKey($keyData, $passphase);

$keyData = <<<EOT
-----BEGIN PGP PRIVATE KEY BLOCK-----
Version: PHP Privacy v2
Comment: https://github.com/web-of-trust/php-privacy

xX0GZvOBThsAAAAgNgTM0VxUPpT+EPeltZCRrLVp4PQtdVLqmrEbln7nqkX+HQcLAwgpPq31t9Lk
AOBxvjCfxzD7nRJShX2aDSjNwsQ9xcUoUQ4Xtho0KFR3KD6xWW/Ud0y/PStRBLeqoPjyf8LVfwiq
1Vml/TdgJzUr+sN18MK7Bh8bCAAAAFwFAmbzgU8iIQbGAUcpguX+iT2VYGIph9cSTS2PhUnmMW5E
v5Mpgkkl1AkQxgFHKYLl/okCGwMDCwcJBCIBAgMFFQgMCg4FFgABAgMCHgsNJwcBCQEHAgkCBwMJ
AwAAAACFOxDChoaac0Z6OStT5W8DATB3qi9uy8j34X1P1BI1AL/hV1+a1rXZhoe75V+xUsnSiX1c
ve+sqiBVCTRf/ipqhKRpmpmXZGaAXeRkoLTCYzXDBs0qTmd1eWVuIFZhbiBOZ3V5ZW4gPG5ndXll
bm52MTk4MUBnbWFpbC5jb20+wr4GEBsIAAAAXwUCZvOBTyIhBsYBRymC5f6JPZVgYimH1xJNLY+F
SeYxbkS/kymCSSXUCRDGAUcpguX+iQIbAwMLBwkEIgECAwUVCAwKDgUWAAECAwIeCw0nBwEJAQcC
CQIHAwkDAhkBAAAAAI19EJiIsqw962c/t8OSfzgWhuV5CXcBAauNrjSEbKRWgL1raLgC7NJNo4HZ
N8bkiiAQYPH2vmHN1h/sA56/ue8HtckXGzyAvWZpRAzQJwGcMT8DzSxOZ3V5ZW4gVmFuIE5ndXll
biA8bmd1eWVubnZAaXdheXZpZXRuYW0uY29tPsK7BhAbCAAAAFwFAmbzgU8iIQbGAUcpguX+iT2V
YGIph9cSTS2PhUnmMW5Ev5Mpgkkl1AkQxgFHKYLl/okCGwMDCwcJBCIBAgMFFQgMCg4FFgABAgMC
HgsNJwcBCQEHAgkCBwMJAwAAAACqCRC+ziQUMGwHLS6z7NphB+Odc5qUKBrPPzUo+t1BsaqPsvo2
cfuqhqY8crbX7+Vjw9jgdyB2sEmQJNE2xdD9ZP7nI+75bcfVmv2qSTtu9SZfBMd9BmbzgU4ZAAAA
IBX6gFdXX115qhtVtF7BrgqiDPPTr0tmhp95fa1ULk4w/h0HCwMIicK0zjrbJKHgaVqj5JU5kjz/
v5GhQ/vr7rA3niwCxv8kJJYU/Uv1bJm/2t+Ttz9U/Krp4UdiHuIgjTNPhItboy5c5+gP9NLC0m7p
2PHClQYYGwgAAAA2BQJm84FPIiEGxgFHKYLl/ok9lWBiKYfXEk0tj4VJ5jFuRL+TKYJJJdQJEMYB
RymC5f6JAhsMAAAAAIzeEKdEOhcv059atWcnzJAxsMyjMZKwwBeQPNwB8rnwKt1sd/zIlF5QWoXp
txnK0umqKGDv5XOmkieuVSSB1p+Ka4tg+0mUiHK4Q6eH8FGCrywO1R44TjFeZcQLtExinfj6VUu4
OWcHlS3cfS2V0+EdtxA=
=xBiu
-----END PGP PRIVATE KEY BLOCK-----
EOT;
$curve25519PrivateKey = OpenPGP::decryptPrivateKey($keyData, $passphase);

$keyData = <<<EOT
-----BEGIN PGP PRIVATE KEY BLOCK-----
Version: PHP Privacy v2
Comment: https://github.com/web-of-trust/php-privacy

xa8GZvOBTxwAAAA5bkWce7vfRJjxiLiP1G9EJH0Hp+0gKywFeY2/n+9z3FASQZ0aPiyudnXS3svo
XKXtCpibchwzb0CA/h0HCwMIb7Ms2LezV3fgJzYF+rs24aoAuyVsm+DI0+F+fI3Mdr6CfwP5JGv4
di7K2U9q4Rnh271nyP1MN+jpQZpyASUlDGuDpgj1zspXGbr5NoIqGCxbpRxKuG4ulDVPSvuQWJ0u
QIaZoB3hwsA9Bh8cCgAAAFwFAmbzgU8iIQYtpPSc0CINkfClsDFVJIb05nIBEnMO6DToSGNi6aZm
KgkQLaT0nNAiDZECGwMDCwcJBCIBAgMFFQgMCg4FFgABAgMCHgsNJwcBCQEHAgkCBwMJAwAAAACa
ryBhqHtsC4uvHoa3DRdxrHCUeaxRY2L/o2BWQHe1g5d/C5dyg1DwWotKMaEUJGFMa/pqv4LR665m
WVMujOG2sgj6/jEz82mr5EThouLiuFWH4emBUPuTT3soAO+GKEoaQ56kIx8ClHtXY8jDJzo1obn2
Po8F2F/yRD9toFv6AtlxsRlDRtzI8tTMVLzngpcU3QQmAM0qTmd1eWVuIFZhbiBOZ3V5ZW4gPG5n
dXllbm52MTk4MUBnbWFpbC5jb20+wsBABhAcCgAAAF8FAmbzgU8iIQYtpPSc0CINkfClsDFVJIb0
5nIBEnMO6DToSGNi6aZmKgkQLaT0nNAiDZECGwMDCwcJBCIBAgMFFQgMCg4FFgABAgMCHgsNJwcB
CQEHAgkCBwMJAwIZAQAAAABizSCNS3oMSD7ez+bWrjnV6mVRS6vFMu/wmXgAr+rrckW4boBQmvem
fTYKNOSVKFMFQ5ntTwvBZATkx+hoHaxP7iJb7gp/TY52lBUykpZlXeSwjuJOxxouRuQZAP3Eb7PV
sAVgb6FMSz+7DWSncEiV7ZvwpE8R3LLkTjEQvFzCwX7KzE+NRUAxNeA0a89NgcbE4Ls6AM0sTmd1
eWVuIFZhbiBOZ3V5ZW4gPG5ndXllbm52QGl3YXl2aWV0bmFtLmNvbT7CwD0GEBwKAAAAXAUCZvOB
UCIhBi2k9JzQIg2R8KWwMVUkhvTmcgEScw7oNOhIY2LppmYqCRAtpPSc0CINkQIbAwMLBwkEIgEC
AwUVCAwKDgUWAAECAwIeCw0nBwEJAQcCCQIHAwkDAAAAAFZZIJJUkYWbWUai+HPoXBAyLc7yIntF
8M/U4I2Z5qhy61pbWR94zuHjp1TcAxqrYfyv5t2ZV04tj39+3AHtq3A1vVfpEkz0fjBFNqvtbLeE
N0xcaPMUe0/RnkYADNhadd/AvRje+yUPT8zMgiFs2T798ub9/nY5jpXojCwPXK0qUB3bn0i54Z0p
vsCquFeMPdtM7CUAx60GZvOBTxoAAAA4Kvgk6QWiaGCcNIxprmUqQGyjwjYp2sstXDJrckYp8W9F
FKSNg+Gn/SHSdEIXvxyTTIVmQu++dKH+HQcLAwiJ2X7nt0zt9eBKxqW06VG8Blc9tZoMzZHsHSOs
Y6GyaatQzElsOlDjiVl15dDkfNjqa5jcJgRvtEsj7b9SQDhWOvuoHrVIMp+vFGtLlpu9ZalU9lZE
zFdNpdFiT46vE3n6SV9YkcLAFwYYHAoAAAA2BQJm84FQIiEGLaT0nNAiDZHwpbAxVSSG9OZyARJz
Dug06EhjYummZioJEC2k9JzQIg2RAhsMAAAAAFkzIFSCJ/3L5byAbTmIPTNDm0QZBjoQoCU0g1KN
EAvbtCG83QTWGUQlczJsOpZWMo2IJRRDu+0K1BYyM2qhMXqPds2VDk9ppzyRZQLxpK3Wgu/8g41f
/vcRMaWAxgm8uPbQUL5STXqCLwCS1oS0Ioa8y4Mf+eKlPwNVN7VHz9A5VV6QZE1wB5E4G2f/n5Zv
df0zvgUA1R2LL5cFCeqL+v/SEmEuQm3skaPHAPtOusu/60UhyA==
=aLGb
-----END PGP PRIVATE KEY BLOCK-----
EOT;
$curve448PrivateKey = OpenPGP::decryptPrivateKey($keyData, $passphase);

echo "Sign cleartext message:" . PHP_EOL . PHP_EOL;
$text = <<<EOT
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc felis neque, interdum id iaculis ut, faucibus a ex.
Nam quam tortor, pharetra at dignissim ut, semper nec arcu. Vivamus mollis tortor vitae urna fringilla lacinia id
vel nunc. Ut laoreet pellentesque mattis. Curabitur viverra enim venenatis, mattis velit sed, fringilla lacus. Donec
nulla dui, vestibulum aliquam ultrices hendrerit, euismod iaculis magna. Praesent vitae ipsum id risus feugiat
auctor ac eget tellus.

What we need from the grocery store:
- tofu
- vegetables
- noodles
EOT;
$signedMessage = OpenPGP::signCleartext($text, [
    $rsaPrivateKey,
    $eccPrivateKey,
    $curve25519PrivateKey,
    $curve448PrivateKey,
]);
echo $armored = $signedMessage->armor() . PHP_EOL;

echo "Verify signed message:" . PHP_EOL . PHP_EOL;
$verifications = OpenPGP::verify($armored, [
    $rsaPrivateKey->toPublic(),
    $eccPrivateKey->toPublic(),
    $curve25519PrivateKey->toPublic(),
    $curve448PrivateKey->toPublic(),
]);
foreach ($verifications as $verification) {
    echo "Key ID: {$verification->getKeyID(true)}" . PHP_EOL;
    echo "Signature is verified: {$verification->isVerified()}" . PHP_EOL;
    echo "Verification error: {$verification->getVerificationError()}" .
        PHP_EOL .
        PHP_EOL;
}

echo "Sign detached cleartext message:" . PHP_EOL . PHP_EOL;
$signature = OpenPGP::signDetachedCleartext($text, [
    $rsaPrivateKey,
    $eccPrivateKey,
    $curve25519PrivateKey,
    $curve448PrivateKey,
]);
echo $armored = $signature->armor() . PHP_EOL;

echo "Verify detached signature:" . PHP_EOL . PHP_EOL;
$verifications = OpenPGP::verifyDetached($text, $armored, [
    $rsaPrivateKey->toPublic(),
    $eccPrivateKey->toPublic(),
    $curve25519PrivateKey->toPublic(),
    $curve448PrivateKey->toPublic(),
]);
foreach ($verifications as $verification) {
    echo "Key ID: {$verification->getKeyID(true)}" . PHP_EOL;
    echo "Signature is verified: {$verification->isVerified()}" . PHP_EOL;
    echo "Verification error: {$verification->getVerificationError()}" .
        PHP_EOL .
        PHP_EOL;
}
