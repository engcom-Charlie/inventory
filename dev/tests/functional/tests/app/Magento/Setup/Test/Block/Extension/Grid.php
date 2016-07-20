<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Setup\Test\Block\Extension;

use Magento\Mtf\Client\Locator;
use Magento\Setup\Test\Fixture\Extension;

/**
 * Extensions Grid block.
 */
class Grid extends AbstractGrid
{
    /**
     * "Install" button that opens grid with extensions for installing.
     *
     * @var string
     */
    protected $installButton = "//div[contains(@class, 'item-install')]"
        . "//button[contains(@href, '#install-extension-grid')]";

    /**
     * Select action of extension on the grid.
     *
     * @var string
     */
    protected $selectAction = "//tr[td/*[contains(text(), '%s')]]//*[contains(@class, 'action-select')]";

    /**
     * Uninstall action of extension.
     *
     * @var string
     */
    protected $uninstallAction = "//tr[td/*[contains(text(), '%s')]]//*[contains(@ng-mousedown, 'uninstall')]";

    /**
     * Update action of extension.
     *
     * @var string
     */
    protected $updateAction = "//tr[td/*[contains(text(), '%s')]]//*[contains(@ng-mousedown, 'update')]";

    /**
     * Container that contains version of extension.
     *
     * @var string
     */
    protected $versionContainer = "//tr[td/*[contains(text(), '%s')]]//*[@data-type='version']";

    /**
     * Popup Loading.
     *
     * @var string
     */
    protected $popupLoading = '.popup popup-loading';

    /**
     * Click to 'Install' button.
     *
     * @return void
     */
    public function clickInstallButton()
    {
        $this->waitForElementNotVisible($this->popupLoading);
        $this->waitForElementVisible($this->installButton, Locator::SELECTOR_XPATH);
        $this->_rootElement->find($this->installButton, Locator::SELECTOR_XPATH)->click();
    }

    /**
     * Click to uninstall button.
     *
     * @param Extension $extension
     * @return void
     */
    public function clickUninstallButton(Extension $extension)
    {
        $this->clickSelectActionButton($extension);
        $button = $this->_rootElement->find(
            sprintf($this->uninstallAction, $extension->getExtensionName()),
            Locator::SELECTOR_XPATH
        );

        if ($button->isVisible()) {
            $button->click();
        }
    }

    /**
     * Get version of extension.
     *
     * @param Extension $extension
     * @return string
     */
    public function getVersion(Extension $extension)
    {
        return $this->_rootElement->find(
            sprintf($this->versionContainer, $extension->getExtensionName()),
            Locator::SELECTOR_XPATH
        )->getText();
    }

    /**
     * Click to update button.
     *
     * @param Extension $extension
     * @return void
     */
    public function clickUpdateButton(Extension $extension)
    {
        $this->clickSelectActionButton($extension);
        $button = $this->_rootElement->find(
            sprintf($this->updateAction, $extension->getExtensionName()),
            Locator::SELECTOR_XPATH
        );

        if ($button->isVisible()) {
            $button->click();
        }
    }

    /**
     * Click to Select action
     *
     * @param Extension $extension
     * @return void
     */
    protected function clickSelectActionButton(Extension $extension)
    {
        $this->_rootElement->find(
            sprintf($this->selectAction, $extension->getExtensionName()),
            Locator::SELECTOR_XPATH
        )->click();
    }
}
