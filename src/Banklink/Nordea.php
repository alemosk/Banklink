<?php

namespace Banklink;

use Banklink\Protocol\Solo;

/**
 * Banklink implementation for Nordea using Solo protocol for communication
 * For specs see http://www.nordea.ee/sitemod/upload/root/www.nordea.ee%20-%20default/Teenused%20firmale/E-Payment_v1_1.pdf
 *
 * @author Roman Marintsenko <inoryy@gmail.com>
 * @since  25.11.2012
 */

// As of 2014 Nordea also uses iPizza protocol:
// http://www.nordea.ee/sitemod/upload/root/content/nordea_ee_uk/eeen_corporate/eeen_co_igapaevapangandus_pr/maksete_kogumine/e-makse_teh_kirj_eng.pdf
use Banklink\Protocol\iPizza;

class Nordea extends Banklink
{
    const OLD_REQUEST_URL = 'https://netbank.nordea.com/pnbepay/epayn.jsp';
    const REQUEST_URL = 'https://netbank.nordea.com/pnbepay/epayp.jsp';

    protected $requestUrl = '';
    // Currently bank provides the test environment: http://www.nordea.ee/sitemod/upload/root/content/nordea_ee_uk/eeen_corporate/eeen_co_igapaevapangandus_pr/maksete_kogumine/IPizza_test_ENG.pdf
    // protected $testRequestUrl = 'https://pangalink.net/banklink/nordea';
    protected $testRequestUrl = 'https://netbank.nordea.com/pnbepaytest/epayp.jsp';

    protected $responseEncoding = 'UTF-8';

    /**
     *
     * @param \Banklink\Protocol\iPizza $protocol
     * @param boolean                   $testMode
     * @param string | null             $requestUrl
     */
    public function __construct($protocol, $testMode = false, $requestUrl = null)
    {
        $this->requestUrl = $protocol instanceof iPizza ? self::REQUEST_URL : self::OLD_REQUEST_URL;
        parent::__construct($protocol, $testMode, $requestUrl);
    }

    /**
     * @inheritDoc
     */
    protected function getEncodingField()
    {
        return $this->protocol instanceof iPizza ? 'VK_ENCODING' : null;
    }

    protected function getAdditionalFields()
    {
        return $this->protocol instanceof iPizza ? array(
            'VK_ENCODING' => $this->requestEncoding
        ) : array();
    }
}
