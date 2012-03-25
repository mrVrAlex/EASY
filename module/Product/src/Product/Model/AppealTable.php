<?php

namespace Product\Model;

use Zend\Db,
    Core\Db\Table as DbTable;

class AppealTable extends DbTable
{
    protected $_name = 'appeal';

    public function insert($data){
        $fieldStat = array(
            'appeal_date' => new Db\Expr('NOW()'),
            'status' => 0
        );
        $data += $fieldStat;
        return parent::insert($this->filterField($data));
    }

    public function getClientByAppeal($id){

        $select = $this->select()->setIntegrityCheck(false)
                                 ->from('appeal')
                                 ->where('appeal.id = ?',$id)
                                 ->join('clients','appeal.client_id = clients.id',array('firstname','lastname','patronymic','birthdate','data'))
                                 ->join('products','appeal.product_id = products.id',array('product_name'));
        return $this->fetchRow($select)->toArray();
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