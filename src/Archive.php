<?php
declare(strict_types=1);

namespace Raxos\Wallet;

use Raxos\Foundation\Error\FileSystemException;
use Raxos\Foundation\Util\FileSystemUtil;
use Raxos\Http\HttpHeader;
use Raxos\Router\Response\{BinaryResponse, Response};
use ZipArchive;
use function file_get_contents;
use function gmdate;
use function unlink;

/**
 * Class Archive
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet
 * @since 2.0.0
 */
final readonly class Archive
{

    private ZipArchive $archive;
    public string $fileName;

    /**
     * Archive constructor.
     *
     * @throws FileSystemException
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct()
    {
        $this->archive = new ZipArchive();
        $this->fileName = FileSystemUtil::temporaryFile();
    }

    /**
     * Returns the binary data of the archive.
     *
     * @return string
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function binary(): string
    {
        return file_get_contents($this->fileName);
    }

    /**
     * Close the archive.
     *
     * @return void
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
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
     */
    public function delete(): void
    {
        @unlink($this->fileName);
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
     */
    public function file(string $fileName, string $localFileName): void
    {
        $this->archive->addFile($localFileName, $fileName);
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
     */
    public function fileContents(string $fileName, string $contents): void
    {
        $this->archive->addFromString($fileName, $contents);
    }

    /**
     * Open the archive for writing.
     *
     * @return void
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function open(): void
    {
        $this->archive->open($this->fileName, ZipArchive::OVERWRITE);
    }

    /**
     * Respond as a binary response.
     *
     * @return Response
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function respond(): Response
    {
        return new BinaryResponse($this->binary())
            ->withHeader(HttpHeader::CONTENT_TRANSFER_ENCODING, 'binary')
            ->withHeader(HttpHeader::CONNECTION, 'Keep-Alive')
            ->withHeader(HttpHeader::EXPIRES, '0')
            ->withHeader(HttpHeader::CACHE_CONTROL, 'must-revalidate, post-check=0, pre-check=0')
            ->withHeader(HttpHeader::LAST_MODIFIED, gmdate('D, d M Y H:i:s T'))
            ->withHeader(HttpHeader::PRAGMA, 'public');
    }

}
