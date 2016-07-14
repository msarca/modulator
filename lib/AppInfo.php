<?php
/* ===========================================================================
 * Opis Project
 * http://opis.io
 * ===========================================================================
 * Copyright 2016 Marius Sarca
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================================ */

namespace Opis\Modulator;


class AppInfo
{
    const VENDOR_DIR = 'vendor-dir';
    const COMPOSER_FILE = 'composer-file';
    const BOOTSTRAP_FILE = 'bootstrap-file';
    const CLASSMAP_KEYS = 'classmap_keys';

    /** @var  string */
    protected $rootDir;

    /** @var  array */
    protected $settings = array();

    /**
     * AppInfo constructor
     *
     * @param string $rootDir
     * @param array $settings
     */
    public function __construct($rootDir, array $settings)
    {
        $settings += array(
            static::VENDOR_DIR => 'vendor',
            static::COMPOSER_FILE => 'composer.json',
            static::BOOTSTRAP_FILE => 'bootstrap.php',
        );

        $this->rootDir = $rootDir;
        $this->settings = $settings;
    }

    /**
     * @return string
     */
    public function rootDir()
    {
        return $this->rootDir;
    }

    /**
     * @return string
     */
    public function vendorDir()
    {
        return $this->rootDir . '/' . $this->settings[static::VENDOR_DIR];
    }

    /**
     * @return string
     */
    public function composerFile()
    {
        return $this->rootDir . '/' . $this->settings[static::COMPOSER_FILE];
    }

    /**
     * @return string
     */
    public function bootstrapFile()
    {
        return $this->rootDir . '/' . $this->settings[static::BOOTSTRAP_FILE];
    }

    /**
     * @return bool
     */
    public function installMode()
    {
        return !file_exists($this->bootstrapFile());
    }
}