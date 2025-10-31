import { test, expect } from '@playwright/test';

// Set timeout global untuk test ini: 5 menit
test.setTimeout(300000);

test('Login setup', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/login');
  await page.fill('input[name="identifier"]', '2041720100'); // sesuaikan lagi
  await page.fill('input[name="password"]', '12345678');
  await page.click('button[type="submit"]');
});
