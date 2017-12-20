<?php

use Slim\Http\Request;
use Slim\Http\Response;
use PHPMailer\PHPMailer\Exception;
use Wnj\Messages;

// Routes
$app->get('/', function (Request $request, Response $response) {
    // Render index view
    $vars = [
        'nameKey'  => $this->csrf->getTokenNameKey(),
        'valueKey' => $this->csrf->getTokenValueKey(),
        'name'     => $request->getAttribute($this->csrf->getTokenNameKey()),
        'value'    => $request->getAttribute($this->csrf->getTokenValueKey()),
        'messages' => new Messages()
    ];
    return $this->renderer->render($response, 'index.phtml', $vars);
});

$app->post('/contact/post', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $messages = new Messages();

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $messages->addError('Invalid email address');
    }

    //sanitize
    $formDataClean = [];
    $formDataClean['firstname'] = filter_var($data['firstname'], FILTER_SANITIZE_STRING);
    $formDataClean['lastname']  = filter_var($data['lastname'], FILTER_SANITIZE_STRING);
    $formDataClean['email']     = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $formDataClean['subject']   = filter_var($data['subject'], FILTER_SANITIZE_STRING);
    $formDataClean['message']   = filter_var($data['message'], FILTER_SANITIZE_STRING);

    try {
        //Server settings
        /** @var \Wnj\Mailer $mail */
        $mail = $this->mailer;

        //Recipients
        $mail->setFrom('maki@whynotjapanese.com', 'Why Not Japanese');
        $mail->addAddress('maki@whynotjapanese.com', 'Maki Cabrejas');
        $mail->addReplyTo($formDataClean['email'], $formDataClean['firstname'] . ' ' . $formDataClean['lastname']);
        $mail->addBCC('dcabrejas@icloud.com');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'From the website';
        $date = (new \DateTime('now', new \DateTimeZone('Europe/London')))->format('F j, Y, g:i a');
        $mail->Body = "<b>UK time : </b>" . $date . '<br>' .
            "<b>Sender's name : </b>"  . $formDataClean['firstname'] . ' ' . $formDataClean['lastname'] . '<br>' .
            "<b>Sender's Email : </b>"  . $formDataClean['email'] .'<br>' .
            "<b>Sender's Subject : </b>"  . $formDataClean['subject'] .'<br>' .
            "<b>Message : </b>"  . $formDataClean['message'];

        $mail->send();
        $messages->addSuccess("Thanks! We'll be in touch shortly.");
    } catch (Exception $e) {
        $messages->addError('Sorry, there was a problem while sending your email.');
        $this->logger->addDebug('Failed to send email, error: ' . $mail->ErrorInfo);
    }

    return $response->withRedirect('/');
});
