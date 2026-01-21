<?php

namespace App\Contracts\Services;

interface ConfigurationServiceInterface
{
    /**
     * Get current application settings
     *
     * @return \App\Models\AppSetting
     */
    public function getSettings();

    /**
     * Update application settings
     *
     * @return \App\Models\AppSetting
     */
    public function updateSettings(array $data);
}
