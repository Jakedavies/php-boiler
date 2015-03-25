<?php
use Mailgun\Mailgun;
/*
 * This is the mailer that all other mailers will inherit from
 */
class BaseMailer
{
    function __construct($sendto)
    {
        $this->to = $sendto;

        # Use kevin.eger@alumni.ubc.ca Mailgun API key
        $this->mgClient = new Mailgun("key-ee391de64ef7981bf903803d9ae04af9");
        $this->domain = "sandbox5beacfeef41a4a9f92d04cc21a3d9d44.mailgun.org";

        # Next, instantiate a Message Builder object from the SDK.
        $this->messageBldr = $this->mgClient->MessageBuilder();
    }
    public function addBody()
    {
        $this->body = 'Default Body';
    }
    public function addSubject()
    {
        $this->subject = 'Default Subject';
    }
    function send(){
        $this->addSubject();


        # Define the from address.
        $this->messageBldr->setFromAddress("mailgun@sandbox5beacfeef41a4a9f92d04cc21a3d9d44.mailgun.org");


        $this->messageBldr->setSubject($this->subject);
        $this->messageBldr->addToRecipient($this->to);

        $this->messageBldr->setHtmlBody($this->body);
        $this->messageBldr->setTextBody("Tits");

        $this->mgClient->post("{$this->domain}/messages", $this->messageBldr->getMessage(), $this->messageBldr->getFiles());
    }
}