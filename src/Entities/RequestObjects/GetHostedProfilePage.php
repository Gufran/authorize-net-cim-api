<?php namespace Gufran\AuthNet\Entities\RequestObjects;


class GetHostedProfilePage extends BaseObject {

    protected $methods = array(
        'customerProfileId' => 'customerProfileId',
    );

    public function setSetting($name, $value)
    {
        $setting = array(
            'settingName' => $name,
            'settingValue' => $value
        );

        $this->setData('hostedProfileSettings.setting', $setting);
    }
    /**
     * check if the Object respond to a certain type of request method
     *
     * @param $methodName
     *
     * @return boolean
     */
    public function respondTo($methodName)
    {
        return $methodName == 'GetHostedProfilePage';
    }
}