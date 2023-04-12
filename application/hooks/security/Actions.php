<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Actions {
  private $CI;
  private $REQUEST_METHOD = '';
  private $PATH_INFO = '';
  private $QUERY_STRING = '';
  private $MORE_INFO = [];

  public function __construct() {
    $this->CI = &get_instance();
    $this->CI->load->model('securityModel');

    $this->REQUEST_METHOD = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
    $this->PATH_INFO = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $this->QUERY_STRING = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    $this->MORE_INFO = [
      'HTTP_HOST' => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
      'HTTP_SEC_CH_UA_PLATFORM' => isset($_SERVER['HTTP_SEC_CH_UA_PLATFORM']) ? $_SERVER['HTTP_SEC_CH_UA_PLATFORM'] : '',
      'HTTP_USER_AGENT' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
      'SERVER_ADDR' => isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '',
      'REMOTE_ADDR' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
      'REQUEST_METHOD' => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '',
      'REQUEST_URI' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
      'REQUEST_TIME' => isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : '',
    ];
  }

  public function index() {
    $site = $this->CI->securityModel->findSiteByPathAndMethod($this->PATH_INFO, $this->REQUEST_METHOD);

    if ($site) {
      $data = [
        'site_id' => $site->id,
        'path' => $this->PATH_INFO,
        'query' => $this->QUERY_STRING,
        'method' => $this->REQUEST_METHOD,
        'data_get' => json_encode($_GET),
        'data_post' => json_encode($_POST),
        'data_session' => json_encode($_SESSION),
        'more_info' => json_encode($this->MORE_INFO),
        'user_id' => $this->CI->session->userdata('user_id'),
        'made_at' => date('Y-m-d H:i:s'),
      ];

      $this->CI->securityModel->registrar($data);
    }
  }
}
