<?php
require_once dirname(__FILE__).'/BaseMailer.php';
/*
 * Mailer for confirming an account
 */
class VerifyEmailMailer extends BaseMailer
{
    public function addBody($code)
    {
        # Todo: local url = localhost:8000/user/registration/$code
        $this->body = "<a href=\"http://localhost:8000/user/registration/$code\"><p>Confirmation Link</p></a>";
        error_log("Adding body");
    }
    public function addSubject()
    {
        $this->subject = 'DON: Email Verification';
    }
}