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


use Composer\Package\CompletePackage;

interface ApplicationStatusInterface
{
    /**
     * ApplicationStatusInterface constructor
     *
     * @param $rootDir
     * @param array $settings
     */
    public function __construct($rootDir, array $settings);

    /**
     * Check if the application was installed or not
     *
     * @return mixed
     */
    public function installMode();

    /**
     * Get class map for an
     *
     * @param array $extra
     * @return array
     */
    public function getClassMap(array $extra);

    /**
     * Return a list of enabled packages
     *
     * @return string[]
     */
    public function getEnabledPackages();

    /**
     * Return a list of installed packages
     *
     * @return string[]
     */
    public function getInstalledPackages();

}