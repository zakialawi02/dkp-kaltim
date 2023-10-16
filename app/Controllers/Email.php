<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\BaseController;
use Faker\Extension\Helper;

class Email extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
        echo "MAIL";
    }

    public function send()
    {
        $email = \Config\Services::email();
        $name = $this->request->getPost('name');
        $senderMail = $this->request->getPost('email');
        $to = $email->fromEmail;
        $subject = 'Ada Pesan Dari ' . $name . ' [SIMATA LAUT]';
        $messageContent = $this->request->getPost('message');

        $message = "<p>Nama Pengirim: $name</p>";
        $message .= "<p>Email Pengirim: $senderMail</p>";
        $message .= "<p>Message:</p>";
        $message .= "<p>$messageContent</p>";

        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            session()->setFlashdata('success', 'pesan berhasil dikirim.');
            return $this->response->redirect(site_url('/kontak'));
        } else {
            session()->setFlashdata('error', 'Gagal mengirim pesan.');
            return $this->response->redirect(site_url('/kontak'));
        }
    }

    public function tesMailNotif()
    {
        $emailTo = $this->request->getPost('emailTo');
        $email = \Config\Services::email();
        $email->setTo($emailTo);
        $email->setSubject('Pemberitahuan Status Pengajuan Informasi Simata Laut Kaltim');
        $message = view('_Layout/_template/_email/statusAjuan');
        $email->setMessage($message);
        $email->setMailType('html');
        $email->send();
        $response = ['status' => 'true'];
        return $this->response->setJSON($response);
    }
}
