<?php

namespace Unidays;

class WhenVerifyingAValidHashTest extends TestCaseBase
{
    private $key;

    public function initialise()
    {
        $this->key = 'tnFUmqDkq1w9eT65hF9okxL1On+d2BQWUyOFLYE3FTOwHjmnt5Sh/sxMA3/i0od3pV5EBfSAmXo//fjIdAE3cIAatX7ZZqVi0Dr8qEYGtku+ZRVbPSmTcEUTA/gXYo3KyL2JqXaZ/qhUvCMbLWyV07qRiFOjyLdOWhioHlJM5io=';
    }

    /**
     * @test
     */
    public function WhenVerifyingUrlParametersThenTheDateIsCorrect()
    {
        $ud_s = "eesNa1l1bUWKHsWfOLemXQ==";
        $ud_t = "1420070400";
        $ud_h = "qaOotWTdl1GjooDmgagETc4ov8FPo4U7rE5RDp0Gfnmo4UVe5JDQhQYDgi1CXNwYa8xSXE4B0QmM96kqf4DLsw==";

        $verifier = new CodelessUrlVerifier($this->key);
        $verified = $verifier->verify_url_params($ud_s, $ud_t, $ud_h);


        $this->assertEquals(new \DateTime("@" . $ud_t, new \DateTimeZone("UTC")), $verified);
    }

    /**
     * @test
     */
    public function WhenVerifyingUrlThenTheDateIsCorrect()
    {
        $url = 'https://test.com?ud_s=eesNa1l1bUWKHsWfOLemXQ%3D%3D&ud_t=1420070400&ud_h=qaOotWTdl1GjooDmgagETc4ov8FPo4U7rE5RDp0Gfnmo4UVe5JDQhQYDgi1CXNwYa8xSXE4B0QmM96kqf4DLsw%3D%3D';

        $verifier = new CodelessUrlVerifier($this->key);
        $verified = $verifier->verify_url($url);

        $this->assertEquals(new \DateTime("@1420070400", new \DateTimeZone("UTC")), $verified);
    }
}
