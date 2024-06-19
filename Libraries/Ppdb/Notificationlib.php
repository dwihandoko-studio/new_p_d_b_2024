<?php

namespace App\Libraries\Ppdb;

use App\Libraries\Uuid;

class Notificationlib
{
  var $options = ['timeout' => 3];

  //private function _send_json($link)
  //{
  //   $options = [
  //           //'baseURI' => 'https://sandbox.bca.co.id'.$link,
  //           'timeout'  => 3
  //   ];
  //   $client = \Config\Services::curlrequest($options);

  // 	return $client;
  //}
  private $_db;
  function __construct()
  {
    helper(['text', 'array', 'filesystem']);
    $this->_db      = \Config\Database::connect();
  }


  public function send($data)
  {
    $date = date('Y-m-d H:i:s');

    $builder = $this->_db->table('_notification_tb');
    $uuid = new Uuid();
    $id = $uuid->v4();

    $dataCreate = [
      'id' => $id,
      'token' => $data['token'],
      'judul' => $data['judul'],
      'isi' => $data['isi'],
      'send_from' => $data['send_from'],
      'send_to' => $data['send_to'],
      'action_web' => $data['action_web'],
      'action_app' => $data['action_app'],
      'created_at' => $date
    ];
    return $builder->insert($dataCreate);
  }

  public function view($user_id)
  {
    $date = date('Y-m-d H:i:s');

    $builder = $this->_db->table('_notification_tb');

    $dataView = [
      'readed' => 1
    ];
    return $builder->where('send_to', $user_id)->update($dataView);
  }
}
