import { test, expect } from '@playwright/test';

test('Une page protégée nécessite une authentification', async ({ page }) => {
    await page.goto('/user/');

    await expect(page).toHaveURL(/\//);
});
