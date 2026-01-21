<?php

namespace App\Services;

use App\Contracts\Services\ConfigurationServiceInterface;
use App\Models\AppSetting;

class ConfigurationService implements ConfigurationServiceInterface
{
    /**
     * Get current application settings
     *
     * @return \App\Models\AppSetting
     */
    public function getSettings()
    {
        return AppSetting::getSettings();
    }

    /**
     * Update application settings
     *
     * @return \App\Models\AppSetting
     */
    public function updateSettings(array $data)
    {
        $settings = $this->getSettings();
        $settings->update($data);

        return $settings;
    }
}
