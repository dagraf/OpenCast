<?php

namespace srag\Plugins\Opencast\Model\Metadata\Config\Series;

use srag\Plugins\Opencast\Model\Metadata\Config\MDFieldConfigAR;
use srag\Plugins\Opencast\Model\Metadata\Config\MDFieldConfigRepository;
use srag\Plugins\Opencast\Model\Metadata\Config\MDPrefillOption;

class MDFieldConfigSeriesRepository implements MDFieldConfigRepository
{
    /**
     * @return MDFieldConfigSeriesAR[]
     */
    public function getAll() : array
    {
        return MDFieldConfigSeriesAR::orderBy('sort')->get();
    }

    public function getAllEditable(): array
    {
        return MDFieldConfigSeriesAR::where(['read_only' => false])->orderBy('sort')->get();
    }

    public function getArray() : array
    {
        return MDFieldConfigSeriesAR::orderBy('sort')->getArray();
    }

    public function findByFieldId(string $field_id): ?MDFieldConfigAR
    {
        $ar = MDFieldConfigSeriesAR::where(['field_id' => $field_id])->first();
        return $ar;
    }

    public function storeFromArray(array $data) : MDFieldConfigAR
    {
        $ar = MDFieldConfigSeriesAR::where(['field_id' => $data['field_id']])->first();
        if (is_null($ar)) {
            $ar = new MDFieldConfigSeriesAR();
        }        $ar->setFieldId($data['field_id']);
        $ar->setTitle($data['title']);
        $ar->setVisibleForPermissions($data['visible_for_permissions']);
        $ar->setPrefill(new MDPrefillOption($data['prefill']));
        $ar->setReadOnly($data['read_only']);
        $ar->setRequired($data['required']);
        $ar->create();
        return $ar;
    }
}