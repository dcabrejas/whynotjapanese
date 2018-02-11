<?php

namespace Wnj\Contact\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Wnj\Messages;
use PHPMailer\PHPMailer\Exception;
use Wnj\Mail\Mailer;
use Monolog\Logger;
use Wnj\GeoIP\LocationProvider;

/**
 * @author Diego Cabrejas <dcabrejas@icloud.com>
 */
class ContactController
{
    private $mailer;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var LocationProvider
     */
    private $locationProvider;

    public function __construct(Mailer $mailer, Logger $logger, LocationProvider $locationProvider) {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->locationProvider = $locationProvider;
    }

    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $messages = new Messages();

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $messages->addError('Invalid email address');
        }
        $formDataClean = $this->sanitizeData($data);

        try {
            /** @var \Wnj\Mail\Mailer $mail */
            $mail = $this->mailer;

            //Recipients
            $mail->setFrom('maki@whynotjapanese.com', 'Why Not Japanese');
            //$mail->addAddress('dcabrejas@icloud.com', 'Diego Cabrejas');
            $mail->addAddress('maki@whynotjapanese.com', 'Maki Cabrejas');
            $mail->addReplyTo($formDataClean['email'], $formDataClean['firstname'] . ' ' . $formDataClean['lastname']);
            $mail->addBCC('dcabrejas@icloud.com');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'From the website';
            $mail->Body = $this->getEmailBody($formDataClean);

            $mail->send();
            $messages->addSuccess("Thanks! We'll be in touch shortly.");
        } catch (Exception $e) {
            $messages->addError('Sorry, there was a problem while sending your email.');
            $this->logger->addDebug('Failed to send email, error: ' . $mail->ErrorInfo);
        }

        return $response->withRedirect('/');
    }

    private function sanitizeData(array $data): array
    {
        $formDataClean = [];
        $formDataClean['firstname'] = filter_var($data['firstname'], FILTER_SANITIZE_STRING);
        $formDataClean['lastname'] = filter_var($data['lastname'], FILTER_SANITIZE_STRING);
        $formDataClean['level'] = filter_var($data['level'], FILTER_SANITIZE_STRING);
        $formDataClean['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $formDataClean['subject'] = filter_var($data['subject'], FILTER_SANITIZE_STRING);
        $formDataClean['message'] = filter_var($data['message'], FILTER_SANITIZE_STRING);
        return $formDataClean;
    }

    private function getEmailBody(array $data) : string
    {
        $date = (new \DateTime('now', new \DateTimeZone('Europe/London')))->format('F j, Y, g:i a');
        $body =  "<b>UK time : </b>" . $date . '<br>' .
        "<b>Sender's name : </b>"  . $data['firstname'] . ' ' . $data['lastname'] . '<br>' .
        "<b>Sender's Email : </b>"  . $data['email'] .'<br>' .
        "<b>Sender's Level : </b>"  . $data['level'] .'<br>' .
        "<b>Sender's Subject : </b>"  . $data['subject'] .'<br>' .
        "<b>Message : </b>"  . $data['message'];

        $location = $this->locationProvider->getRequestCityLocation();
        if ($location) {
            $body .= "<br><br><h3>User location</h3><br>" .
                "<b>City : </b>"  . $location->city->name .'<br>' .
                "<b>Region : </b>"  . $location->mostSpecificSubdivision->name .'<br>' .
                "<b>Country : </b>"  . $location->country->name .'<br>';
        }

        return $body;
    }
}
