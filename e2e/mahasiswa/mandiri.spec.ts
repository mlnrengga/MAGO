import { test, expect, Page } from '@playwright/test';

// Timeout global 5 menit
test.setTimeout(300000);

// Fungsi bantu untuk memilih dropdown (choices.js) dengan cara ketik + enter
async function pilihDropdown(page: Page, labelText: string, value: string) {
  const dropdown = page.locator(`div[role="combobox"]:has-text("${labelText}")`);
  await dropdown.click();
  await page.keyboard.type(value, { delay: 100 });
  await page.waitForTimeout(1000);
  await page.keyboard.press('Enter');
}

test.describe('Pengajuan Magang Mandiri', () => {
  test.beforeEach(async ({ page }) => {
    console.log('Login sebagai Mahasiswa');
    await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'domcontentloaded', timeout: 120000 });
    await page.fill('input[name="identifier"]', '2041720100');
    await page.fill('input[name="password"]', '12345678');
    await page.click('button[type="submit"]');

    await page.waitForSelector('text=Dashboard', { timeout: 120000 });

    console.log('Navigasi ke Pengajuan Magang Mandiri');
    await page.click('text=Pengajuan Magang Mandiri');
    await page.waitForSelector('text=Data Pengajuan Magang Mandiri', { timeout: 120000 });
  });

  // TC_015 
  test('TC_015 - Menambahkan data pengajuan magang valid', async ({ page }) => {
    await page.click('text=Ajukan Magang Mandiri');
    await page.waitForSelector('text=Create Pengajuan Magang Mandiri', { timeout: 120000 });

    // Pilih dropdown dengan ketik
    await pilihDropdown(page, 'Jenis Perusahaan', 'Perusahaan sudah terdaftar');
    await pilihDropdown(page, 'Nama Perusahaan', 'PT Tokopedia');
    await page.fill('input[name="posisi_magang"]', 'Magang Frontend di PT. Tokopedia');

    await pilihDropdown(page, 'Waktu Magang', '3 Bulan');
    await pilihDropdown(page, 'Periode Magang', 'Periode 1 - 2025');
    await pilihDropdown(page, 'Intensif', 'Ya');
    await pilihDropdown(page, 'Bidang Keahlian', 'Teknologi Informasi');
    await pilihDropdown(page, 'Provinsi', 'DKI Jakarta');
    await pilihDropdown(page, 'Daerah', 'Jakarta Selatan');

    await page.fill('textarea[name="deskripsi"]', 'Kegiatan magang di bidang front-end development bersama tim Tokopedia.');
    await page.fill('input[name="tanggal_mulai"]', '2025-11-10');
    await page.fill('input[name="tanggal_selesai"]', '2025-12-10');

    await page.click('button:has-text("Create")');

    await expect(page.locator('text=berhasil')).toBeVisible({ timeout: 120000 });
  });

  // TC_016 
  test('TC_016 - Menambahkan data pengajuan magang kosong', async ({ page }) => {
    await page.click('text=Ajukan Magang Mandiri');
    await page.waitForSelector('text=Create Pengajuan Magang Mandiri', { timeout: 120000 });
    await page.click('button:has-text("Create")');

    await expect(page.locator('text=Harap isi bidang ini')).toBeVisible({ timeout: 120000 });
  });

  // TC_017
  test('TC_017 - Membatalkan pengajuan magang', async ({ page }) => {
    await page.click('text=Ajukan Magang Mandiri');
    await page.waitForSelector('text=Create Pengajuan Magang Mandiri', { timeout: 120000 });
    await page.click('button:has-text("Cancel")');

    await expect(page.locator('text=Data Pengajuan Magang Mandiri')).toBeVisible({ timeout: 120000 });
  });

  // TC_018
  test('TC_018 - Tambah lebih dari satu pengajuan (Create & Create another)', async ({ page }) => {
    await page.click('text=Ajukan Magang Mandiri');
    await page.waitForSelector('text=Create Pengajuan Magang Mandiri', { timeout: 120000 });

    await pilihDropdown(page, 'Jenis Perusahaan', 'Perusahaan sudah terdaftar');
    await pilihDropdown(page, 'Nama Perusahaan', 'PT Tokopedia');
    await page.fill('input[name="posisi_magang"]', 'QA Tester di PT. Tokopedia');
    await pilihDropdown(page, 'Periode Magang', 'Periode 1 - 2025');

    await page.fill('textarea[name="deskripsi"]', 'Pengujian sistem magang batch 1 di Tokopedia.');
    await page.fill('input[name="tanggal_mulai"]', '2025-11-01');
    await page.fill('input[name="tanggal_selesai"]', '2025-12-01');

    await page.click('button:has-text("Create & create another")');

    await expect(page.locator('text=berhasil')).toBeVisible({ timeout: 120000 });
  });
});
