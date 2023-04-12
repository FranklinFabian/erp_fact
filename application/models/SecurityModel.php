<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class SecurityModel extends CI_Model
{
  public function __construct() {
    parent::__construct();
  }

  public function getModules() {
    $this->db->select('*');
    $this->db->where('status', 1);
    return $this->db->get('modules')->result();
  }
  public function getSites() {
    $this->db->select('s.*, m.code as module_code, m.name as module_name');
    $this->db->join('modules m', 'm.id = s.module_id', 'left');
    $this->db->where('s.status', 1);
    return $this->db->get('security_sites s')->result();
  }
  public function getUsers() {
      $this->db->select("*");
      $this->db->where('status', 1);
      return $this->db->get('users')->result();
  }
  public function findSiteByPathAndMethod($path, $method) {
    $this->db->select('*');
    $this->db->where('path', $path);
    $this->db->where('method', $method);
    return $this->db->get('security_sites')->row();
  }
  public function getActionsReport($form_data) {
    $all_users = in_array('*', $form_data['users_id']);
    $this->db->select('sa.*, DATE_FORMAT(sa.made_at, "%d/%m/%Y %H:%i:%s") as made_at_formatted, CONCAT(u.first_name, " ", u.last_name) as user_fullname, m.code as module_code, m.name as module_name, ss.name as site_name, ss.description as site_description');
    $this->db->join('security_sites ss', 'ss.id=sa.site_id', 'left');
    $this->db->join('modules m', 'm.id=ss.module_id', 'left');
    $this->db->join('users u', 'u.user_id=sa.user_id', 'left');
    $this->db->where_in('sa.site_id', $form_data['sites_id']);
    $this->db->where('sa.made_at >=', "{$form_data['initial_date']} 00:00:00");
    $this->db->where('sa.made_at <=', "{$form_data['final_date']} 23:59:59");
    if (!$all_users && count($form_data['users_id']) > 1) {
      $this->db->where_in('sa.user_id', $form_data['users_id']);
    }
    $this->db->order_by('sa.made_at', 'ASC');
    return $this->db->get('security_actions sa')->result();
  }

  public function registrar($data) {
    $this->db->insert('security_actions', $data);
    return $this->db->insert_id();
  }

}
