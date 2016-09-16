<?php

namespace Omnipay\Migs\Message;

class TwoPartyRefundRequest extends AbstractRequest
{
    /**
     * The action performed by this request.
     *
     * @var string
     */
    protected $action = 'refund';

    /**
     * Get the data we need to send to the VPC server.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'transactionId','transactionNumber');

        $data = $this->getBaseData();

        $data['vpc_TransNo'] = $this->getTransactionNumber();;
        $data["vpc_User"] = $this->getUser();
        $data["vpc_Password"] = $this->getPassword();

        return $data;
    }

    /**
     * The VPC Transaction number.
     *
     * @return string
     */
    public function getTransactionNumber()
    {
        return $this->getParameter('transactionNumber');
    }

    /**
     * A user who's allowed to perform a refund.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->getParameter('user');
    }

    /**
     * This user's password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * The the VPC endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint.'vpcdps';
    }

    /**
     * Send the data to the migs server.
     *
     * @param  array  $data
     * @return \Omnipay\Migs\Message\Response
     */
    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint(), null, $data)->send();

        return $this->response = new Response($this, $httpResponse->getBody());
    }
}
