<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple;

use JsonException;
use Raxos\Foundation\Error\TemporaryFileFailedException;
use Raxos\Foundation\Util\FileSystemUtil;
use Raxos\Http\HttpHeader;
use Raxos\Http\HttpResponse;
use Raxos\Wallet\{Archive, WalletHelper};
use Raxos\Wallet\Apple\Component\Pass;
use function file_get_contents;
use function file_put_contents;
use function json_encode;
use function openssl_pkcs7_sign;
use function realpath;
use function sha1;
use function sha1_file;
use function sprintf;
use function unlink;
use const JSON_THROW_ON_ERROR;
use const PKCS7_BINARY;
use const PKCS7_DETACHED;

/**
 * Class PKPass
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple
 * @since 2.0.0
 */
final class PKPass
{

    private Archive $archive;
    private array $manifest = [];

    public string $fileName {
        get => "{$this->pass->serialNumber}.pkpass";
    }

    /**
     * PKPass constructor.
     *
     * @param Identity $identity
     * @param Pass $pass
     *
     * @throws JsonException
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public readonly Identity $identity,
        public readonly Pass $pass
    )
    {
        $this->archive = new Archive();
        $this->archive->open();

        $this->fileContents('pass.json', $this->passJson());
    }

    /**
     * Returns the binary data of the archive.
     *
     * @return string
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     * @see Archive::binary()
     */
    public function binary(): string
    {
        return $this->archive->binary();
    }

    /**
     * Close the archive.
     *
     * @return void
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     * @see Archive::close()
     */
    public function close(): void
    {
        $this->archive->close();
    }

    /**
     * Delete the archive.
     *
     * @return void
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     * @see Archive::delete()
     */
    public function delete(): void
    {
        $this->archive->delete();
    }

    /**
     * Add a file entry from the file system.
     *
     * @param string $fileName
     * @param string $localFileName
     *
     * @return void
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     * @see Archive::file()
     */
    public function file(string $fileName, string $localFileName): void
    {
        $this->archive->file($fileName, $localFileName);
        $this->manifest[$fileName] = sha1_file($localFileName);
    }

    /**
     * Add a file entry from contents.
     *
     * @param string $fileName
     * @param string $contents
     *
     * @return void
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     * @see Archive::fileContents()
     */
    public function fileContents(string $fileName, string $contents): void
    {
        $this->archive->fileContents($fileName, $contents);
        $this->manifest[$fileName] = sha1($contents);
    }

    /**
     * Respond as a binary response.
     *
     * @return HttpResponse
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     * @see Archive::respond()
     */
    public function respond(): HttpResponse
    {
        return $this->archive->respond()
            ->header(HttpHeader::CONTENT_DISPOSITION, sprintf('attachment; filename="%s"', $this->fileName))
            ->header(HttpHeader::CONTENT_TYPE, 'application/vnd.apple.pkpass');
    }

    /**
     * Signs the pass.
     *
     * @return void
     * @throws JsonException
     * @throws TemporaryFileFailedException
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function sign(): void
    {
        $manifestFile = FileSystemUtil::temporaryFile();
        $manifestJson = $this->json($this->manifest);

        $signatureFile = FileSystemUtil::temporaryFile();
        $wwdrFile = realpath(__DIR__ . '/../../wwdr.pem');

        file_put_contents($manifestFile, $manifestJson);

        $signed = openssl_pkcs7_sign(
            $manifestFile,
            $signatureFile,
            $this->identity->certificate,
            [
                $this->identity->privateKey,
                $this->identity->password
            ],
            [],
            PKCS7_BINARY | PKCS7_DETACHED,
            $wwdrFile
        );

        if (!$signed) {
            @unlink($manifestFile);
            @unlink($signatureFile);

            throw new \RuntimeException('Failed to sign the PKPass.');
        }

        $signature = file_get_contents($signatureFile);
        $signature = WalletHelper::pemToDER($signature);

        $this->archive->fileContents('manifest.json', $manifestJson);
        $this->archive->fileContents('signature', $signature);

        @unlink($manifestFile);
        @unlink($signatureFile);
    }

    /**
     * Adds a .strings file.
     *
     * @param Strings $strings
     *
     * @return void
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function strings(Strings $strings): void
    {
        $this->fileContents("{$strings->language}.lproj/pass.strings", (string)$strings);
    }

    /**
     * Serializes data as JSON.
     *
     * @param mixed $data
     *
     * @return string
     * @throws JsonException
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    private function json(mixed $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    /**
     * Generates the pass.json contents.
     *
     * @return string
     * @throws JsonException
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    private function passJson(): string
    {
        $data = $this->pass->jsonSerialize();
        $data['passTypeIdentifier'] = $this->identity->passTypeIdentifier;
        $data['teamIdentifier'] = $this->identity->teamIdentifier;

        return $this->json($data);
    }

}
