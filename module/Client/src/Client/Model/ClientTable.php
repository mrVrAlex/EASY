<?php

namespace Client\Model;

use Core\Db\Table as DbTable,
    Zend\Db;

class ClientTable extends DbTable
{
    protected $_name = 'clients';

    public function insert($data){
        $fieldStat = array(
            'add_date' => new Db\Expr('NOW()'),
        );
        $data += $fieldStat;
        return parent::insert($this->filterField($data));
    }




    public function getAlbum($id)
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