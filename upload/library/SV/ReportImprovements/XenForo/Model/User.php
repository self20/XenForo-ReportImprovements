<?php

class SV_ReportImprovements_XenForo_Model_User extends XFCP_SV_ReportImprovements_XenForo_Model_User
{

    public function canManageReportedMessage(array $user, &$errorPhraseKey = '', array $viewingUser = null)
    {
        $this->standardizeViewingUserReference($viewingUser);

        if ($this->_getReportModel()->canViewReports($viewingUser) &&
            (
             XenForo_Permission::hasPermission($viewingUser['permissions'], 'general', 'viewReportUser')
            )
           )
        {
            return true;
        }

        $errorPhraseKey = 'you_may_not_manage_this_reported_content';
        return false;
    }

    protected function _getReportModel()
    {
        return $this->getModelFromCache('XenForo_Model_Report');
    }
}