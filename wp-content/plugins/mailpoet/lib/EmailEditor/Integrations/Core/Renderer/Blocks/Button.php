<?php declare(strict_types = 1);

namespace MailPoet\EmailEditor\Integrations\Core\Renderer\Blocks;

if (!defined('ABSPATH')) exit;


use MailPoet\EmailEditor\Engine\Renderer\BlockRenderer;
use MailPoet\EmailEditor\Engine\SettingsController;
use MailPoet\EmailEditor\Integrations\Utils\DomDocumentHelper;

/**
 * Renders a button block.
 * @see https://www.activecampaign.com/blog/email-buttons
 * @see https://documentation.mjml.io/#mj-button
 */
class Button implements BlockRenderer {
  public function render($blockContent, array $parsedBlock, SettingsController $settingsController): string {
    // Don't render empty buttons
    if (empty($parsedBlock['innerHTML'])) {
      return '';
    }
    $domHelper = new DomDocumentHelper($parsedBlock['innerHTML']);
    $buttonLink = $domHelper->findElement('a');

    if (!$buttonLink) return '';
    $buttonClasses = $domHelper->getAttributeValueByTagName('div', 'class') ?? '';

    $markup = $this->getMarkup();
    $markup = str_replace('{classes}', $buttonClasses, $markup);

    // Add Link Text
    // Because the button text can contain highlighted text, we need to get the inner HTML of the button
    $markup = str_replace('{linkText}', $domHelper->getElementInnerHTML($buttonLink) ?: '', $markup);
    $markup = str_replace('{linkUrl}', $buttonLink->getAttribute('href') ?: '#', $markup);

    // Width
    // Parent block prepares container with proper width. If the width is set let's use full width of the container
    // otherwise let's use auto width.
    $width = 'auto';
    if (isset($parsedBlock['attrs']['width'])) {
      $width = '100%';
    }
    $markup = str_replace('{width}', $width, $markup);

    // Background
    $themeData = $settingsController->getTheme()->get_data();
    $defaultColor = $themeData['styles']['blocks']['core/button']['color']['background'] ?? 'transparent';
    $colorSetBySlug = isset($parsedBlock['attrs']['backgroundColor']) ? $settingsController->translateSlugToColor($parsedBlock['attrs']['backgroundColor']) : null;
    $colorSetByUser = $colorSetBySlug ?: ($parsedBlock['attrs']['style']['color']['background'] ?? null);
    $bgColor = $colorSetByUser ?? $defaultColor;
    $markup = str_replace('{backgroundColor}', $bgColor, $markup);

    // Styles attributes
    $wrapperStyles = [
      'background' => $bgColor,
      'cursor' => 'auto',
      'word-break' => 'break-word',
      'box-sizing' => 'border-box',
    ];
    $linkStyles = [
      'background-color' => $bgColor,
      'display' => 'block',
      'line-height' => '120%',
      'margin' => '0',
      'mso-padding-alt' => '0px',
    ];

    // Border
    if (isset($parsedBlock['attrs']['style']['border']) && !empty($parsedBlock['attrs']['style']['border'])) {
      // Use text color if border color is not set
      if (!($parsedBlock['attrs']['style']['border']['color'] ?? '')) {
        $parsedBlock['attrs']['style']['border']['color'] = $parsedBlock['attrs']['style']['color']['text'] ?? null;
      }
      $wrapperStyles = array_merge($wrapperStyles, wp_style_engine_get_styles(['border' => $parsedBlock['attrs']['style']['border']])['declarations']);
      $wrapperStyles['border-style'] = 'solid';
    } else {
      // Some clients render 1px border when not set as none
      $wrapperStyles['border'] = 'none';
    }

    // Spacing
    $paddingStyles = wp_style_engine_get_styles(['spacing' => ['padding' => $parsedBlock['attrs']['style']['spacing']['padding'] ?? null ]]);
    $linkStyles = array_merge($linkStyles, $paddingStyles['declarations'] ?? []);
    // In most clients we want to render padding on the link element so that the full button is clickable
    // Outlook doesn't support padding on the link element, so we need to set padding on the wrapper table cell and to have it only for Outlook we use mso-padding-alt
    if (isset($paddingStyles['declarations'])) {
      $paddingTop = $paddingStyles['declarations']['padding-top'] ?? '0px';
      $paddingRight = $paddingStyles['declarations']['padding-right'] ?? '0px';
      $paddingBottom = $paddingStyles['declarations']['padding-bottom'] ?? '0px';
      $paddingLeft = $paddingStyles['declarations']['padding-left'] ?? '0px';
      $wrapperStyles['mso-padding-alt'] = "$paddingTop $paddingRight $paddingBottom $paddingLeft";
    }

    // Typography + colors
    $typography = $parsedBlock['attrs']['style']['typography'] ?? [];
    $color = $parsedBlock['attrs']['style']['color'] ?? [];
    $colorSetBySlug = isset($parsedBlock['attrs']['textColor']) ? $settingsController->translateSlugToColor($parsedBlock['attrs']['textColor']) : null;
    if ($colorSetBySlug) {
      $color['text'] = $colorSetBySlug;
    }
    $typography['fontSize'] = $parsedBlock['email_attrs']['font-size'] ?? 'inherit';
    $typography['textDecoration'] = $typography['textDecoration'] ?? ($parsedBlock['email_attrs']['text-decoration'] ?? 'inherit');
    $linkStyles = array_merge($linkStyles, wp_style_engine_get_styles(['typography' => $typography, 'color' => $color])['declarations']);

    // Escaping
    $wrapperStyles = array_map('esc_attr', $wrapperStyles);
    $linkStyles = array_map('esc_attr', $linkStyles);

    $markup = str_replace('{linkStyles}', $settingsController->convertStylesToString($linkStyles), $markup);
    $markup = str_replace('{wrapperStyles}', $settingsController->convertStylesToString($wrapperStyles), $markup);

    return $markup;
  }

  private function getMarkup(): string {
    return '<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:middle;border-collapse:separate;line-height:100%;width:{width};">
        <tr>
          <td align="center" class="{classes}" bgcolor="{backgroundColor}" role="presentation" style="{wrapperStyles}" valign="middle">
            <a class="wp-block-button__link" href="{linkUrl}" style="{linkStyles}" target="_blank">{linkText}</a>
          </td>
        </tr>
      </table>';
  }
}
