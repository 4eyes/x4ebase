<?php

namespace X4e\X4ebase\Log\Writer;

class EmailWriter extends \TYPO3\CMS\Core\Log\Writer\AbstractWriter
{

    /**
     * @var string
     */
    protected $recipient = '';

    /**
     * @var string
     */
    protected $sender = '';

    /**
     * @var string
     */
    protected $subject = '';

    /**
     * @var string
     */
    protected $body = '';

    /**
     * @var string
     */
    protected $bodyIntro = '';

    /**
     * @var int
     */
    protected $cropLength = 100;

    /**
     * Renders the E-Mail
     *
     * @param \TYPO3\CMS\Core\Log\LogRecord $record
     * @return \X4e\X4ebase\Log\Writer\Email
     */
    public function writeLog(\TYPO3\CMS\Core\Log\LogRecord $record)
    {
        if (empty($this->recipient) || empty($this->sender)) {
            return $this;
        }

        $this->subject =
            '[' . \TYPO3\CMS\Core\Utility\GeneralUtility::getHostname() . '] ' .
            '[' . \TYPO3\CMS\Core\Log\LogLevel::getName($record->getLevel()) . '] ' .
            'in ' . $record->getComponent() . ': ' .
            $record->getMessage()
        ;
        $this->subject = \TYPO3\CMS\Core\Utility\GeneralUtility::fixed_lgd_cs($this->subject, $this->cropLength);

        $this->body = '';
        if ($this->bodyIntro) {
            $this->body = $this->bodyIntro . '<br/><br/>';
        }
        $this->body .= $record->getMessage() . '<br/><br/>' . print_r($record->getData(), true);

        $this->sendMail();

        return $this;
    }

    /**
     * Send a mail using the SwiftMailer API
     *
     * @return void
     */
    protected function sendMail()
    {

        /** @var \TYPO3\CMS\Core\Mail\MailMessage $mail */
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $recipients = explode(',', $this->recipient);
        foreach ($recipients as $r) {
            $mail->addTo($r);
        }
        $mail->setFrom($this->sender);
        $mail->setSubject($this->subject);
        $mail->setBody(str_replace('<br/>', PHP_EOL, $this->body));

        try {
            $mail->send();
        } catch (Exception $e) {
            \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__)->warning($e);
        }
    }

    /**
     * Sets the E-Mail address of the sender
     *
     * @param string $sender
     * @return void
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * Sets the E-Mail address of the recipient
     *
     * @param string $recipient
     * @return void
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->bodyIntro = $body;
    }

    /**
     * @param int $cropLength
     */
    public function setCropLength($cropLength)
    {
        $this->cropLength = $cropLength;
    }
}
