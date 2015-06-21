<?php

class SV_IntegratedReports_XenForo_DataWriter_Warning extends XFCP_SV_IntegratedReports_XenForo_DataWriter_Warning
{
    protected function _postDelete()
    {
        parent::_postDelete();
        $operationType = SV_IntegratedReports_Model_WarningLog::Operation_DeleteWarning;
        $this->_logOperation($operationType);
    }

    protected function _postSave()
    {
        parent::_postSave();

        $operationType = '';

        if ($this->isInsert())
        {
            $operationType = SV_IntegratedReports_Model_WarningLog::Operation_NewWarning;
        }
        else if ($this->isUpdate())
        {
            $operationType = SV_IntegratedReports_Model_WarningLog::Operation_EditWarning;
            if (!$this->isChanged('expiry_date') && ($this->get('is_expired') == 1 && $this->getExisting('is_expired') == 0))
            {
                $operationType = SV_IntegratedReports_Model_WarningLog::Operation_ExpireWarning;
            }
        }

        $this->_logOperation($operationType);
    }

    protected function _getLogData()
    {
        return array(
            'warning_id'            => $this->get('warning_id'),
            'content_type'          => $this->get('content_type'),
            'content_id'            => $this->get('content_id'),
            'content_title'         => $this->get('content_title'),
            'user_id'               => $this->get('user_id'),
            'warning_date'          => $this->get('warning_date'),
            'warning_user_id'       => $this->get('warning_user_id'),
            'warning_definition_id' => $this->get('warning_definition_id'),
            'title'                 => $this->get('title'),
            'notes'                 => $this->get('notes'),
            'points'                => $this->get('points'),
            'expiry_date'           => $this->get('expiry_date'),
            'is_expired'            => $this->get('is_expired'),
            'extra_user_group_ids'  => $this->get('extra_user_group_ids'),
        );
    }

    protected function _logOperation($operationType)
    {
        $warningLogId = $this->_getWarningLogModel()->LogOperation($operationType, $this->_getLogData());
    }

    protected function _getWarningLogModel()
    {
        return $this->getModelFromCache('SV_IntegratedReports_Model_WarningLog');
    }
}