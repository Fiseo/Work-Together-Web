import { test, expect } from '@playwright/test';

test('Un utilisateur peut se connecter', async ({ page }) => {
    await page.goto('/login');

    await page.getByTestId("mail").fill("jane@gmail.com");
    await page.getByTestId("password").fill('613670');

    await page.getByTestId("loginBtn").click();

    await expect(page).toHaveURL(/\//);
});
