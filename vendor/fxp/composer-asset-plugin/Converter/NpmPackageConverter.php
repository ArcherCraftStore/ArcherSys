<?php

/*
 * This file is part of the Fxp Composer Asset Plugin package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Composer\AssetPlugin\Converter;

/**
 * Converter for NPM package to composer package.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class NpmPackageConverter extends AbstractPackageConverter
{
    /**
     * {@inheritdoc}
     */
    public function convert(array $data, array &$vcsRepos = array())
    {
        $assetType = $this->assetType;
        $keys = array(
            'name'               => array('name', function ($value) use ($assetType) {
                return $assetType->formatComposerName($value);
            }),
            'type'               => array('type', function () use ($assetType) {
                return $assetType->getComposerType();
            }),
            'version'            => array('version', function ($value) use ($assetType) {
                return $assetType->getVersionConverter()->convertVersion($value);
            }),
            'version_normalized' => 'version_normalized',
            'description'        => 'description',
            'keywords'           => 'keywords',
            'homepage'           => 'homepage',
            'license'            => 'license',
            'author'             => array('authors', function ($value) {
                if (null !== $value) {
                    $value = array($value);
                }

                return $value;
            }),
            'contributors'       => array('authors', function ($value, $prevValue) {
                $mergeValue = is_array($prevValue) ? $prevValue : array();
                $mergeValue = array_merge($mergeValue, is_array($value) ? $value : array());

                if (count($mergeValue) > 0) {
                    $value = $mergeValue;
                }

                return $value;
            }),
            'bin'                => 'bin',
        );
        $dependencies = array(
            'dependencies'    => 'require',
            'devDependencies' => 'require-dev',
        );
        $extras = array(
            'bugs'                 => 'npm-asset-bugs',
            'files'                => 'npm-asset-files',
            'main'                 => 'npm-asset-main',
            'man'                  => 'npm-asset-man',
            'directories'          => 'npm-asset-directories',
            'repository'           => 'npm-asset-repository',
            'scripts'              => 'npm-asset-scripts',
            'config'               => 'npm-asset-config',
            'bundledDependencies'  => 'npm-asset-bundled-dependencies',
            'optionalDependencies' => 'npm-asset-optional-dependencies',
            'engines'              => 'npm-asset-engines',
            'engineStrict'         => 'npm-asset-engine-strict',
            'os'                   => 'npm-asset-os',
            'cpu'                  => 'npm-asset-cpu',
            'preferGlobal'         => 'npm-asset-prefer-global',
            'private'              => 'npm-asset-private',
            'publishConfig'        => 'npm-asset-publish-config',
        );

        return $this->convertData($data, $keys, $dependencies, $extras, $vcsRepos);
    }
}
