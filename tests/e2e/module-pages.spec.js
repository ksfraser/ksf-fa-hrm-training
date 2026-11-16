const { test, expect } = require('@playwright/test');
const {
  faLogin,
  faLogout,
  verifyModulePage,
  BASE_URL,
} = require('./helpers/fa-helpers');

/**
 * Module Page Verification Tests
 *
 * After modules are installed and activated, these tests:
 *   1. Log in as sysadmin
 *   2. Navigate to each module's pages directly via URL
 *   3. Verify the page renders (HTTP 200, expected content)
 *   4. Log out and back in between module groups
 *
 * These tests require modules to be installed and activated first.
 */

const MODULE_PAGES = [
  { pkg: 'ksf_FA_HRM_LeaveApproval', label: 'Leave Approvals', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_HRM_Performance', label: 'Performance', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_HRM_Onboarding', label: 'Onboarding', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_HRM_Training', label: 'Training', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_HRM_Contracts', label: 'Contracts', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_CRM_Marketing', label: 'Marketing', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_CRM_Email', label: 'Email', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_CRM_Helpdesk', label: 'Helpdesk', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_CRM_Contracts', label: 'CRM Contracts', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_CRM_Dashboard', label: 'Dashboard', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_CRM_Activity', label: 'Activity', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_HRM_TimeTrackingPayrollIntegration', label: 'Payroll', path: 'index.php', expectedText: 'FrontAccounting' },
  { pkg: 'ksf_FA_ProjectManagement', label: 'Project Management', path: 'index.php', expectedText: 'FrontAccounting' },
];

test.describe('Verify Module Pages Render', () => {
  test.beforeEach(async ({ page }) => {
    await faLogin(page);
  });

  test.afterEach(async ({ page }) => {
    await faLogout(page);
  });

  for (const mod of MODULE_PAGES) {
    test(`${mod.label} index page renders`, async ({ page }) => {
      await verifyModulePage(page, mod.path, mod.expectedText, { moduleName: mod.pkg });
    });
  }
});
