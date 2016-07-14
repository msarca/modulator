<?php
/* ===========================================================================
 * Opis Project
 * http://opis.io
 * ===========================================================================
 * Copyright 2014-2016 Marius Sarca
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


use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Package\CompletePackage;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    const PACKAGE_TYPE = 'module';

    /** @var  IOInterface */
    protected $io;

    /** @var  Composer */
    protected $composer;

    /**
     * @param Composer $composer
     * @param IOInterface $io
     * @return mixed
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'pre-autoload-dump' => 'handleDumpAutoload'
        );
    }

    public function handleDumpAutoload(Event $event)
    {
        $extra = $this->composer->getPackage()->getExtra();
        $rootDir = realpath($this->composer->getConfig()->get('vendor-dir') . '/../');
        $settings = isset($extra['application']) ? $extra['application'] : array();

        $installMode = true;
        $installed = $enabled = array();
    }

    protected function preparePackages($installMode, array $enabled, array $installed)
    {
        /** @var CompletePackage[] $packages */
        $packages = $this->composer->getRepositoryManager()->getLocalRepository()->getCanonicalPackages();

        foreach ($packages as $package){
            if($package->getType() !== static::PACKAGE_TYPE){
                continue;
            }

            $module = $package->getName();

            if($installMode){
                $package->setAutoload(array());
                continue;
            }

            if(!in_array($module, $installed)){
                $package->setAutoload(array());
                continue;
            }

            if(in_array($module, $enabled)){
                continue;
            }

            $classmap = array();
            $extra = $package->getExtra();

            foreach (array('collector', 'installer') as $key) {
                if(!isset($extra[$key]) || !is_array($extra[$key])){
                    continue;
                }
                $item = $extra[$key];
                if(isset($item['file']) && isset($item['class'])){
                    $classmap[] = $item['file'];
                }
            }

            $package->setAutoload(empty($classmap) ? array() : array('classmap' => $classmap));
        }

        return $packages;
    }

}