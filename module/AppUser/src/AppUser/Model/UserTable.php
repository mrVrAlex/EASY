<?php

namespace AppUser\Model;

use Zend\Db\Table\AbstractTable;

class UserTable extends AbstractTable
{
    protected $tableName = 'users';

    public function getUserInfo($id){
        $user = $this->getUser($id);
        $select = $this->select()->setIntegrityCheck(false)->from('users')->join('branch','branch.id = users.branch_id',array('name'))->where('users.id = ?',$user['id']);
        $row = $this->fetchRow($select);
        //$row->toArray();
        return array('id'=>$row->id,'login'=>$row->login,'branch_name'=>$row->name,'branch_id'=>$row->branch_id);
    }
    public function getUser($id)
    {
        $id  = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function addAlbum($artist, $title)
    {
        $data = array(
            'artist' => $artist,
            'title'  => $title,
        );
        $this->insert($data);
    }

    public function updateAlbum($id, $artist, $title)
    {
        $data = array(
            'artist' => $artist,
            'title'  => $title,
        );
        $this->update($data, 'id = ' . (int) $id);
    }

    public function deleteAlbum($id)
    {
        $this->delete('id =' . (int) $id);
    }

}