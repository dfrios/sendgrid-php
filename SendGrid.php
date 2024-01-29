<?php

require('./CrmInterface.php');


/**
 * Class to connect to Brevo API
 */
class SendGrid implements CrmInterface {

  private $apiKey = "";
  private $baseUrl = "";


  /**
   * Constructor
   */
  public function __construct(string $baseUrl, string $apiKey) {
    $this->baseUrl = $baseUrl;
    $this->apiKey = $apiKey;
  }


  /**
   * Get contact from SendGrid platform
   */
  public function getContact(string $email) : int|string {

    $data = [
      'emails' => [
        $email
      ]
    ];

    $response = $this->curlExec("marketing/contacts/search/emails", "POST", $data);
    $responseJson = json_decode($response);

    return isset($responseJson->result) ? $contactId = $responseJson->result->$email->contact->id : 0;
  }


  /**
   * Add new contact to SendGrid platform
   */
  public function createContact(array $data = array(), int|string $listId) {

    $jobId = $this->addContact($data, $listId);

    return $jobId;
  }


  /**
   * Add existing contact to a list of contacts
   */
  public function addContactToList(string $email, int|string $listId) : bool {

    $dataToSend = [
      "list_ids" => [
        $listId,
      ],
      "contacts" => array([
        "email" => $email,
      ])
    ];

    $response = $this->curlExec('marketing/contacts', 'PUT', $dataToSend);
    $responseJson = json_decode($response);
    
    return (isset($responseJson->job_id)) ? true : false;
  }


  /**
   * Send email using template created and stored on SendGrid platform
   */
  public function sendEmail(int|string $templateId, array $data = array()) {

    $dataToSend = array(
      'from' => array(
        'email' => SENDGRID_EMAIL_FROM,
      ),
      'personalizations' => [
        array(
          "to" => [
            array(
              'email' => $data['email'],
            )
          ],
        )
      ],
      'template_id' => $templateId
    );

    $response = $this->curlExec('mail/send', 'POST', $dataToSend);
  }


  /**
   * Add contact. Private method
   */
  private function addContact(array $data = array(), int|string $listId) : int|string {

    $dataToSend = [
      "list_ids" => [
        $listId,
      ],
      "contacts" => array([
        "email" => $data['email'],
        "first_name" => $data['attributes']['FIRSTNAME'],
        "last_name" => $data['attributes']['LASTNAME'],
        "country" => $data['attributes']['PAIS'],
        "phone_number" => $data['attributes']['CELLPHONE'],
        // "custom_fields" => [
        // ]
      ])
    ];

    $response = $this->curlExec('marketing/contacts', 'PUT', $dataToSend);
    $responseJson = json_decode($response);
    
    return (isset($responseJson->job_id)) ? ($responseJson->job_id) : 0;
  }


  /**
   * Execute cURL petition. Private method
   */
  private function curlExec(string $req, string $proto = 'GET', array $postVars = array()) {

    $curl = curl_init($this->baseUrl . "/" . $req);

    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Authorization: Bearer {$this->apiKey}"
    ));

    if ($proto == 'POST') {
      curl_setopt($curl, CURLOPT_POST, TRUE);
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postVars, JSON_PRETTY_PRINT));
    }

    if ($proto == 'GET') {
    }

    if ($proto == 'PUT') {
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postVars, JSON_PRETTY_PRINT));
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_VERBOSE, true);
// var_dump(curl_getinfo($curl));die();
    $salida = curl_exec($curl);
// var_dump(curl_error($curl));die();
    curl_close($curl);
// var_dump($salida);die();

    // Almacenamiento de logs
    date_default_timezone_set('America/Bogota');
    file_put_contents('sendgrid.log.txt',
        '[' . date(DATE_RFC2822) . "]\n" .
        json_encode($postVars, JSON_PRETTY_PRINT) . "\n\n" .
        $salida . "\n\n================\n\n",
      FILE_APPEND);

    return $salida;
  }
}