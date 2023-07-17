<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\SitesManager\SiteContentDetection;

use Piwik\Piwik;

class ReactJs extends SiteContentDetectionAbstract
{
    public static function getName(): string
    {
        return 'React.js';
    }

    public static function getContentType(): string
    {
        return self::TYPE_JS_FRAMEWORK;
    }

    public static function getInstructionUrl(): ?string
    {
        return 'https://matomo.org/faq/new-to-piwik/how-do-i-start-tracking-data-with-matomo-on-websites-that-use-react/';
    }

    public static function getPriority(): int
    {
        return 60;
    }

    public function detectByContent(?string $data = null, ?array $headers = null): bool
    {
        $needles = ['react.min.js' ,'react.development.min.js', 'react-dom.development.min.js' ,'react.development.js',
                    'react-dom.development.js', 'ReactDOM.', 'react.production.min.js', 'react-jsx-dev-runtime.development.js',
                    'react-jsx-dev-runtime.development.min.js', 'react-jsx-dev-runtime.production.min.js',
                    'react-jsx-dev-runtime.profiling.min.js', 'react-jsx-runtime.development.js', 'react-jsx-runtime.development.min.js',
                    'react-jsx-runtime.production.min.js', 'react-jsx-runtime.profiling.min.js', 'react.shared-subset.development.js',
                    'react.shared-subset.development.min.js', 'react.shared-subset.production.min.js', 'react.profiling.min.js'
        ];
        $hasReactNative = (stripos($data, 'react-native') !== false);

        foreach ($needles as $needle) {
            if (stripos($data, $needle) !== false && !$hasReactNative) {
                return true;
            }
        }

        return false;
    }

    public function shouldHighlightTabIfShown(): bool
    {
        return true;
    }

    public function renderInstructionsTab(array $detections = []): string
    {
        return '
            <p></p><p></p>
            <div class="system notification notification-info">
                ' . Piwik::translate(
                        'SitesManager_ReactDetected',
                        [
                            '<a target="_blank" rel="noreferrer noopener" href="https://matomo.org/guide/tag-manager/">',
                            '</a>',
                            '<a target="_blank" rel="noreferrer noopener" href="https://matomo.org/faq/new-to-piwik/how-do-i-start-tracking-data-with-matomo-on-websites-that-use-react/">',
                            '</a>'
                        ]
            ) . '
            </div>

            <div class="right">
                <img src="plugins/SitesManager/images/react-icon.png" style="height: 5rem;">
            </div>
';
    }

    public function renderOthersInstruction(): string
    {
        return sprintf(
            '<p>%s</p>',
            Piwik::translate(
                'SitesManager_SiteWithoutDataReactDescription',
                [
                    '<a target="_blank" rel="noreferrer noopener" href="https://matomo.org/guide/tag-manager/">',
                    '</a>',
                    '<a target="_blank" rel="noreferrer noopener" href="https://matomo.org/faq/new-to-piwik/how-do-i-start-tracking-data-with-matomo-on-websites-that-use-react/">',
                    '</a>',
                ]
            )
        );
    }
}
