import { test, expect, Page } from '@playwright/test';

test.setTimeout(300000); // 5 menit timeout

test.describe('Lamaran Magang Mahasiswa', () => {

  // Fungsi bantu untuk memilih dropdown Choices.js
  const pilihDropdown = async (page: Page, labelText: string, value: string) => {
    // Temukan elemen label terkait dropdown
    const label = page.locator(`label:has-text("${labelText}")`);
    const dropdown = label.locator('xpath=following-sibling::*//div[contains(@class, "choices")]');

    await dropdown.click(); // buka dropdown
    await page.waitForSelector('.choices__input', { timeout: 10000 });
    await page.locator('.choices__input').fill(value);
    await page.waitForTimeout(1000);

    // klik opsi yang muncul
    const option = page.locator(`.choices__list--dropdown .choices__item:has-text("${value}")`);
    await option.first().click();
  };

  // Login & buka menu Lamaran Magang
  test.beforeEach(async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'domcontentloaded', timeout: 120000 });
    await page.fill('input[name="identifier"]', '2041720107');
    await page.fill('input[name="password"]', '12345678');
    await page.click('button[type="submit"]');
    await page.waitForSelector('text=Dashboard', { timeout: 120000 });

    // Buka menu Lamaran Magang
    await page.click('text=Lamaran Magang', { timeout: 120000 });
    await page.waitForSelector('text=Data Lamaran Magang', { timeout: 120000 });
  });

  // TC_008 - Data valid
  test('TC_008 - Mahasiswa membuat lamaran magang baru dengan data valid', async ({ page }) => {
    await page.click('text=Lamar Magang Baru');
    await page.waitForSelector('text=Create Lamaran Magang');

    await pilihDropdown(page, 'Perusahaan Mitra', 'PT. Tokopedia');
    await pilihDropdown(page, 'Lowongan Magang', 'Magang Frontend di PT. Tokopedia');
    await page.fill('input[type="date"]', '2025-10-30');
    await page.click('button:has-text("Create")');

    await expect(page.locator('text=Data Lamaran Magang')).toBeVisible({ timeout: 120000 });
  });

  // TC_009 - Field lowongan kosong
  test('TC_009 - Mahasiswa membuat lamaran baru dengan field lowongan kosong', async ({ page }) => {
    await page.click('text=Lamar Magang Baru');
    await pilihDropdown(page, 'Perusahaan Mitra', 'PT. Tokopedia');
    await page.fill('input[type="date"]', '2025-10-30');
    await page.click('button:has-text("Create")');

    await expect(page.locator('text=Field lowongan magang wajib diisi')).toBeVisible({ timeout: 120000 });
  });

  // TC_010 - Tanggal sebelum hari ini
  test('TC_010 - Mahasiswa memilih tanggal pengajuan sebelum hari ini', async ({ page }) => {
    await page.click('text=Lamar Magang Baru');
    await pilihDropdown(page, 'Perusahaan Mitra', 'PT. Tokopedia');
    await pilihDropdown(page, 'Lowongan Magang', 'Magang Frontend di PT. Tokopedia');
    await page.fill('input[type="date"]', '2024-10-01');
    await page.click('button:has-text("Create")');

    await expect(page.locator('text=Tanggal pengajuan tidak boleh sebelum hari ini')).toBeVisible({ timeout: 120000 });
  });

  // TC_011 - Masih ada lamaran status diajukan
  test('TC_011 - Mahasiswa membuat lamaran baru saat masih ada status diajukan', async ({ page }) => {
    await page.click('text=Lamar Magang Baru');
    await pilihDropdown(page, 'Perusahaan Mitra', 'PT. Tokopedia');
    await pilihDropdown(page, 'Lowongan Magang', 'Magang Frontend di PT. Tokopedia');
    await page.fill('input[type="date"]', '2025-10-30');
    await page.click('button:has-text("Create")');

    await expect(page.locator('text=Masih ada lamaran yang berstatus diajukan')).toBeVisible({ timeout: 120000 });
  });

  // TC_012 - Masih ada lamaran status diterima
  test('TC_012 - Mahasiswa membuat lamaran baru saat masih ada status diterima', async ({ page }) => {
    await page.click('text=Lamar Magang Baru');
    await pilihDropdown(page, 'Perusahaan Mitra', 'PT. Tokopedia');
    await pilihDropdown(page, 'Lowongan Magang', 'Magang Frontend di PT. Tokopedia');
    await page.fill('input[type="date"]', '2025-10-30');
    await page.click('button:has-text("Create")');

    await expect(page.locator('text=Tidak dapat membuat lamaran baru karena status diterima')).toBeVisible({ timeout: 120000 });
  });

  // TC_013 - Hapus lamaran status diajukan
  test('TC_013 - Mahasiswa menghapus lamaran dengan status diajukan', async ({ page }) => {
    await page.waitForSelector('text=Data Lamaran Magang');
    await page.click('button:has-text("Delete")');
    await page.click('button:has-text("Ya")');
    await expect(page.locator('text=Berhasil menghapus lamaran')).toBeVisible({ timeout: 120000 });
  });

  // TC_014 - Hapus lamaran status diterima
  test('TC_014 - Mahasiswa menghapus lamaran dengan status diterima', async ({ page }) => {
    await page.waitForSelector('text=Data Lamaran Magang');
    await page.click('button:has-text("Delete")');
    await page.click('button:has-text("Ya")');
    await expect(page.locator('text=Tidak dapat menghapus lamaran yang sudah diterima')).toBeVisible({ timeout: 120000 });
  });
});
