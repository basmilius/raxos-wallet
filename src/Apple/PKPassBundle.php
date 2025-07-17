<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple;

use Raxos\Http\HttpHeader;
use Raxos\Router\Response\Response;
use Raxos\Wallet\Archive;
use function sprintf;

/**
 * Class PKPassBundle
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple
 * @since 2.0.0
 */
final readonly class PKPassBundle
{

    private Archive $archive;

    /**
     * PKPassBundle constructor.
     *
     * @param string $fileName
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public string $fileName
    )
    {
        $this->archive = new Archive();
        $this->archive->open();
    }

    /**
     * Adds a pass to the bundle.
     *
     * @param PKPass $pass
     *
     * @return void
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function add(PKPass $pass): void
    {
        $this->archive->fileContents($pass->fileName, $pass->binary());
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
     * Respond as a binary response.
     *
     * @return Response
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     * @see Archive::respond()
     */
    public function respond(): Response
    {
        return $this->archive->respond()
            ->withHeader(HttpHeader::CONTENT_DISPOSITION, sprintf('attachment; filename="%s"', $this->fileName))
            ->withHeader(HttpHeader::CONTENT_TYPE, 'application/vnd.apple.pkpasses');
    }

}
