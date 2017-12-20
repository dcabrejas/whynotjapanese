<?php declare(strict_types=1);

namespace Wnj\GeoIP;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Psr\Http\Message\ServerRequestInterface;
use GeoIp2\Model\City;
use Monolog\Logger;

/**
 * @author Diego Cabrejas <dcabrejas@icloud.com>
 */
class LocationProvider
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(ServerRequestInterface $request, Logger $logger)
    {
        $this->request = $request;
        $this->logger = $logger;
    }

    public function getRequestCityLocation() : ?City
    {
        try {
            $reader = new Reader(__DIR__ . '/../../../GeoLite2-City.mmdb');
        } catch (InvalidDatabaseException | \Exception $e) {
            $this->logger->addWarning("Could not open location database");
            return null;
        }

        try {
            $ipAddress = $this->request->getAttribute('ip_address');
            $record = $reader->city($ipAddress);
        } catch (AddressNotFoundException | \InvalidArgumentException | \Exception $e) {
            $this->logger->addWarning("Could not find location address", ['ip' => $ipAddress]);
            return null;
        }

        return $record;
    }
}
