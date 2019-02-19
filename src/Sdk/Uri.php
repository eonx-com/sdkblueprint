<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\UriInterface;

class Uri implements UriInterface
{
    /**
     * Host component of a URI.
     *
     * @var string
     */
    private $host;

    /**
     * Path component of a URI.
     *
     * @var string
     */
    private $path;

    /**
     * Uri port.
     *
     * @var int|null
     */
    private $port;

    /**
     * URI scheme.
     *
     * @var string
     */
    private $scheme;

    /**
     * Construct a URI.
     *
     * @param string $host
     * @param string $path
     * @param string $scheme
     * @param int|null $port
     */
    public function __construct(string $host, string $path, string $scheme, ?int $port =null)
    {
        $this->host = $host;
        $this->path = $path;
        $this->port = $port;
        $this->scheme = $scheme;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        $uri = '';
        // append uri scheme
        $uri .= \sprintf('%s:', $this->getScheme());

        // append uri host
        $uri .= $this->getHost();

        // if port is provided, then append port
        if ($this->getPort() !== null) {
            $uri .= \sprintf(':%d', $this->getPort());
        }

        if ($this->getPath() !== null) {
            $uri .= $this->getPath();
        }

        return $uri;
    }

    /**
     * @inheritdoc
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @inheritdoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritdoc
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @inheritdoc
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'host' => $this->getHost(),
            'path' => $this->getPath(),
            'port' => $this->getPort(),
            'scheme' => $this->getScheme()
        ];
    }
}
